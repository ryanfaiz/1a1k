<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;

class MateriController extends Controller
{
    public function index()
    {
        $materials = Material::with('chapter.course')->latest()->paginate(15);
        return view('materi.index', compact('materials'));
    }
}
