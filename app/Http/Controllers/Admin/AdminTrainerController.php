<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class AdminTrainerController extends Controller
{
    /**
     * Display a listing of the trainers.
     */
    public function index()
    {
        $trainers = User::where('is_trainer', true)
            ->latest()
            ->paginate(20);

        return view('admin.trainers.index', compact('trainers'));
    }

    /**
     * Show the form for creating a new trainer.
     */
    public function create()
    {
        return view('admin.trainers.create');
    }

    /**
     * Store a newly created trainer in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false,
            'is_trainer' => true,
        ]);

        return redirect()->route('admin.trainers.index')->with('success', 'Trainer created successfully.');
    }
}
