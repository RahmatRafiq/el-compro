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
        $query = Lecturers::with('courses');

        if ($filter == 'trashed') {
            $query->onlyTrashed();
        } elseif ($filter == 'all') {
            $query->withTrashed();
        }

        $lecturers = $query->get();

        return view('menu.lecturers.index', compact('lecturers', 'filter'));
    }

    // public function json(Request $request)
    // {
    //     $search = $request->search['value'];
    //     $status = $request->status;  // Get the selected status filter
    //     $query = Lecturers::with('courses');
    
    //     // Filter based on status
    //     if ($status === 'active') {
    //         $query->whereNull('deleted_at');  // Show only active lecturers
    //     } elseif ($status === 'deleted') {
    //         $query->onlyTrashed();  // Show only deleted lecturers
    //     }
    
    //     $columns = [
    //         'id',
    //         'name',
    //         'status',
    //         'created_at',
    //         'updated_at',
    //     ];
    
    //     if ($request->filled('search')) {
    //         $query->where('name', 'like', "%{$search}%")
    //               ->orWhere('created_at', 'like', "%{$search}%")
    //               ->orWhere('updated_at', 'like', "%{$search}%");
    //     }
    
    //     if ($request->filled('order')) {
    //         $query->orderBy($columns[$request->order[0]['column']], $request->order[0]['dir']);
    //     }
    
    //     $data = DataTable::paginate($query, $request);
    
    //     $data['data'] = $data['data']->map(function ($lecturer) {
    //         $lecturer->status = $lecturer->trashed() ? 'Deleted' : 'Active';
    //         return $lecturer;
    //     });
    
    //     return response()->json($data);
    // }

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
