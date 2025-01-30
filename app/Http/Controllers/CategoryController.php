<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'active');

        $categories = match ($filter) {
            'trashed' => Category::onlyTrashed()->get(),
            'all' => Category::withTrashed()->get(),
            default => Category::all(),
        };

        return view('menu.categories.index', compact('categories', 'filter'));
    }

    public function create()
    {
        return view('menu.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'nullable|string',
            'name' => 'required|string|max:255',
        ]);

        Category::create([
            'type' => $request->type,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('categories.index')->with('success', 'Category added successfully.');
    }

    public function edit(Category $category)
    {
        return view('menu.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'type' => 'nullable|string',
            'name' => 'required|string|max:255',
        ]);

        $category->update([
            'type' => $request->type,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category moved to trash.');
    }

    public function trashed()
    {
        $categories = Category::onlyTrashed()->get();
        return view('menu.categories.trashed', compact('categories'));
    }

    public function restore($id)
    {
        Category::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('categories.index')->with('success', 'Category restored successfully.');
    }

    public function forceDelete($id)
    {
        Category::withTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('categories.index')->with('success', 'Category permanently deleted.');
    }
}
