<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\LiveClass;

class LiveClassController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        
        $admissions = \App\Models\Admission::where('user_id', $userId)
            ->where('status', 'approved')
            ->get();

        $enrolledCourseIds = $admissions->pluck('course_id')->toArray();
        $enrolledBatchIds = $admissions->pluck('batch_id')->filter()->toArray();

        // Fetch ALL live classes so users can discover them
        $allClasses = LiveClass::with(['course', 'liveClassBranch'])
            ->latest()
            ->get();

        // Split into 3 categories: Active, Upcoming, Past
        $activeClasses = $allClasses->filter(function(LiveClass $class) {
            return $class->isLive();
        })->values();

        $upcomingClasses = $allClasses->filter(function(LiveClass $class) {
            return $class->start_time->isFuture() && !$class->isLive();
        })->values();

        $pastClasses = $allClasses->filter(function(LiveClass $class) {
            return $class->isEnded() && strtolower($class->status) !== 'live';
        })->values();

        return view('live-classes.index', compact('activeClasses', 'upcomingClasses', 'pastClasses', 'enrolledCourseIds', 'enrolledBatchIds'));
    }
}
