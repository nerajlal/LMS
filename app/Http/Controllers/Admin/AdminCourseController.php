<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Batch;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminCourseController extends Controller
{
    public function index()
    {
        $courses = Course::withCount(['admissions', 'enrollments', 'lessons'])
            ->latest()
            ->paginate(15);
        return Inertia::render('Admin/Courses/Index', compact('courses'));
    }

    public function create()
    {
        return Inertia::render('Admin/Courses/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:191',
            'description'     => 'nullable|string',
            'thumbnail'       => 'nullable|string|max:500',
            'price'           => 'required|numeric|min:0',
            'instructor_name' => 'required|string|max:191',
        ]);

        Course::create($validated);
        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully!');
    }

    public function edit(Course $course)
    {
        return Inertia::render('Admin/Courses/Create', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:191',
            'description'     => 'nullable|string',
            'thumbnail'       => 'nullable|string|max:500',
            'price'           => 'required|numeric|min:0',
            'instructor_name' => 'required|string|max:191',
        ]);

        $course->update($validated);
        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully!');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Course deleted.');
    }
}
