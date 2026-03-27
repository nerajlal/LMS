<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function uploadCertificate(Request $request, Admission $admission)
    {
        $request->validate([
            'certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB limit
        ]);

        if ($request->hasFile('certificate')) {
            // Cleanup old certificate if exists
            if ($admission->certificate_path && Storage::disk('public')->exists($admission->certificate_path)) {
                Storage::disk('public')->delete($admission->certificate_path);
            }

            $path = $request->file('certificate')->store('certificates', 'public');
            $admission->update(['certificate_path' => $path]);
        }

        return back()->with('success', 'Certificate uploaded and issued successfully.');
    }
}
