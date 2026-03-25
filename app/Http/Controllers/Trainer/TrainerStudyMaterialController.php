<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\StudyMaterial;
use App\Models\Course;
use Illuminate\Http\Request;

class TrainerStudyMaterialController extends Controller
{
    public function index()
    {
        $materials = StudyMaterial::whereHas('course', function($q) {
            $q->where('instructor_name', auth()->user()->name);
        })->with('course')->latest()->paginate(10);
        
        return view('trainer.materials.index', compact('materials'));
    }

    public function create()
    {
        $courses = Course::where('instructor_name', auth()->user()->name)->get();
        return view('trainer.materials.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,zip|max:20480',
        ]);

        // Security check: Ensure course belongs to this trainer
        $course = Course::where('id', $request->course_id)
                        ->where('instructor_name', auth()->user()->name)
                        ->firstOrFail();

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('study_materials', $fileName, 'public');

            StudyMaterial::create([
                'course_id' => $request->course_id,
                'title' => $request->title,
                'file_path' => '/storage/' . $filePath,
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
            ]);
        }

        return redirect()->route('trainer.study-materials.index')
            ->with('success', 'Study material uploaded successfully!');
    }

    public function destroy(StudyMaterial $studyMaterial)
    {
        $studyMaterial->delete();
        return redirect()->route('trainer.study-materials.index')
            ->with('success', 'Material removed!');
    }
}
