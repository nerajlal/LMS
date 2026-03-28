<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Batch;
use Illuminate\Http\Request;

class AdminCourseController extends Controller
{
    public function index()
    {
        $courses = Course::withCount(['admissions', 'enrollments', 'lessons'])
            ->latest()
            ->paginate(15);
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');
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
        return view('admin.courses.create', compact('course'));
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

    public function apiShow(Course $course)
    {
        return response()->json([
            'title' => $course->title,
            'description' => $course->description ?? 'No description provided.',
            'instructor' => $course->instructor_name,
            'price' => number_format($course->price, 2),
            'lessons' => $course->lessons()->count(),
            'students' => $course->admissions()->count(),
            'thumbnail' => $course->thumbnail ?? asset('images/course-placeholder.jpg'),
            'outcomes' => $course->learning_outcomes ?? 'General educational outcomes.',
        ]);
    }

    public function apiTrainerCourses(Request $request)
    {
        $name = $request->query('name');
        $courses = Course::where('instructor_name', $name)->get();
        
        return response()->json([
            'trainer' => $name,
            'courses' => $courses->map(fn(\App\Models\Course $c) => [
                'id' => $c->id,
                'title' => $c->title,
                'price' => number_format($c->price, 2),
                'lessons' => $c->lessons()->count(),
            ])
        ]);
    }
}
