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

        if ($request->has('instructor')) {
            $query->where('instructor_name', $request->instructor);
        }

        $courses = $query->get();
        return view('courses.index', compact('courses'));
    }

    public function show($id)
    {
        $course = Course::with(['lessons', 'batches', 'studyMaterials'])->findOrFail($id);
        $isEnrolled = false;
        
        if (auth()->check()) {
            if (auth()->user()->is_admin || auth()->user()->is_trainer) {
                $isEnrolled = true;
            } else {
                $isEnrolled = Enrollment::where('user_id', auth()->id())
                    ->where('course_id', $id)
                    ->where('status', 'active')
                    ->exists();
                    
                // Also check approved admissions as a fallback for demo
                if (!$isEnrolled) {
                    $isEnrolled = Admission::where('user_id', auth()->id())
                        ->where('course_id', $id)
                        ->where('status', 'approved')
                        ->exists();
                }
            }
        }

        return view('courses.show', [
            'course' => $course,
            'isEnrolled' => $isEnrolled
        ]);
    }

    public function updateProgress(Request $request, $id)
    {
        $admission = Admission::where('user_id', auth()->id())
            ->where('course_id', $id)
            ->firstOrFail();

        $course = Course::withCount('lessons')->find($id);
        $increment = $course->lessons_count > 0 ? floor(100 / $course->lessons_count) : 10;
        
        $newProgress = min(100, ($admission->progress ?? 0) + $increment);
        $admission->update(['progress' => $newProgress]);

        return response()->json([
            'success' => true,
            'new_progress' => $newProgress
        ]);
    }
}
