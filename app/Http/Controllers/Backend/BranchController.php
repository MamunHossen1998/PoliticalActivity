<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BranchController extends Controller
{
    public function index(Request $request, string $segment)
    {
        return view('backend.branches.index', compact('segment'));
    }

    public function data(Request $request, string $segment)
    {
        $query = Branch::query();
        $recordsTotal = (clone $query)->count();
        $recordsFiltered = (clone $query)->count();
        $branches = $query->get(['id', 'name', 'is_active']);

        $data = $branches->map(function ($b) use ($segment) {
            return [
                'id' => $b->id,
                'name' => e($b->name),
                'status' => $b->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>',
                'actions' => view('backend.branches._actions', [
                    'segment' => $segment,
                    'branch' => $b,
                ])->render(),
            ];
        });

        return response()->json([
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }

    public function create(Request $request, string $segment)
    {
        $branch = new Branch();
        $action = route('branches.store', ['segment' => $segment]);
        $method = 'POST';
        return view('backend.branches._form', compact('branch', 'action', 'method'));
    }

    public function store(Request $request, string $segment)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:branches,name'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = array_key_exists('is_active', $validated) ? (int) $validated['is_active'] : 1;
        Branch::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Branch created successfully.',
        ]);
    }

    public function edit(Request $request, string $segment, Branch $branch)
    {
        $action = route('branches.update', ['segment' => $segment, 'branch' => $branch->id]);
        $method = 'PUT';
        return view('backend.branches._form', compact('branch', 'action', 'method'));
    }

    public function update(Request $request, string $segment, Branch $branch)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('branches', 'name')->ignore($branch->id)],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if (!array_key_exists('is_active', $validated)) {
            // If unchecked or not present, default to 0 when explicitly toggling
            $validated['is_active'] = $request->has('is_active') ? 0 : $branch->is_active;
        }

        $branch->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Branch updated successfully.',
        ]);
    }

    public function destroy(Request $request, string $segment, Branch $branch)
    {
        $branch->delete();

        return response()->json([
            'success' => true,
            'message' => 'Branch deleted successfully.',
        ]);
    }
}

