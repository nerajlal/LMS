<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseFeedback;
use Illuminate\Http\Request;

class CourseFeedbackController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        CourseFeedback::updateOrCreate(
            ['user_id' => auth()->id(), 'course_id' => $course->id],
            $validated
        );

        return back()->with('success', 'Thank you for your valuable feedback!');
    }
}
