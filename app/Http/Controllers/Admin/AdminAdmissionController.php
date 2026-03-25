<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminAdmissionController extends Controller
{
    public function index()
    {
        $admissions = Admission::with(['user', 'course', 'batch'])
            ->latest()
            ->paginate(20);

        return view('admin.admissions.index', compact('admissions'));
    }

    public function approve(Admission $admission)
    {
        $admission->update(['status' => 'approved']);
        return back()->with('success', 'Admission approved.');
    }

    public function reject(Admission $admission)
    {
        $admission->update(['status' => 'rejected']);
        return back()->with('success', 'Admission rejected.');
    }
}
