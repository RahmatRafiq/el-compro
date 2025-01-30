<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Virtual;
use Illuminate\Http\Request;

class VirtualController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'active');
        $query  = Virtual::with('category');

        if ($filter == 'trashed') {
            $query->onlyTrashed();
        } elseif ($filter == 'all') {
            $query->withTrashed();
        }

        $virtuals = $query->get();

        return view('menu.virtuals.index', compact('virtuals', 'filter'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('menu.virtuals.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|max:255',
            'url_embed'   => 'required|url',
            'description' => 'required',
        ]);

        Virtual::create($request->all());

        return redirect()->route('virtuals.index')->with('success', 'Virtual content added successfully.');
    }

    public function edit(Virtual $virtual)
    {
        $categories = Category::all();
        return view('menu.virtuals.edit', compact('virtual', 'categories'));
    }

    public function update(Request $request, Virtual $virtual)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|max:255',
            'url_embed'   => 'required|url',
            'description' => 'required',
        ]);

        $virtual->update($request->all());

        return redirect()->route('virtuals.index')->with('success', 'Virtual content updated successfully.');
    }

    public function destroy(Virtual $virtual)
    {
        $virtual->delete();
        return redirect()->route('virtuals.index')->with('success', 'Virtual content deleted successfully.');
    }

    public function trashed()
    {
        $virtuals = Virtual::onlyTrashed()->with('category')->get();
        return view('menu.virtuals.trashed', compact('virtuals'));
    }

    public function restore($id)
    {
        Virtual::onlyTrashed()->where('id', $id)->restore();
        return redirect()->route('virtuals.index')->with('success', 'Virtual content restored successfully.');
    }

    public function forceDelete($id)
    {
        Virtual::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect()->route('virtuals.index')->with('success', 'Virtual content permanently deleted.');
    }
}
