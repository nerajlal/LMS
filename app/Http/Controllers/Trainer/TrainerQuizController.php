<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseQuestion;
use Illuminate\Http\Request;

class TrainerQuizController extends Controller
{
    /**
     * Helper to authorize trainer for a specific course.
     */
    private function authorizeTrainer(Course $course)
    {
        if ($course->instructor_name !== auth()->user()->name) {
            abort(403, 'Unauthorized access to this course assessment bank.');
        }
    }

    /**
     * Display the quiz management interface for trainers.
     */
    public function index(Course $course)
    {
        $this->authorizeTrainer($course);
        
        $questions = $course->questions()->latest()->get();
        return view('trainer.courses.quiz.index', compact('course', 'questions'));
    }

    /**
     * Store a new question in the course bank.
     */
    public function store(Request $request, Course $course)
    {
        $this->authorizeTrainer($course);

        $validated = $request->validate([
            'question' => 'required|string|max:500',
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'required|string|max:255',
            'option_d' => 'required|string|max:255',
            'correct_option' => 'required|in:a,b,c,d',
        ]);

        $course->questions()->create($validated);

        return back()->with('success', 'Queston recorded successfully.');
    }

    /**
     * Delete a question from the course bank.
     */
    public function destroy(Course $course, CourseQuestion $question)
    {
        $this->authorizeTrainer($course);
        
        // Extra check to ensure question belongs to this course
        if ($question->course_id !== $course->id) {
            abort(403, 'Invalid identity mapping detected.');
        }

        $question->delete();

        return back()->with('success', 'Question purged from curriculum.');
    }
}
