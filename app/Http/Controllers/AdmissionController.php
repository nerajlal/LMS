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
            }, 'batch', 'latestExamResult'])
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
        ]);
    }

    /**
     * Express Enrollment: Creates an admission record instantly using user profile data.
     */
    public function expressEnroll(Request $request)
    {
        $batchId = $request->query('batch_id');
        $courseId = $request->query('course_id');

        if (!$batchId && !$courseId) {
            return redirect()->route('courses.index')->with('error', 'Select a program to enroll.');
        }

        $user = auth()->user();

        // 1. Check for existing enrollment to prevent duplicates
        $existing = Admission::where('user_id', $user->id)
            ->where(function($q) use ($batchId, $courseId) {
                if ($batchId) $q->where('batch_id', $batchId);
                if ($courseId) $q->where('course_id', $courseId);
            })
            ->first();

        if ($existing) {
            if ($existing->status === 'approved') {
                return redirect()->route('admissions.index')->with('info', 'You are already enrolled in this program.');
            }
            return redirect()->route('admissions.checkout', $existing->id);
        }

        // 2. Resolve Price and Data
        $price = 0;
        $activeBatchId = null;
        $activeCourseId = null;

        if ($batchId) {
            $batch = \App\Models\LiveClassBranch::findOrFail($batchId);
            $price = $batch->is_standalone ? $batch->price : ($batch->course->price ?? 0);
            $activeBatchId = $batch->id;
            $activeCourseId = $batch->course_id;
        } else {
            $course = Course::findOrFail($courseId);
            $price = $course->price;
            $activeCourseId = $course->id;
        }

        // 3. Create Admission with Default Profile Data
        $admission = Admission::create([
            'user_id'   => $user->id,
            'course_id' => $activeCourseId,
            'batch_id'  => $activeBatchId,
            'status'    => ($price > 0) ? 'pending' : 'approved',
            'details'   => json_encode([
                'full_name'          => $user->name,
                'whatsapp_number'    => 'Not Provided',
                'address'            => '',
                'previous_education' => '',
            ]),
        ]);

        // 4. Create Financial Ledger Entry
        \App\Models\Fee::create([
            'user_id'         => $user->id,
            'course_id'       => $activeCourseId,
            'batch_id'        => $activeBatchId,
            'original_amount' => $price,
            'total_amount'    => $price,
            'paid_amount'     => ($price > 0) ? 0 : $price,
            'status'          => ($price > 0) ? 'pending' : 'paid',
            'due_date'        => now()->addDays(7),
        ]);

        if ($price > 0) {
            return redirect()->route('admissions.checkout', $admission->id)->with('success', 'Express enrollment successful!');
        }

        return redirect()->route('admissions.index')->with('success', 'You have been enrolled successfully!');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name'          => 'required|string|max:255',
            'email'              => 'required|email|max:255',
            'whatsapp_number'    => 'required|string|max:20',
            'course_id'         => 'nullable|exists:courses,id',
            'batch_id'          => 'nullable|exists:live_class_branches,id',
            'address'           => 'nullable|string',
            'previous_education' => 'nullable|string',
        ]);

        if (empty($data['course_id']) && empty($data['batch_id'])) {
            return redirect()->back()->withErrors(['error' => 'Please select either a course or a live batch.']);
        }

        $price = 0;
        if (!empty($data['batch_id'])) {
            $batch = \App\Models\LiveClassBranch::findOrFail($data['batch_id']);
            $price = $batch->is_standalone ? $batch->price : ($batch->course->price ?? 0);
            $data['course_id'] = $data['course_id'] ?? $batch->course_id;
        } elseif (!empty($data['course_id'])) {
            $course = Course::findOrFail($data['course_id']);
            $price = $course->price;
        }
        
        $admission = Admission::create([
            'user_id'   => auth()->id(),
            'course_id' => $data['course_id'] ?? null,
            'batch_id'  => $data['batch_id'] ?? null,
            'status'    => ($price > 0) ? 'pending' : 'approved',
            'details'   => json_encode([
                'full_name'          => $data['full_name'],
                'whatsapp_number'    => $data['whatsapp_number'],
                'address'            => $data['address'] ?? '',
                'previous_education' => $data['previous_education'] ?? '',
            ]),
        ]);

        // Synchronize Financial Ledger (Create Pending Fee)
        \App\Models\Fee::create([
            'user_id'         => auth()->id(),
            'course_id'       => $data['course_id'] ?? null,
            'batch_id'        => $data['batch_id'] ?? null,
            'original_amount' => $price,
            'total_amount'    => $price,
            'paid_amount'     => ($price > 0) ? 0 : $price,
            'status'       => ($price > 0) ? 'pending' : 'paid',
            'due_date'     => now()->addDays(7),
        ]);

        if ($price > 0) {
            return redirect()->route('admissions.checkout', $admission->id)->with('info', 'Please complete the payment to start learning.');
        }

        return redirect()->route('admissions.index')->with('success', 'You have been enrolled successfully!');
    }

    public function checkout(Admission $admission)
    {
        // Ensure student owns this admission
        if ($admission->user_id !== auth()->id()) {
            abort(403);
        }

        $admission->load('course');

        // Check for direct-to-student discounts (Direct Coupons)
        $directCoupon = \App\Models\Coupon::where('student_email', auth()->user()->email)
            ->where('is_used', false)
            ->where(function($q) use ($admission) {
                $q->where('batch_id', $admission->batch_id)
                  ->orWhere('course_id', $admission->course_id);
            })
            ->first();

        return view('admissions.checkout', compact('admission', 'directCoupon'));
    }

    public function pay(Admission $admission, Request $request)
    {
        // Ensure student owns this admission
        if ($admission->user_id !== auth()->id()) {
            abort(403);
        }

        // Guard: Prevent double-payment for already approved sessions
        if ($admission->status === 'approved') {
            return redirect()->route('admissions.index')->with('info', 'This cohort is already active and settled.');
        }

        $price = 0;
        if ($admission->batch_id) {
            $batch = $admission->batch;
            $price = $batch->is_standalone ? $batch->price : ($batch->course->price ?? 0);
        } else {
            $price = $admission->course->price ?? 0;
        }

        $discount = 0;
        $appliedCoupon = null;

        // 1. Check for manual coupon code
        if ($request->filled('coupon_code')) {
            $appliedCoupon = \App\Models\Coupon::whereRaw('UPPER(code) = ?', [strtoupper($request->coupon_code)])
                ->where('is_used', false)
                ->where(function($q) use ($admission) {
                    $q->where('batch_id', $admission->batch_id)
                      ->orWhere('course_id', $admission->course_id);
                })
                ->first();
        } 
        
        // 2. Else: Check for direct-to-student discount if no manual code or manual code was invalid
        if (!$appliedCoupon) {
            $appliedCoupon = \App\Models\Coupon::where('student_email', auth()->user()->email)
                ->where('is_used', false)
                ->where(function($q) use ($admission) {
                    $q->where('batch_id', $admission->batch_id)
                      ->orWhere('course_id', $admission->course_id);
                })
                ->first();
        }

        if ($appliedCoupon) {
            $discount = $appliedCoupon->discount_amount;
            $appliedCoupon->update(['is_used' => true]);
        }

        $finalPrice = max(0, $price - $discount);

        // Create a simulated payment record
        \App\Models\Payment::create([
            'user_id'    => auth()->id(),
            'amount'     => $finalPrice,
            'payment_id' => 'DUMMY_' . strtoupper(uniqid()),
            'status'     => 'success',
            'type'       => 'course_enrollment',
        ]);

        // Sync Financial Ledger (Update Fee Status)
        $fee = \App\Models\Fee::where('user_id', auth()->id())
            ->where(function($q) use ($admission) {
                if ($admission->batch_id) $q->where('batch_id', $admission->batch_id);
                else $q->where('course_id', $admission->course_id);
            })
            ->where('status', 'pending')
            ->first();
            
        if ($fee) {
            $fee->update([
                'original_amount' => $fee->original_amount ?? $price,
                'total_amount'    => $finalPrice,
                'paid_amount'     => $finalPrice,
                'status'          => 'paid',
            ]);
        }

        // Automatically Approve
        $admission->update(['status' => 'approved']);

        return redirect()->route('admissions.index')->with('success', 'Payment successful! Welcome to the course.');
    }

    public function validateCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'admission_id' => 'required|exists:admissions,id',
        ]);

        $admission = Admission::findOrFail($request->admission_id);

        // Authorization: Ensure student owns this admission
        if ($admission->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized access.'], 403);
        }

        $coupon = \App\Models\Coupon::whereRaw('UPPER(code) = ?', [strtoupper($request->code)])
            ->where('is_used', false)
            ->where(function($q) use ($admission) {
                $q->where('batch_id', $admission->batch_id)
                  ->orWhere('course_id', $admission->course_id);
            })
            ->first();

        if (!$coupon) {
            $exists = \App\Models\Coupon::whereRaw('UPPER(code) = ?', [strtoupper($request->code)])->first();
            if (!$exists) {
                return response()->json(['success' => false, 'message' => 'Coupon code does not exist.'], 422);
            }
            if ($exists->is_used) {
                return response()->json(['success' => false, 'message' => 'This coupon has already been used.'], 422);
            }
            return response()->json(['success' => false, 'message' => 'This coupon is not valid for this batch or course.'], 422);
        }

        return response()->json([
            'success' => true,
            'discount' => (float)$coupon->discount_amount,
            'code' => $coupon->code
        ]);
    }
}
