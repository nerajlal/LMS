<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Course;
use App\Models\Batch;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        
        $allAdmissions = Admission::where('user_id', $userId)
            ->with(['course' => function($query) {
                $query->withCount(['lessons', 'studyMaterials']);
            }, 'batch'])
            ->latest()
            ->get();

        // Categorize for Tabbed UI
        $inProgress = $allAdmissions->filter(function($a) {
            return $a->status === 'approved' && ($a->progress ?? 0) < 100;
        });

        $completed = $allAdmissions->filter(function($a) {
            return $a->status === 'approved' && ($a->progress ?? 0) == 100;
        });

        $pending = $allAdmissions->filter(function($a) {
            return in_array($a->status, ['pending', 'rejected']);
        });

        $stats = [
            'in_progress' => $inProgress->count(),
            'completed'   => $completed->count(),
            'pending'     => $pending->count(),
        ];

        return view('admissions.index', compact('inProgress', 'completed', 'pending', 'stats'));
    }

    public function create()
    {
        return view('admissions.create', [
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
