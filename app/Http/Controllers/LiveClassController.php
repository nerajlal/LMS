<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\LiveClass;

class LiveClassController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        
        // Get all approved admissions for the student
        $admissions = \App\Models\Admission::where('user_id', $userId)
            ->where('status', 'approved')
            ->get();

        $enrolledCourseIds = $admissions->pluck('course_id')->toArray();
        $enrolledBatchIds = $admissions->pluck('batch_id')->filter()->toArray();

        // Fetch live classes ONLY for the batches the student is enrolled in
        $allClasses = LiveClass::whereIn('live_class_branch_id', $enrolledBatchIds)
            ->with('course')
            ->latest()
            ->get();

        // Split into 3 categories: Active, Upcoming, Past
        $activeClasses = $allClasses->filter(function(LiveClass $class) {
            return !$class->isEnded() && (strtolower($class->status) === 'live' || $class->start_time->isPast());
        })->values();

        $upcomingClasses = $allClasses->filter(function(LiveClass $class) {
            return $class->start_time->isFuture() && strtolower($class->status) !== 'live';
        })->values();

        $pastClasses = $allClasses->filter(function(LiveClass $class) {
            return $class->isEnded() && strtolower($class->status) !== 'live';
        })->values();

        return view('live-classes.index', compact('activeClasses', 'upcomingClasses', 'pastClasses', 'enrolledCourseIds'));
    }
}
