<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudyMaterial;
use App\Models\Course;
use Illuminate\Http\Request;

class AdminStudyMaterialController extends Controller
{
    public function index()
    {
        $materials = StudyMaterial::with('course')->latest()->paginate(10);
        return view('admin.materials.index', compact('materials'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('admin.materials.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'file_path' => 'required|string|max:255',
            'file_type' => 'required|string|max:20',
            'file_size' => 'required|string|max:20',
        ]);

        StudyMaterial::create($validated);

        return redirect()->route('admin.study-materials.index')
            ->with('success', 'Study material added successfully!');
    }

    public function destroy(StudyMaterial $studyMaterial)
    {
        $studyMaterial->delete();
        return redirect()->route('admin.study-materials.index')
            ->with('success', 'Study material removed!');
    }
}
