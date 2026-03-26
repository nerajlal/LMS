<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\LiveClass;

class LiveClassController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        
        // Get all course IDs where the user has an admission
        $enrolledCourseIds = \App\Models\Admission::where('user_id', $userId)
            ->pluck('course_id');

        // Filter live classes by these course IDs
        $classes = LiveClass::whereIn('course_id', $enrolledCourseIds)
            ->with('course')
            ->latest()
            ->get();

        return view('live-classes.index', compact('classes'));
    }
}
