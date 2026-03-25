<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\StudyMaterial;

class StudyMaterialController extends Controller
{
    public function index()
    {
        $materials = StudyMaterial::with('course')->latest()->get();
        return view('materials.index', compact('materials'));
    }
}
