<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_code' => 'required|unique:courses,course_code|max:10',
            'name' => 'required|max:255',
            'credits' => 'required|integer',
        ]);

        Course::create($request->all());

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'course_code' => 'required|max:10|unique:courses,course_code,' . $course->id,
            'name' => 'required|max:255',
            'credits' => 'required|integer',
        ]);

        $course->update($request->all());

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }

    public function trashed()
    {
        $courses = Course::onlyTrashed()->get();
        return view('courses.trashed', compact('courses'));
    }

    public function restore($id)
    {
        Course::onlyTrashed()->where('id', $id)->restore();
        return redirect()->route('courses.trashed')->with('success', 'Course restored successfully.');
    }

    public function forceDelete($id)
    {
        Course::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect()->route('courses.trashed')->with('success', 'Course permanently deleted.');
    }
}
