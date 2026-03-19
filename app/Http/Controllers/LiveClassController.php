<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LiveClassController extends Controller
{
    public function index()
    {
        return \Inertia\Inertia::render('LiveClasses/Index');
    }
}
