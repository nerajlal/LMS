<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Inertia;

class AdminStudentController extends Controller
{
    public function index()
    {
        $students = User::where('is_admin', false)
            ->where('is_trainer', false)
            ->withCount(['admissions', 'enrollments'])
            ->latest()
            ->paginate(20);

        return Inertia::render('Admin/Students/Index', compact('students'));
    }
}
