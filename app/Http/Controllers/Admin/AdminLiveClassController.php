<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LiveClass;
use App\Models\Course;
use Inertia\Inertia;
use Illuminate\Http\Request;

class AdminLiveClassController extends Controller
{
    public function index()
    {
        $liveClasses = LiveClass::with('course')->latest()->paginate(10);
        return Inertia::render('Admin/LiveClasses/Index', [
            'liveClasses' => $liveClasses
        ]);
    }

    public function create()
    {
        $courses = Course::all();
        return Inertia::render('Admin/LiveClasses/Create', [
            'courses' => $courses
        ]);
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
