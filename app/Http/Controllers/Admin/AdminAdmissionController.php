<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use Illuminate\Http\Request;

class AdminAdmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Admission::with(['user', 'course', 'batch'])->latest();

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $admissions = $query->paginate(20);

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
