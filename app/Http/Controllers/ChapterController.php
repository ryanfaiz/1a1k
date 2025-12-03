<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chapter;
use App\Models\Course;
use App\Models\Material;

class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only admins can create chapters');
        }
        return view('chapters.create', compact('course'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Course $course)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only admins can create chapters');
        }

        $request->validate([
            'title' => 'required',
        ]);

        Chapter::create([
            'course_id' => $course->id,
            'title' => $request->title,
        ]);

        return redirect()->route('courses.show', $course->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Chapter $chapter)
    {
        return view('chapters.show', compact('chapter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chapter $chapter)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only admins can edit chapters');
        }
        return view('chapters.edit', compact('chapter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chapter $chapter)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only admins can update chapters');
        }

        $request->validate([
            'title' => 'required',
        ]);

        $chapter->update([
            'title' => $request->title,
        ]);

        return redirect()->route('chapters.show', $chapter->id)->with('success', 'Chapter updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chapter $chapter)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only admins can delete chapters');
        }

        $course_id = $chapter->course_id;
        $chapter->delete();

        return redirect()->route('courses.show', $course_id)->with('success', 'Chapter deleted successfully');
    }
}
