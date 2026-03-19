<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Course;
use App\Models\Batch;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdmissionController extends Controller
{
    public function index()
    {
        $admissions = Admission::where('user_id', auth()->id())
            ->with(['course', 'batch'])
            ->latest()
            ->get()
            ->map(fn($a) => [
                'id'           => $a->id,
                'course'       => $a->course?->title,
                'batch'        => $a->batch?->name,
                'status'       => $a->status,
                'submitted_at' => $a->created_at->format('Y-m-d'),
            ]);

        return Inertia::render('Admissions/Index', compact('admissions'));
    }

    public function create()
    {
        return Inertia::render('Admissions/Create', [
            'courses' => Course::all(),
            'batches' => Batch::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name'          => 'required|string|max:255',
            'email'              => 'required|email|max:255',
            'phone'              => 'required|string|max:20',
            'course_id'         => 'required|exists:courses,id',
            'batch_id'          => 'nullable|exists:batches,id',
            'address'           => 'nullable|string',
            'previous_education' => 'nullable|string',
        ]);

        Admission::create([
            'user_id'   => auth()->id(),
            'course_id' => $data['course_id'],
            'batch_id'  => $data['batch_id'] ?? null,
            'status'    => 'pending',
            'details'   => json_encode([
                'full_name'          => $data['full_name'],
                'phone'              => $data['phone'],
                'address'            => $data['address'] ?? '',
                'previous_education' => $data['previous_education'] ?? '',
            ]),
        ]);

        return redirect()->route('admissions.index')->with('success', 'Application submitted!');
    }
}
