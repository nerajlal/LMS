<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\LiveClass;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TrainerLiveClassController extends Controller
{
    /**
     * Display a listing of live classes.
     */
    public function index()
    {
        $classes = LiveClass::with('course')->latest()->get();

        return view('trainer.live-classes.index', [
            'classes' => $classes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = \App\Models\Course::select('id', 'title')->get();
        return view('trainer.live-classes.create', [
            'courses' => $courses
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'nullable|exists:courses,id',
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'duration' => 'required|string|max:50',
            'zoom_link' => 'required|url',
        ]);

        $validated['instructor_name'] = auth()->user()->name;
        $validated['status'] = 'scheduled';

        \App\Models\LiveClass::create($validated);

        return redirect()->route('trainer.live-classes.index')->with('success', 'Live class scheduled successfully.');
    }
}
