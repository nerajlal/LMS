<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\LiveClass;
use App\Models\Coupon;
use Illuminate\Http\Request;

class TrainerLiveClassController extends Controller
{
    /**
     * Store a new coupon for a batch.
     */
    public function storeCoupon(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'discount_amount' => 'required|numeric|min:1',
            'batch_id' => 'required|exists:live_class_branches,id',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['is_used'] = false;

        Coupon::create($validated);

        return redirect()->route('trainer.live-classes.index')->with('success', 'Coupon code generated successfully.');
    }

    /**
     * Display a listing of live classes grouped by branches.
     */
    public function index(Request $request)
    {
        $trainerName = auth()->user()->name;
        $status = $request->query('status', 'active');
        
        // Get all branches where this trainer is either the creator or a collaborator
        $branches = \App\Models\LiveClassBranch::where('status', $status)
            ->where(function($query) {
                $query->where('trainer_id', auth()->id())
                      ->orWhereHas('trainers', function($q) {
                          $q->where('users.id', auth()->id());
                      });
            })
            ->with(['liveClasses' => function($query) {
                $query->orderBy('start_time', 'asc');
            }, 'course', 'trainers'])
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
            'currentStatus' => $status
        ]);
    }

    /**
     * Show the form for creating a new batch.
     */
    public function createBranch()
    {
        return view('trainer.live-classes.batches.form', [
            'isEdit' => false,
            'branch' => new \App\Models\LiveClassBranch()
        ]);
    }

    /**
     * Show the form for editing an existing batch.
     */
    public function editBranch(\App\Models\LiveClassBranch $branch)
    {
        // Authorization
        if ($branch->trainer_id !== auth()->id() && !$branch->trainers()->where('users.id', auth()->id())->exists()) {
            abort(403);
        }

        return view('trainer.live-classes.batches.form', [
            'isEdit' => true,
            'branch' => $branch
        ]);
    }

    /**
     * Update an existing branch.
     */
    public function updateBranch(Request $request, \App\Models\LiveClassBranch $branch)
    {
        // Authorization
        if ($branch->trainer_id !== auth()->id() && !$branch->trainers()->where('users.id', auth()->id())->exists()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'learning_outcomes' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $validated;

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $data['thumbnail'] = '/storage/' . $path;
        }

        $branch->update($data);

        return redirect()->route('trainer.live-classes.index')->with('success', 'Batch updated successfully.');
    }

    /**
     * Store a new branch.
     */
    public function storeBranch(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'course_id' => 'nullable|exists:courses,id',
            'description' => 'required|string',
            'learning_outcomes' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $validated;
        $data['trainer_id'] = auth()->id();
        
        // If course is skipped, it's definitely standalone
        $data['is_standalone'] = empty($request->course_id);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $data['thumbnail'] = '/storage/' . $path;
        }

        $branch = \App\Models\LiveClassBranch::create($data);
        
        // Auto-attach the creator as the first collaborator
        $branch->trainers()->attach(auth()->id());

        return redirect()->route('trainer.live-classes.index')->with('success', 'Batch created successfully with metadata.');
    }

    /**
     * Mark a branch as complete.
     */
    public function completeBranch(\App\Models\LiveClassBranch $branch)
    {
        // Authorization
        if ($branch->trainer_id !== auth()->id() && !$branch->trainers()->where('users.id', auth()->id())->exists()) {
            abort(403);
        }

        $branch->update(['status' => 'completed']);

        return redirect()->route('trainer.live-classes.index', ['status' => 'completed'])
            ->with('success', 'Batch marked as completed and archived.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $courses = \App\Models\Course::where('instructor_name', auth()->user()->name)->select('id', 'title')->get();
        $branches = \App\Models\LiveClassBranch::where('status', 'active')
            ->where(function($query) {
                $query->where('trainer_id', auth()->id())
                      ->orWhereHas('trainers', function($q) {
                          $q->where('users.id', auth()->id());
                      });
            })->get();
        
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

        // Authorization: Ensure trainer is assigned to the branch
        if ($request->filled('live_class_branch_id')) {
            $branch = \App\Models\LiveClassBranch::findOrFail($request->live_class_branch_id);
            if ($branch->trainer_id !== auth()->id() && !$branch->trainers()->where('users.id', auth()->id())->exists()) {
                abort(403, 'Unauthorized access to this batch.');
            }
        }

        \App\Models\LiveClass::create($validated);

        return redirect()->route('trainer.live-classes.index')->with('success', 'Live class scheduled successfully.');
    }

    /**
     * Update the recording URL for a live class.
     */
    public function updateRecording(Request $request, LiveClass $liveClass)
    {
        // Authorization: Ensure trainer is assigned to the branch
        if ($liveClass->live_class_branch_id) {
            $branch = \App\Models\LiveClassBranch::findOrFail($liveClass->live_class_branch_id);
            if ($branch->trainer_id !== auth()->id() && !$branch->trainers()->where('users.id', auth()->id())->exists()) {
                abort(403, 'Unauthorized access to this batch.');
            }
        }

        $validated = $request->validate([
            'recording_url' => 'required|url',
            'recording_description' => 'nullable|string|max:500',
        ]);

        $liveClass->update($validated);

        return redirect()->back()->with('success', 'Session recording updated successfully.');
    }
}
