<?php

namespace App\Http\Controllers;

use App\Models\LiveClass;
use App\Models\LiveClassAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LiveClassAttendanceController extends Controller
{
    /**
     * Mark attendance for a student joining a live class.
     */
    public function markAttendance(Request $request, LiveClass $liveClass)
    {
        // Only mark if not already marked for this class today (or just once per class)
        LiveClassAttendance::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'live_class_id' => $liveClass->id,
            ],
            [
                'joined_at' => now(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Attendance recorded.'
        ]);
    }

    /**
     * Fetch the attendance list for a specific live session.
     */
    public function index(LiveClass $liveClass)
    {
        $user = Auth::user();
        
        // Comprehensive Authorization
        $isTrainerOfBatch = $liveClass->liveClassBranch && $liveClass->liveClassBranch->trainers->contains($user->id);
        $isCourseOwner = $liveClass->course && $liveClass->course->instructor_name === $user->name; // Fallback
        
        if (!$user->is_admin && !$isTrainerOfBatch && !$isCourseOwner) {
            return response()->json(['error' => 'Unauthorized Access Protocol'], 403);
        }

        $attendances = LiveClassAttendance::with('user')
            ->where('live_class_id', $liveClass->id)
            ->latest('joined_at')
            ->get();

        return response()->json([
            'success' => true,
            'attendances' => $attendances
        ]);
    }

    /**
     * Aggregate overall attendance stats for all students in a batch.
     */
    public function batchSummary(\App\Models\LiveClassBranch $branch)
    {
        $user = Auth::user();
        
        // Authorization
        $isTrainer = $branch->trainers->contains($user->id);
        if (!$user->is_admin && !$isTrainer) {
            return response()->json(['error' => 'Unauthorized Summary Request'], 403);
        }

        // Sessions held (Live or Completed)
        $sessionIds = $branch->liveClasses()
            ->whereIn('status', ['live', 'completed'])
            ->pluck('id');
            
        $totalSessions = $sessionIds->count();

        // Enrolled Students
        $admissions = \App\Models\Admission::with('user:id,name,email')
            ->where('batch_id', $branch->id)
            ->where('status', 'approved')
            ->get();

        $summary = $admissions->map(function ($admission) use ($sessionIds, $totalSessions) {
            $attendedCount = LiveClassAttendance::where('user_id', $admission->user_id)
                ->whereIn('live_class_id', $sessionIds)
                ->count();

            return [
                'student_name' => $admission->user->name ?? 'Unknown',
                'student_email' => $admission->user->email ?? 'N/A',
                'attended' => $attendedCount,
                'total' => $totalSessions,
                'percentage' => $totalSessions > 0 ? round(($attendedCount / $totalSessions) * 100) : 0,
            ];
        })->sortByDesc('percentage')->values();

        return response()->json([
            'success' => true,
            'batch_name' => $branch->name,
            'total_sessions' => $totalSessions,
            'summary' => $summary
        ]);
    }
}
