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

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name'          => 'required|string|max:255',
            'email'              => 'required|email|max:255',
            'whatsapp_number'    => 'required|string|max:20',
            'course_id'         => 'required|exists:courses,id',
            'batch_id'          => 'nullable|exists:live_class_branches,id',
            'address'           => 'nullable|string',
            'previous_education' => 'nullable|string',
        ]);

        $course = Course::findOrFail($data['course_id']);
        
        $admission = Admission::create([
            'user_id'   => auth()->id(),
            'course_id' => $data['course_id'],
            'batch_id'  => $data['batch_id'] ?? null,
            'status'    => ($course->price > 0) ? 'pending' : 'approved',
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
            'course_id'       => $data['course_id'],
            'original_amount' => $course->price,
            'total_amount'    => $course->price,
            'paid_amount'     => ($course->price > 0) ? 0 : $course->price,
            'status'       => ($course->price > 0) ? 'pending' : 'paid',
            'due_date'     => now()->addDays(7),
        ]);

        if ($course->price > 0) {
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

        $course = $admission->course;

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

        $finalPrice = max(0, $course->price - $discount);

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
            ->where('course_id', $admission->course_id)
            ->where('status', 'pending')
            ->first();
            
        if ($fee) {
            $fee->update([
                'original_amount' => $fee->original_amount ?? $course->price,
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
