<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TrainerController extends Controller
{
    public function index()
    {
        return Inertia::render('Trainer/Dashboard');
    }
}
