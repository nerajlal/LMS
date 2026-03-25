<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TrainerController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'courses' => \App\Models\Course::count(), // Placeholder for "assigned" courses
            'students' => \App\Models\User::where('is_admin', false)->where('is_trainer', false)->count(),
            'live_classes' => \App\Models\LiveClass::where('instructor_name', $user->name)->count(),
        ];

        return view('trainer.dashboard', [
            'stats' => $stats
        ]);
    }
}
