<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Admission;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::withCount(['lessons', 'enrollments']);

        if (auth()->check()) {
            $query->withExists(['admissions' => function ($q) {
                $q->where('user_id', auth()->id())
                  ->where('status', 'approved');
            }]);
            
            // Sort by existence (False/0 first, True/1 last)
            $query->orderBy('admissions_exists', 'asc');
        }

        if ($request->has('instructor')) {
            $query->where('instructor_name', $request->instructor);
        }

        $courses = $query->latest('id')->get();
        return view('courses.index', compact('courses'));
    }

    public function show($id)
    {
        $course = Course::with(['lessons', 'batches', 'studyMaterials'])->findOrFail($id);
        $completedLessons = [];
        $progress = 0;
        $hasFeedback = false;
        $isEnrolled = false;

        if (auth()->check()) {
            $admission = Admission::where('user_id', auth()->id())
                ->where('course_id', $id)
                ->first();
            
            if ($admission) {
                $progress = $admission->progress ?? 0;
                $completedLessons = is_array($admission->completed_lessons) 
                    ? $admission->completed_lessons 
                    : json_decode($admission->completed_lessons ?? '[]', true);

                $hasFeedback = \App\Models\CourseFeedback::where('user_id', auth()->id())
                    ->where('course_id', $id)
                    ->exists();

                if (auth()->user()->is_admin || auth()->user()->is_trainer) {
                    $isEnrolled = true;
                } else {
                    $isEnrolled = $admission->status === 'approved';
                }
            } else {
                $isEnrolled = Enrollment::where('user_id', auth()->id())
                    ->where('course_id', $id)
                    ->where('status', 'active')
                    ->exists();
            }
        }

        return view('courses.show', [
            'course' => $course,
            'isEnrolled' => $isEnrolled,
            'completedLessons' => $completedLessons,
            'initialProgress' => $progress,
            'hasFeedback' => $hasFeedback
        ]);
    }

    public function updateProgress(Request $request, $id)
    {
        $admission = Admission::where('user_id', auth()->id())
            ->where('course_id', $id)
            ->firstOrFail();

        $lessonId = (int)$request->input('lesson_id');
        $completedLessons = is_array($admission->completed_lessons) 
            ? $admission->completed_lessons 
            : json_decode($admission->completed_lessons ?? '[]', true);

        if (!in_array($lessonId, $completedLessons)) {
            $completedLessons[] = $lessonId;
        }

        $course = Course::withCount('lessons')->find($id);
        $totalLessons = $course->lessons_count ?: 1;
        
        // Calculate progress based on unique completed lessons
        $newProgress = min(100, round((count($completedLessons) / $totalLessons) * 100));
        
        $admission->update([
            'completed_lessons' => $completedLessons,
            'progress' => $newProgress
        ]);

        return response()->json([
            'success' => true,
            'new_progress' => $newProgress,
            'completed_lessons' => $completedLessons
        ]);
    }
}
