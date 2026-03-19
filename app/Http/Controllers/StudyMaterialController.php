<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\StudyMaterial;

class StudyMaterialController extends Controller
{
    public function index()
    {
        $materials = StudyMaterial::with('course')->latest()->get();
        return Inertia::render('Materials/Index', [
            'materials' => $materials
        ]);
    }
}
