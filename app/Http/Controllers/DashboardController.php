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

        $liveBatchesCount = Admission::where('user_id', $user->id)
            ->where('status', 'approved')
            ->whereNotNull('batch_id')
            ->distinct('batch_id')
            ->count('batch_id');

        $stats = [
            'enrolled'       => $admissions->count(),
            'completed'      => $admissions->where('progress', 100)->count(),
            'live_batches'   => $liveBatchesCount,
            'certifications' => $admissions->where('progress', 100)->count(), // Assuming cert on 100%
        ];

        $enrolledBatchIds = $admissions->pluck('batch_id')->filter()->toArray();

        $upcomingClasses = \App\Models\LiveClass::whereIn('live_class_branch_id', $enrolledBatchIds)
            ->with('liveClassBranch')
            ->where('status', 'scheduled')
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
                    'batch_name' => $class->liveClassBranch->name ?? 'General Session',
                ];
            });

        // Optimize trainer course counts by pre-fetching counts
        $trainerNames = \App\Models\User::where('is_trainer', true)->take(5)->pluck('name')->toArray();
        $courseCounts = \App\Models\Course::whereIn('instructor_name', $trainerNames)
            ->selectRaw('instructor_name, count(*) as count')
            ->groupBy('instructor_name')
            ->pluck('count', 'instructor_name')
            ->toArray();

        $topInstructors = \App\Models\User::where('is_trainer', true)
            ->take(5)
            ->get()
            ->map(function($trainer) use ($courseCounts) {
                return [
                    'id' => $trainer->id,
                    'name' => $trainer->name,
                    'courses' => $courseCounts[$trainer->name] ?? 0,
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
