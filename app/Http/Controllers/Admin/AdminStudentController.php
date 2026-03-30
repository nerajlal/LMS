<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminStudentController extends Controller
{
    public function index()
    {
        $students = User::where('is_admin', false)
            ->where('is_trainer', false)
            ->withCount(['admissions', 'enrollments'])
            ->latest()
            ->paginate(20);

        return view('admin.students.index', compact('students'));
    }

    /**
     * Toggle the active status of a student.
     */
    public function toggleStatus(User $student)
    {
        if ($student->is_admin || $student->is_trainer) {
            abort(403, 'Unauthorized action.');
        }

        $student->update(['is_active' => !$student->is_active]);

        $status = $student->is_active ? 'activated' : 'frozen';
        return back()->with('success', "Student account has been {$status} successfully.");
    }
}
