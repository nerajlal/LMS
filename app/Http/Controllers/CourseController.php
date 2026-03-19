<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return Inertia::render('Courses/Index', compact('courses'));
    }

    public function show($id)
    {
        $course = Course::with('lessons', 'batches')->findOrFail($id);
        return Inertia::render('Courses/Show', compact('course'));
    }
}
