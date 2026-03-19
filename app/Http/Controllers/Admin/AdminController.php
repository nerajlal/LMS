<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Admission;
use App\Models\Payment;
use App\Models\Fee;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_students'   => User::where('is_admin', false)->count(),
            'total_courses'    => Course::count(),
            'total_admissions' => Admission::count(),
            'pending_admissions' => Admission::where('status', 'pending')->count(),
            'total_revenue'    => Payment::where('status', 'success')->sum('amount'),
            'total_fees_due'   => Fee::where('status', 'pending')->sum('total_amount'),
        ];

        $recentAdmissions = Admission::with(['user', 'course'])
            ->latest()
            ->take(5)
            ->get();

        return Inertia::render('Admin/Dashboard', compact('stats', 'recentAdmissions'));
    }
}
