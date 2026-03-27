<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Admission;
use App\Models\Enrollment;
use App\Models\Fee;

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

        // Enrolled courses (from Enrollments table + Approved Admissions)
        $admissions = Admission::where('user_id', $user->id)
            ->where('status', 'approved')
            ->with(['course' => function($query) {
                $query->withCount('lessons');
            }])
            ->get()
            ->filter(fn($a) => $a->course !== null);

        $enrolledCourses = $admissions->map(function($admission) {
            return [
                'id' => $admission->course->id,
                'title' => $admission->course->title,
                'instructor' => $admission->course->instructor_name,
                'progress' => $admission->progress ?? 0,
                'lessons_count' => $admission->course->lessons_count,
                'thumbnail' => $admission->course->thumbnail,
                'certificate_path' => $admission->certificate_path
            ];
        });

        $stats = [
            'enrolled'       => $admissions->count(),
            'completed'      => $admissions->where('progress', 100)->count(),
            'wishlist'       => 0, // No wishlist table currently
            'certifications' => $admissions->where('progress', 100)->count(), // Assuming cert on 100%
        ];

        $upcomingClasses = \App\Models\LiveClass::where('status', 'scheduled')
            ->where('start_time', '>=', now())
            ->orderBy('start_time', 'asc')
            ->take(3)
            ->get()
            ->map(function($class) {
                return [
                    'id' => $class->id,
                    'title' => $class->title,
                    'time' => $class->start_time,
                    'host' => $class->instructor_name,
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
