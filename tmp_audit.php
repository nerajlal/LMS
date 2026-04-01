<?php

use App\Models\User;
use App\Models\Course;
use App\Models\LiveClass;
use App\Models\LiveClassBranch;
use App\Models\Admission;
use App\Models\Fee;
use App\Models\Payment;
use App\Models\Coupon;

echo "--- [ LMS INTEGRITY AUDIT ] ---\n\n";

echo "1. USER REGISTRY\n";
User::all()->each(function($user) {
    $role = $user->is_admin ? 'Admin' : ($user->is_trainer ? 'Trainer' : 'Student');
    $status = $user->is_active ? 'ACTIVE' : 'FROZEN';
    echo "ID: {$user->id} | Name: {$user->name} | Role: {$role} | Status: {$status} | Email: {$user->email}\n";
});

echo "\n2. INSTRUCTIONAL REGISTRY (COURSES & BATCHES)\n";
Course::with('liveClasses')->get()->each(function($course) {
    echo "Course: {$course->title} (₹{$course->price})\n";
    $course->liveClasses->each(function($batch) {
        $branchName = $batch->branch ? $batch->branch->name : 'N/A';
        echo "  - Batch ID: {$batch->id} | Branch: {$branchName} | Status: {$batch->status}\n";
    });
});

echo "\n3. TRAINER ASSIGNMENTS (BRANCHES)\n";
LiveClassBranch::with('trainers')->get()->each(function($branch) {
    $trainers = $branch->trainers->pluck('name')->implode(', ') ?: 'UNASSIGNED';
    echo "Branch: {$branch->name} | Assigned Tutors: {$trainers}\n";
});

echo "\n4. ENROLLMENT & FINANCIAL GOVERNANCE\n";
Admission::with(['user', 'course'])->get()->each(function($adm) {
    $fee = Fee::where('user_id', $adm->user_id)->where('course_id', $adm->course_id)->first();
    $paid = $fee ? Payment::where('fee_id', $fee->id)->sum('amount') : 0;
    $total = $fee ? $fee->total_amount : 'N/A';
    $settled = ($fee && $paid >= $fee->total_amount) ? 'SETTLED' : 'PENDING';
    echo "Student: {$adm->user->name} | Course: {$adm->course->title} | Status: {$adm->status} | Financial: {$settled} (₹{$paid}/₹{$total})\n";
});

echo "\n5. COUPON REGISTRY\n";
Coupon::all()->each(function($cpn) {
    $status = $cpn->is_used ? 'USED' : 'AVAILABLE';
    echo "Code: {$cpn->code} | Discount: ₹{$cpn->discount_amount} | Batch ID: {$cpn->live_class_id} | Status: {$status}\n";
});

echo "\n--- [ AUDIT COMPLETE ] ---\n";
