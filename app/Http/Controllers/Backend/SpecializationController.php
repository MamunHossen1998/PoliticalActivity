<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SpecializationController extends Controller
{
    public function index(Request $request, string $segment)
    {
        return view('backend.specializations.index', compact('segment'));
    }

    public function data(Request $request, string $segment)
    {
        $query = Specialization::query();
        $recordsTotal = (clone $query)->count();
        $recordsFiltered = (clone $query)->count();
        $items = $query->get(['id', 'name', 'is_active']);

        $data = $items->map(function ($s) use ($segment) {
            return [
                'id' => $s->id,
                'name' => e($s->name),
                'status' => $s->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>',
                'actions' => view('backend.specializations._actions', [
                    'segment' => $segment,
                    'specialization' => $s,
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
        $specialization = new Specialization();
        $action = route('specializations.store', ['segment' => $segment]);
        $method = 'POST';
        return view('backend.specializations._form', compact('specialization', 'action', 'method'));
    }

    public function store(Request $request, string $segment)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:specializations,name'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = array_key_exists('is_active', $validated) ? (int) $validated['is_active'] : 1;
        Specialization::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Specialization created successfully.',
        ]);
    }

    public function edit(Request $request, string $segment, Specialization $specialization)
    {
        $action = route('specializations.update', ['segment' => $segment, 'specialization' => $specialization->id]);
        $method = 'PUT';
        return view('backend.specializations._form', compact('specialization', 'action', 'method'));
    }

    public function update(Request $request, string $segment, Specialization $specialization)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('specializations', 'name')->ignore($specialization->id)],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if (!array_key_exists('is_active', $validated)) {
            $validated['is_active'] = $request->has('is_active') ? 0 : $specialization->is_active;
        }

        $specialization->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Specialization updated successfully.',
        ]);
    }

    public function destroy(Request $request, string $segment, Specialization $specialization)
    {
        $specialization->delete();

        return response()->json([
            'success' => true,
            'message' => 'Specialization deleted successfully.',
        ]);
    }
}

