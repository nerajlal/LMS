<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseQuestion;
use Illuminate\Http\Request;

class AdminQuizController extends Controller
{
    public function index(Course $course)
    {
        $course->load('questions');
        return view('admin.courses.quiz.index', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'question'       => 'required|string',
            'option_a'       => 'required|string',
            'option_b'       => 'required|string',
            'option_c'       => 'required|string',
            'option_d'       => 'required|string',
            'correct_option' => 'required|in:a,b,c,d',
            'points'         => 'nullable|integer|min:1',
        ]);

        $course->questions()->create($validated);

        return redirect()->back()->with('success', 'Question added successfully!');
    }

    public function destroy(CourseQuestion $question)
    {
        $question->delete();
        return redirect()->back()->with('success', 'Question removed successfully!');
    }
}
