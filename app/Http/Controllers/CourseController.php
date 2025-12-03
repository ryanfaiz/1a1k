<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::all();
        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only admins can create courses');
        }
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only admins can create courses');
        }

        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        Course::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('courses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = Course::findOrFail($id);
        return view('courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only admins can edit courses');
        }
        $course = Course::findOrFail($id);
        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only admins can update courses');
        }

        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $course = Course::findOrFail($id);
        $course->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('courses.show', $course->id)->with('success', 'Course updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Only admins can delete courses');
        }
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully');
    }
}
