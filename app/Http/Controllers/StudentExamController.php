<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseExamResult;
use App\Models\Admission;
use Illuminate\Http\Request;

class StudentExamController extends Controller
{
    /**
     * Display the exam interface.
     */
    public function show(Course $course)
    {
        $user = auth()->user();
        $admission = Admission::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->firstOrFail();

        // Check if course is completed (100% progress)
        if ($admission->progress < 100) {
            return redirect()->route('courses.show', $course->id)
                ->with('error', 'You must complete all lessons before taking the final exam.');
        }

        $questions = $course->questions()->get();
        
        if ($questions->isEmpty()) {
            return redirect()->route('courses.show', $course->id)
                ->with('error', 'Exam is not yet available for this course.');
        }

        return view('student.exams.show', compact('course', 'questions', 'admission'));
    }

    /**
     * Process exam submission.
     */
    public function submit(Request $request, Course $course)
    {
        $user = auth()->user();
        $admission = Admission::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->firstOrFail();

        $questions = $course->questions()->get();
        $totalQuestions = $questions->count();
        $totalCorrect = 0;
        
        $userAnswers = $request->input('answers', []);

        foreach ($questions as $question) {
            $selectedOption = $userAnswers[$question->id] ?? null;
            if ($selectedOption === $question->correct_option) {
                $totalCorrect++;
            }
        }

        $score = ($totalCorrect / $totalQuestions) * 100;
        $status = $score >= 70 ? 'passed' : 'failed';

        $result = CourseExamResult::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'admission_id' => $admission->id,
            'total_questions' => $totalQuestions,
            'total_correct' => $totalCorrect,
            'score' => $score,
            'status' => $status,
        ]);

        return view('student.exams.result', compact('course', 'result'));
    }
}
