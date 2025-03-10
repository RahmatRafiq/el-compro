<?php
namespace App\Http\Controllers;

use App\Helpers\MediaLibrary;
use App\Models\Course;
use App\Models\Lecturers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LecturersController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'active');
        $query  = Lecturers::with('courses');

        if ($filter == 'trashed') {
            $query->onlyTrashed();
        } elseif ($filter == 'all') {
            $query->withTrashed();
        }

        $lecturers = $query->get();

        return view('menu.lecturers.index', compact('lecturers', 'filter'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'lecturer-image.*' => 'required|file|max:2048|mimes:jpeg,jpg,png',
            'id'               => 'required|integer',
        ]);

        $lecturer = Lecturers::find($request->id);

        return response()->json(['message' => 'Profile picture uploaded'], 200);
    }

    public function create()
    {
        $courses = Course::all();
        $lecturer = new Lecturers();
        $lecturerImage = $lecturer->getMedia('lecturer-image')->first();
        return view('menu.lecturers.create', compact('courses', 'lecturerImage'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|max:255',
            'courses'        => 'array',
            'about'          => 'nullable|string',
            'lecturer-image' => 'array|max:3',
        ]);

        $lecturer = Lecturers::create([
            'name'  => $request->name,
            'about' => $request->about,
        ]);

        if ($request->has('courses')) {
            $lecturer->courses()->sync($request->courses);
        }

        if ($request->has('lecturer-image')) {
            MediaLibrary::put(
                $lecturer,
                'lecturer-image',
                $request,
                'lecturer-image'
            );
        }

        return redirect()->route('lecturers.index')->with('success', 'Lecturer added successfully.');
    }

    public function edit(Lecturers $lecturer)
    {       
         $lecturerImage = $lecturer->getMedia('lecturer-image')->first();

        $courses = Course::all();
        return view('menu.lecturers.edit', compact('lecturer', 'courses', 'lecturerImage'));
    }

    public function update(Request $request, Lecturers $lecturer)
    {
        $request->validate([
            'name'    => 'required|max:255',
            'courses' => 'array',
            'about'   => 'nullable|string',
            'lecturer-image' => 'array|max:3',
        ]);

        if ($request->has('lecturer-image')) {
            MediaLibrary::put(
                $lecturer,
                'lecturer-image',
                $request,
                'lecturer-image'
            );
        }

        $lecturer->update([
            'name'  => $request->name,
            'about' => $request->about,
        ]);
        
        if ($request->has('courses')) {
            $lecturer->courses()->sync($request->courses);
        }

        return redirect()->route('lecturers.index')->with('success', 'Lecturer updated successfully.');
    }

    public function deleteFile(Request $request)
    {
        $lecturer = Lecturers::find($request->id);
        $lecturer->clearMediaCollection('lecturer-image');
        return response()->json(['message' => 'File deleted'], 200);
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
