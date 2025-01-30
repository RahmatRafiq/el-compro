<?php
namespace App\Http\Controllers;

use App\Models\Category;
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
        $categories = Category::where('type', 'general_information')->get();
        return view('menu.general_information.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'nullable|string|max:255',
            'description' => 'required|string',
        ]);

        $category = Category::findOrFail($request->category_id);

        GeneralInformation::create([
            'type'        => $category->name,
            'name'        => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('general_information.index')->with('success', 'General Information created successfully!');
    }

    public function edit(GeneralInformation $generalInformation)
    {
        $categories = Category::where('type', 'general_information')->get();
        return view('menu.general_information.edit', compact('generalInformation', 'categories'));
    }

    public function update(Request $request, GeneralInformation $generalInformation)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'nullable|string|max:255',
            'description' => 'required|string',
        ]);

        $category = Category::findOrFail($request->category_id);

        $generalInformation->update([
            'type'        => $category->name,
            'name'        => $request->name,
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
