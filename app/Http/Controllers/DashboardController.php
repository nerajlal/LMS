<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Admission;
use App\Models\Enrollment;
use App\Models\Fee;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // If admin, redirect to admin dashboard
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        // If trainer, redirect to trainer dashboard
        if ($user->is_trainer) {
            return redirect()->route('trainer.dashboard');
        }

        // Enrolled courses (from Enrollments table)
        // For now, if no enrollments, let's also pull approved admissions
        $enrolledIds = Enrollment::where('user_id', $user->id)->pluck('course_id');
        $approvedAdmissionIds = Admission::where('user_id', $user->id)
            ->where('status', 'approved')
            ->pluck('course_id');

        $activeCourseIds = $enrolledIds->merge($approvedAdmissionIds)->unique();

        $enrolledCourses = Course::whereIn('id', $activeCourseIds)
            ->withCount('lessons')
            ->get()
            ->map(function($course) {
                // Mocking progress for now
                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'instructor' => $course->instructor_name,
                    'progress' => rand(10, 90), // Mock progress
                    'lessons_count' => $course->lessons_count,
                ];
            });

        $stats = [
            'enrolled'       => $activeCourseIds->count(),
            'completed'      => 0,
            'wishlist'       => 0,
            'certifications' => 0,
            'liveClasses'    => 2, // Mocking
            'feesDue'        => number_format(Fee::where('user_id', $user->id)->where('status', 'pending')->sum('total_amount')),
        ];

        $upcomingClasses = \App\Models\LiveClass::where('status', 'upcoming')
            ->orderBy('start_time', 'asc')
            ->take(3)
            ->get()
            ->map(function($class) {
                return [
                    'id' => $class->id,
                    'title' => $class->title,
                    'time' => \Carbon\Carbon::parse($class->start_time)->format('M d, Y - g:i A'),
                    'host' => $class->instructor_name, // Optional based on UI
                ];
            });

        $topInstructors = \App\Models\User::where('is_trainer', true)
            ->take(5)
            ->get()
            ->map(function($trainer) {
                return [
                    'id' => $trainer->id,
                    'name' => $trainer->name,
                    'courses' => \App\Models\Course::where('instructor_name', $trainer->name)->count(),
                    'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($trainer->name) . '&background=random',
                ];
            });

        return view('dashboard', [
            'stats' => $stats,
            'enrolledCourses' => $enrolledCourses,
            'upcomingClasses' => $upcomingClasses,
            'topInstructors' => $topInstructors,
        ]);
    }
}
