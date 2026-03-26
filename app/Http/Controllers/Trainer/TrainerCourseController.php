<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\StudyMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TrainerCourseController extends Controller
{
    /**
     * Display a listing of courses associated with the trainer.
     */
    public function index()
    {
        $courses = Course::where('instructor_name', auth()->user()->name)
            ->withCount(['lessons', 'enrollments'])
            ->latest()
            ->get();
    
        return view('trainer.courses.index', compact('courses'));
    }

    /**
     * Show form to create a new course.
     */
    public function create()
    {
        return view('trainer.courses.create');
    }

    /**
     * Store a newly created course.
     */
    public function store(Request $request)
    {
        Log::info('Course creation attempt started.', ['request' => $request->except('thumbnail', 'documents')]);

        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'thumbnail' => 'nullable|file|image|max:2048',
                'youtube_link' => 'nullable|string',
                'price' => 'nullable|numeric|min:0',
                'learning_outcomes' => 'nullable|string',
                'documents.*' => 'nullable|file|mimes:pdf,doc,docx,zip|max:10240',
            ]);

            $thumbnailPath = null;
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = '/storage/' . $request->file('thumbnail')->store('thumbnails', 'public');
                Log::info('Thumbnail uploaded.', ['path' => $thumbnailPath]);
            }

            $course = Course::create([
                'title' => $request->title,
                'description' => $request->description,
                'thumbnail' => $thumbnailPath ?? 'https://images.unsplash.com/photo-1587620962725-abab7fe55159?auto=format&fit=crop&q=80&w=600',
                'instructor_name' => auth()->user()->name,
                'price' => $request->price ?? 0,
                'youtube_link' => $request->youtube_link,
                'learning_outcomes' => $request->learning_outcomes,
            ]);

            Log::info('Course created successfully.', ['id' => $course->id]);

            // Handle initial documents if provided
            if ($request->hasFile('documents')) {
                Log::info('Handling initial documents.', ['count' => count($request->file('documents'))]);
                foreach ($request->file('documents') as $file) {
                    $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9.\-]/', '_', $file->getClientOriginalName());
                    $filePath = $file->storeAs('study_materials', $fileName, 'public');

                    StudyMaterial::create([
                        'course_id' => $course->id,
                        'title' => $file->getClientOriginalName(),
                        'file_path' => '/storage/' . $filePath,
                        'file_type' => $file->getClientOriginalExtension(),
                        'file_size' => $file->getSize(),
                    ]);
                }
                Log::info('Documents uploaded and attached.');
            }

            return redirect()->route('trainer.courses.index')
                ->with('success', 'Course created with premium features!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation failed during course creation.', ['errors' => $e->errors()]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Fatal error during course creation.', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'An unexpected error occurred: ' . $e->getMessage()]);
        }
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

    /**
     * Remove the specified course from storage.
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);

        // Delete thumbnail if it exists and is not a default URL
        if ($course->thumbnail && str_starts_with($course->thumbnail, '/storage/')) {
            $path = str_replace('/storage/', '', $course->thumbnail);
            \Illuminate\Support\Facades\Storage::disk('public')->delete($path);
        }

        $course->delete();

        return redirect()->route('trainer.courses.index')
            ->with('success', 'Course and all associated content deleted successfully!');
    }
}
