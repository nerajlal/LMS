<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Admission;
use App\Models\Payment;
use App\Models\Fee;
use App\Models\LiveClass;
use App\Models\StudyMaterial;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_students'   => User::where('is_admin', false)->count(),
            'total_courses'    => Course::count(),
            'total_admissions' => Admission::count(),
            'total_revenue'    => Payment::where('status', 'success')->sum('amount'),
            'total_fees_due'   => Fee::where('status', 'pending')->sum('total_amount'),
            'live_classes_count' => LiveClass::count(),
            'study_materials_count' => StudyMaterial::count(),
        ];

        $recentAdmissions = Admission::with(['user', 'course'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentAdmissions'));
    }
}
