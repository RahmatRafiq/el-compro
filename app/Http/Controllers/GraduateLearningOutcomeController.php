<?php
namespace App\Http\Controllers;

use App\Models\GraduateLearningOutcome;
use Illuminate\Support\Str;
use App\Helpers\DataTable;
use Illuminate\Http\Request;

class GraduateLearningOutcomeController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'active');
        $query = GraduateLearningOutcome::query();
        if ($filter == 'trashed') {
            $query->onlyTrashed();
        } elseif ($filter == 'all') {
            $query->withTrashed();
        }
        $outcomes = $query->get();
        return view('menu.graduate_learning_outcomes.index', compact('outcomes', 'filter'));
    }

    public function json(Request $request)
    {
        $filter = $request->query('filter', 'active');
        $search = $request->search['value'] ?? null;
        $query = GraduateLearningOutcome::query();

        if ($filter == 'trashed') {
            $query->onlyTrashed();
        } elseif ($filter == 'all') {
            $query->withTrashed();
        }

        $columns = [
            'id',
            'concentration',
            'category',
            'item',
            'description',
            'created_at',
            'updated_at',
        ];

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('concentration', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('item', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('order')) {
            $orderColIdx = $request->order[0]['column'];
            $orderDir = $request->order[0]['dir'];
            $query->orderBy($columns[$orderColIdx], $orderDir);
        }

        $data = DataTable::paginate($query, $request);

        // Optionally format description for preview
        foreach ($data['data'] as &$row) {
            $row['description'] = Str::limit(strip_tags($row['description']), 300);
        }

        return response()->json($data);
    }

    public function create()
    {
        return view('menu.graduate_learning_outcomes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'concentration' => 'required|string',
            'name' => 'required|string',
            'description' => 'required|string',
        ]);
        GraduateLearningOutcome::create($request->only(['concentration', 'name', 'description']));
        return redirect()->route('graduate_learning_outcomes.index')->with('success', 'Outcome created successfully.');
    }

    public function edit(GraduateLearningOutcome $graduateLearningOutcome)
    {
        return view('menu.graduate_learning_outcomes.edit', compact('graduateLearningOutcome'));
    }

    public function update(Request $request, GraduateLearningOutcome $graduateLearningOutcome)
    {
        $request->validate([
            'concentration' => 'required|string',
            'name' => 'required|string',
            'description' => 'required|string',
        ]);
        $graduateLearningOutcome->update($request->only(['concentration', 'name', 'description']));
        return redirect()->route('graduate_learning_outcomes.index')->with('success', 'Outcome updated successfully.');
    }

    public function destroy(GraduateLearningOutcome $graduateLearningOutcome)
    {
        $graduateLearningOutcome->delete();
        return redirect()->route('graduate_learning_outcomes.index')->with('success', 'Outcome deleted successfully.');
    }

    public function restore($id)
    {
        GraduateLearningOutcome::onlyTrashed()->where('id', $id)->restore();
        return redirect()->route('graduate_learning_outcomes.index')->with('success', 'Outcome restored successfully.');
    }

    public function forceDelete($id)
    {
        GraduateLearningOutcome::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect()->route('graduate_learning_outcomes.index')->with('success', 'Outcome permanently deleted.');
    }
}
