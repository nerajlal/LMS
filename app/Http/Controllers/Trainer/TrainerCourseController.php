<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TrainerCourseController extends Controller
{
    /**
     * Display a listing of courses associated with the trainer.
     */
    public function index()
    {
        $courses = Course::withCount(['lessons', 'enrollments'])->get();

        return view('trainer.courses.index', [
            'courses' => $courses
        ]);
    }

    /**
     * Display the specified course management dashboard for a trainer.
     */
    public function show($id)
    {
        $course = Course::with(['lessons', 'studyMaterials'])->findOrFail($id);
        return view('trainer.courses.show', [
            'course' => $course
        ]);
    }

    /**
     * Store a new YouTube lesson.
     */
    public function storeLesson(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'required|url',
        ]);
        
        $validated['course_id'] = $course->id;
        $validated['order'] = \App\Models\Lesson::where('course_id', $course->id)->count() + 1;
        
        \App\Models\Lesson::create($validated);
        
        return redirect()->back()->with('success', 'Lesson added successfully!');
    }

    /**
     * Store a new PDF Study Material.
     */
    public function storeMaterial(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,zip|max:20480', // 20MB max
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9.\-]/', '_', $file->getClientOriginalName());
            $filePath = $file->storeAs('study_materials', $fileName, 'public');

            \App\Models\StudyMaterial::create([
                'course_id' => $course->id,
                'title' => $request->title,
                'file_path' => '/storage/' . $filePath,
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
            ]);
        }

        return redirect()->back()->with('success', 'Study material uploaded successfully!');
    }
}
