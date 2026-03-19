<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\LiveClass;
use Inertia\Inertia;

class LiveClassController extends Controller
{
    public function index()
    {
        $classes = LiveClass::with('course')->latest()->get();
        return Inertia::render('LiveClasses/Index', [
            'classes' => $classes
        ]);
    }
}
