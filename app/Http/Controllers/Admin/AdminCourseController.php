<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Coupon;
use App\Models\User;
use App\Models\StudyMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminCourseController extends Controller
{
    /**
     * Store a new direct offer (coupon) for a course.
     */
    public function storeCoupon(Request $request)
    {
        $request->validate([
            'discount_amount' => 'required|numeric|min:1',
            'student_email' => 'required|email|max:255',
            'course_id' => 'required|exists:courses,id',
        ]);

        $code = 'OFFER-' . strtoupper(str_replace('.', '', uniqid('', true)));

        Coupon::create([
            'code' => $code,
            'discount_amount' => $request->discount_amount,
            'student_email' => $request->student_email,
            'course_id' => $request->course_id,
            'user_id' => auth()->id(),
            'is_used' => false,
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Direct offer generated successfully.');
    }

    public function feedback(Course $course)
    {
        $feedbacks = $course->feedbacks()->with('user')->latest()->get();
        return view('admin.courses.feedback.index', compact('course', 'feedbacks'));
    }

    public function index()
    {
        $courses = Course::withCount(['admissions', 'enrollments', 'lessons'])
            ->latest()
            ->paginate(15);
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $trainers = User::where('is_trainer', true)->orderBy('name')->get();
        return view('admin.courses.create', compact('trainers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'required|string',
            'thumbnail'         => 'nullable|file|image|max:2048',
            'youtube_link'      => 'nullable|string',
            'instructor_name'   => 'required|string|max:255',
            'price'             => 'required|numeric|min:0',
            'learning_outcomes' => 'nullable|string',
            'documents.*'       => 'nullable|file|mimes:pdf,doc,docx,zip|max:10240',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = '/storage/' . $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $course = Course::create([
            'title'             => $request->title,
            'description'       => $request->description,
            'thumbnail'         => $thumbnailPath ?? 'https://images.unsplash.com/photo-1587620962725-abab7fe55159?auto=format&fit=crop&q=80&w=600',
            'price'             => $request->price,
            'instructor_name'   => $request->instructor_name,
            'youtube_link'      => $request->youtube_link,
            'learning_outcomes' => $request->learning_outcomes,
        ]);

        // Handle initial study materials if uploaded
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9.\-]/', '_', $file->getClientOriginalName());
                $filePath = $file->storeAs('study_materials', $fileName, 'public');

                StudyMaterial::create([
                    'course_id' => $course->id,
                    'title'     => $file->getClientOriginalName(),
                    'file_path' => '/storage/' . $filePath,
                    'file_type' => $file->getClientOriginalExtension(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        return redirect()->route('admin.courses.index')->with('success', 'Course launched successfully with resources!');
    }

    public function edit(Course $course)
    {
        $trainers = User::where('is_trainer', true)->orderBy('name')->get();
        return view('admin.courses.create', compact('course', 'trainers'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'required|string',
            'thumbnail'         => 'nullable|file|image|max:2048',
            'youtube_link'      => 'nullable|string',
            'instructor_name'   => 'required|string|max:255',
            'price'             => 'required|numeric|min:0',
            'learning_outcomes' => 'nullable|string',
        ]);

        $updateData = [
            'title'             => $request->title,
            'description'       => $request->description,
            'price'             => $request->price,
            'instructor_name'   => $request->instructor_name,
            'youtube_link'      => $request->youtube_link,
            'learning_outcomes' => $request->learning_outcomes,
        ];

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if it exists and is local
            if ($course->thumbnail && str_starts_with($course->thumbnail, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $course->thumbnail));
            }
            $updateData['thumbnail'] = '/storage/' . $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $course->update($updateData);

        return redirect()->route('admin.courses.index')->with('success', 'Course intelligence updated successfully!');
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
