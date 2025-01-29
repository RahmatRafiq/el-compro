<?php
namespace App\Http\Controllers;

use App\Models\GeneralInformation;
use Illuminate\Http\Request;

class GeneralInformationController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'active');
        $query  = GeneralInformation::query();

        if ($filter == 'trashed') {
            $query->onlyTrashed();
        } elseif ($filter == 'all') {
            $query->withTrashed();
        }

        $generalInformations = $query->get();

        return view('menu.general_information.index', compact('generalInformations', 'filter'));
    }

    public function create()
    {
        return view('menu.general_information.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'name' => 'nullable|string|max:255',
            'description' => 'required|string',
        ]);
    
        GeneralInformation::create([
            'type' => $request->type,
            'name' => $request->name,
            'description' => $request->description,
        ]);
    
        return redirect()->route('general_information.index')->with('success', 'General Information created successfully!');
    }

    public function edit(GeneralInformation $generalInformation)
    {
        return view('menu.general_information.edit', compact('generalInformation'));
    }

    public function update(Request $request, GeneralInformation $generalInformation)
{
    $request->validate([
        'type' => 'required|string',
        'name' => 'nullable|string|max:255',
        'description' => 'required|string',
    ]);

    $generalInformation->update([
        'type' => $request->type,
        'name' => $request->name,
        'description' => $request->description,
    ]);

    return redirect()->route('general_information.index')->with('success', 'General Information updated successfully!');
}

    public function destroy(GeneralInformation $generalInformation)
    {
        $generalInformation->delete();
        return redirect()->route('general_information.index')->with('success', 'Data deleted successfully.');
    }

    public function restore($id)
    {
        GeneralInformation::onlyTrashed()->where('id', $id)->restore();
        return redirect()->route('general_information.index')->with('success', 'Data restored successfully.');
    }

    public function forceDelete($id)
    {
        GeneralInformation::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect()->route('general_information.index')->with('success', 'Data permanently deleted.');
    }
}
