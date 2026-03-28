<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LiveClass;
use App\Models\Course;
use Illuminate\Http\Request;

class AdminLiveClassController extends Controller
{
    public function index()
    {
        $branches = \App\Models\LiveClassBranch::with(['liveClasses' => function($query) {
            $query->orderBy('start_time', 'asc');
        }, 'course', 'trainer'])
        ->latest()
        ->get();

        $unbranchedClasses = LiveClass::whereNull('live_class_branch_id')
            ->with(['course'])
            ->latest()
            ->get();

        return view('admin.live-classes.index', compact('branches', 'unbranchedClasses'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('admin.live-classes.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'instructor_name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'duration' => 'required|string|max:255',
            'zoom_link' => 'required|url',
            'status' => 'required|string|in:upcoming,live,completed',
        ]);

        LiveClass::create($validated);

        return redirect()->route('admin.live-classes.index')
            ->with('success', 'Live class scheduled successfully!');
    }

    public function destroy(LiveClass $liveClass)
    {
        $liveClass->delete();
        return redirect()->route('admin.live-classes.index')
            ->with('success', 'Live class deleted!');
    }
}
