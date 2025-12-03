<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Chapter;
use Illuminate\Support\Facades\Storage;
use PDF;

class MaterialController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Chapter $chapter)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only admins can create materials');
        }
        return view('materials.create', compact('chapter'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Chapter $chapter)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only admins can create materials');
        }

        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $path = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('materials', 'public');
        }

        Material::create([
            'chapter_id' => $chapter->id,
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $path,
        ]);

        return redirect()->route('chapters.show', $chapter->id)->with('success', 'Material created successfully');
    }

    /**
     * Preview material file.
     */
    public function preview(Material $material)
    {
        if (!$material->file_path) {
            return back()->with('error', 'File not found');
        }
        return view('materials.preview', compact('material'));
    }

    /**
     * Download material file.
     */
    public function download(Material $material)
    {
        if (!$material->file_path) {
            return back()->with('error', 'File not found');
        }
        return response()->download(storage_path('app/public/'.$material->file_path));
    }

    /**
     * Show edit form.
     */
    public function edit(Material $material)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only admins can edit materials');
        }
        return view('materials.edit', compact('material'));
    }

    /**
     * Update material.
     */
    public function update(Request $request, Material $material)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only admins can update materials');
        }

        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
        ];

        if ($request->hasFile('file')) {
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }
            $data['file_path'] = $request->file('file')->store('materials', 'public');
        }

        $material->update($data);

        return redirect()->route('chapters.show', $material->chapter_id)->with('success', 'Material updated successfully');
    }

    /**
     * Delete material.
     */
    public function destroy(Material $material)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only admins can delete materials');
        }

        $chapter_id = $material->chapter_id;
        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }
        $material->delete();

        return redirect()->route('chapters.show', $chapter_id)->with('success', 'Material deleted successfully');
    }

    /**
     * PDF export.
     */
    public function exportPdf(Chapter $chapter)
    {
        $materials = $chapter->materials;
        $pdf = PDF::loadView('materials.pdf', compact('chapter', 'materials'));
        return $pdf->stream('materi-'.$chapter->id.'.pdf');
    }

}
