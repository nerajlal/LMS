<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'courses' => \App\Models\Course::where('instructor_name', $user->name)->count(),
            'students' => \App\Models\Admission::whereHas('course', function($q) use ($user) {
                $q->where('instructor_name', $user->name);
            })->count(),
            'live_classes' => \App\Models\LiveClass::where('instructor_name', $user->name)->count(),
        ];

        $recentCourses = \App\Models\Course::where('instructor_name', $user->name)
            ->withCount('lessons')
            ->latest()
            ->take(5)
            ->get();

        return view('trainer.dashboard', [
            'stats' => $stats,
            'recentCourses' => $recentCourses
        ]);
    }
}
