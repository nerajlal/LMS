<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\LiveClass;

class LiveClassController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        
        // Get all course IDs where the user has a confirmed enrollment
        $enrolledCourseIds = \App\Models\Admission::where('user_id', $userId)
            ->where('status', 'approved')
            ->pluck('course_id')
            ->toArray();

        // Fetch ALL live classes with course info
        $allClasses = LiveClass::with('course')
            ->latest()
            ->get();

        $now = \Carbon\Carbon::now();

        // Split into 3 categories: Active (During time OR status=live), Upcoming, Past
        $activeClasses = $allClasses->filter(function($class) use ($now) {
            $startTime = \Carbon\Carbon::parse($class->start_time);
            $durationMinutes = (int) preg_replace('/[^0-9]/', '', $class->duration) ?: 60;
            $endTime = $startTime->copy()->addMinutes($durationMinutes);
            return ($now->between($startTime, $endTime)) || strtolower($class->status) === 'live';
        })->sort(function($a, $b) use ($enrolledCourseIds) {
            // Priority 1: Enrolled vs Not Enrolled
            $aEnrolled = in_array($a->course_id, $enrolledCourseIds);
            $bEnrolled = in_array($b->course_id, $enrolledCourseIds);
            if ($aEnrolled && !$bEnrolled) return -1;
            if (!$aEnrolled && $bEnrolled) return 1;
            return \Carbon\Carbon::parse($a->start_time)->timestamp <=> \Carbon\Carbon::parse($b->start_time)->timestamp;
        });

        $upcomingClasses = $allClasses->filter(function($class) use ($now) {
            $startTime = \Carbon\Carbon::parse($class->start_time);
            return $now->lt($startTime) && strtolower($class->status) !== 'live';
        })->sort(function($a, $b) use ($enrolledCourseIds) {
            $aEnrolled = in_array($a->course_id, $enrolledCourseIds);
            $bEnrolled = in_array($b->course_id, $enrolledCourseIds);
            if ($aEnrolled && !$bEnrolled) return -1;
            if (!$aEnrolled && $bEnrolled) return 1;
            return \Carbon\Carbon::parse($a->start_time)->timestamp <=> \Carbon\Carbon::parse($b->start_time)->timestamp;
        });

        $pastClasses = $allClasses->filter(function($class) use ($now) {
            $startTime = \Carbon\Carbon::parse($class->start_time);
            $durationMinutes = (int) preg_replace('/[^0-9]/', '', $class->duration) ?: 60;
            $endTime = $startTime->copy()->addMinutes($durationMinutes);
            return $now->gt($endTime) && strtolower($class->status) !== 'live';
        });

        return view('live-classes.index', compact('activeClasses', 'upcomingClasses', 'pastClasses', 'enrolledCourseIds'));
    }
}
