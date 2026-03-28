<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\LiveClass;
use Illuminate\Http\Request;

class TrainerLiveClassController extends Controller
{
    /**
     * Display a listing of live classes grouped by branches.
     */
    public function index()
    {
        $trainerName = auth()->user()->name;
        
        // Get all branches created by this trainer, with their classes
        $branches = \App\Models\LiveClassBranch::where('trainer_id', auth()->id())
            ->with(['liveClasses' => function($query) {
                $query->orderBy('start_time', 'asc');
            }, 'course'])
            ->latest()
            ->get();

        // Also get classes that might not be in a branch (legacy or general)
        $unbranchedClasses = LiveClass::where('instructor_name', $trainerName)
            ->whereNull('live_class_branch_id')
            ->with('course')
            ->latest()
            ->get();

        $courses = \App\Models\Course::where('instructor_name', $trainerName)->get();

        return view('trainer.live-classes.index', [
            'branches' => $branches,
            'unbranchedClasses' => $unbranchedClasses,
            'courses' => $courses
        ]);
    }

    /**
     * Store a new branch.
     */
    public function storeBranch(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        $validated['trainer_id'] = auth()->id();
        $validated['status'] = 'active';

        \App\Models\LiveClassBranch::create($validated);

        return redirect()->route('trainer.live-classes.index')->with('success', 'Branch created successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $courses = \App\Models\Course::where('instructor_name', auth()->user()->name)->select('id', 'title')->get();
        $branches = \App\Models\LiveClassBranch::where('trainer_id', auth()->id())->get();
        
        $selectedBranchId = $request->query('branch_id');
        $selectedCourseId = null;

        if ($selectedBranchId) {
            $branch = \App\Models\LiveClassBranch::find($selectedBranchId);
            if ($branch) {
                $selectedCourseId = $branch->course_id;
            }
        }

        return view('trainer.live-classes.create', [
            'courses' => $courses,
            'branches' => $branches,
            'selectedBranchId' => $selectedBranchId,
            'selectedCourseId' => $selectedCourseId
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'nullable|exists:courses,id',
            'live_class_branch_id' => 'nullable|exists:live_class_branches,id',
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'duration' => 'required|string|max:50',
            'zoom_link' => 'required|url',
        ]);

        $validated['instructor_name'] = auth()->user()->name;
        $validated['status'] = 'scheduled';

        \App\Models\LiveClass::create($validated);

        return redirect()->route('trainer.live-classes.index')->with('success', 'Live class scheduled successfully.');
    }
}
