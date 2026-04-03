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
        $courseBatchMap = $admissions->pluck('batch_id', 'course_id')->toArray();

        // 1. Fetch ALL Batches (LiveClassBranch) with next upcoming session
        $allBatches = \App\Models\LiveClassBranch::with(['course', 'trainers', 'liveClasses' => function($q) {
            $q->where('start_time', '>=', now())->orderBy('start_time', 'asc');
        }])->get();

        // Identify Enrolled vs Available Batches
        $enrolledBatches = $allBatches->filter(fn($b) => in_array($b->id, $enrolledBatchIds))->values();
        $availableBatches = $allBatches->filter(fn($b) => !in_array($b->id, $enrolledBatchIds))->values();

        // 2. Fetch Individual Sessions for global view / recordings
        $allClasses = LiveClass::with(['course', 'liveClassBranch'])
            ->latest()
            ->get();

        $activeClasses = $allClasses->filter(fn($c) => $c->isLive())->values();
        $upcomingClasses = $allClasses->filter(fn($c) => $c->start_time->isFuture() && !$c->isLive())->values();
        
        $pastClasses = $allClasses->filter(function($c) use ($enrolledBatchIds, $enrolledCourseIds) {
            $isEnded = $c->isEnded() && strtolower($c->status) !== 'live';
            if (!$isEnded) return false;

            $user = auth()->user();
            if ($user->is_admin || $user->is_trainer) return true;

            // Student logic: check batch or course enrollment for general sessions
            $isEnrolledInBatch = in_array($c->live_class_branch_id, $enrolledBatchIds);
            $isGeneralSession = $c->live_class_branch_id === null && in_array($c->course_id, $enrolledCourseIds);

            return $isEnrolledInBatch || $isGeneralSession;
        })->values();

        return view('live-classes.index', compact(
            'enrolledBatches', 'availableBatches', 
            'activeClasses', 'upcomingClasses', 'pastClasses',
            'enrolledCourseIds', 'enrolledBatchIds', 'courseBatchMap'
        ));
    }

    public function showBatch(\App\Models\LiveClassBranch $branch)
    {
        $branch->load(['trainers', 'liveClasses' => function($q) {
            $q->where('start_time', '>=', now())->orderBy('start_time', 'asc');
        }]);

        $meta = $branch->getDisplayMetadata();
        
        return view('live-classes.show', compact('branch', 'meta'));
    }
}
