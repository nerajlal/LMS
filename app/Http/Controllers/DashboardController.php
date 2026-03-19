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
            'enrolled'    => $activeCourseIds->count(),
            'completed'   => 0,
            'liveClasses' => 2, // Mocking
            'feesDue'     => number_format(Fee::where('user_id', $user->id)->where('status', 'pending')->sum('total_amount')),
        ];

        // Mocking upcoming classes
        $upcomingClasses = [
            [
                'id' => 1,
                'title' => 'Deep Dive into React Hooks',
                'time' => 'Today, 4:00 PM',
                'host' => 'Prof. Rao',
            ],
            [
                'id' => 2,
                'title' => 'Exploratory Data Analysis',
                'time' => 'Tomorrow, 10:30 AM',
                'host' => 'Prof. Sharma',
            ]
        ];

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'enrolledCourses' => $enrolledCourses,
            'upcomingClasses' => $upcomingClasses,
        ]);
    }
}
