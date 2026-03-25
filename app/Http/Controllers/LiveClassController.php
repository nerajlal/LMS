<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\LiveClass;

class LiveClassController extends Controller
{
    public function index()
    {
        $classes = LiveClass::with('course')->latest()->get();
        return view('live-classes.index', compact('classes'));
    }
}
