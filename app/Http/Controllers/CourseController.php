<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Admission;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::withCount(['lessons', 'enrollments'])->get();
        return Inertia::render('Courses/Index', compact('courses'));
    }

    public function show($id)
    {
        $course = Course::with(['lessons', 'batches'])->findOrFail($id);
        $isEnrolled = false;
        
        if (auth()->check()) {
            if (auth()->user()->isAdmin() || auth()->user()->isTrainer()) {
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

        return Inertia::render('Courses/Show', [
            'course' => $course,
            'isEnrolled' => $isEnrolled
        ]);
    }
}
