<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\Course;
use App\Models\Lecturers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LecturersController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'active');

        if ($filter == 'trashed') {
            $lecturers = Lecturers::onlyTrashed()->with('courses')->get();
        } elseif ($filter == 'all') {
            $lecturers = Lecturers::withTrashed()->with('courses')->get();
        } else {
            $lecturers = Lecturers::with('courses')->get();
        }

        return view('menu.lecturers.index', compact('lecturers', 'filter'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('menu.lecturers.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'courses' => 'array'
        ]);

        $imagePath = $request->hasFile('image') ? $request->file('image')->store('lecturers', 'public') : null;

        $lecturer = Lecturers::create([
            'name' => $request->name,
            'image' => $imagePath
        ]);

        if ($request->has('courses')) {
            $lecturer->courses()->sync($request->courses);
        }

        return redirect()->route('lecturers.index')->with('success', 'Lecturer added successfully.');
    }

    public function edit(Lecturers $lecturer)
    {
        $courses = Course::all();
        return view('menu.lecturers.edit', compact('lecturer', 'courses'));
    }

    public function update(Request $request, Lecturers $lecturer)
    {
        $request->validate([
            'name' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'courses' => 'array'
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($lecturer->image);
            $imagePath = $request->file('image')->store('lecturers', 'public');
            $lecturer->update(['image' => $imagePath]);
        }

        $lecturer->update(['name' => $request->name]);

        if ($request->has('courses')) {
            $lecturer->courses()->sync($request->courses);
        }

        return redirect()->route('lecturers.index')->with('success', 'Lecturer updated successfully.');
    }

    public function destroy(Lecturers $lecturer)
    {
        $lecturer->delete();
        return redirect()->route('lecturers.index')->with('success', 'Lecturer deleted successfully.');
    }

    public function trashed()
    {
        $lecturers = Lecturers::onlyTrashed()->with('courses')->get();
        return view('menu.lecturers.trashed', compact('lecturers'));
    }

    public function restore($id)
    {
        Lecturers::onlyTrashed()->where('id', $id)->restore();
        return redirect()->route('lecturers.index')->with('success', 'Lecturer restored successfully.');
    }

    public function forceDelete($id)
    {
        Lecturers::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect()->route('lecturers.index')->with('success', 'Lecturer permanently deleted.');
    }
}
