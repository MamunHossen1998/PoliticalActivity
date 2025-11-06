<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\LeaveReason;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LeaveReasonController extends Controller
{
    public function index(Request $request, string $segment)
    {
        return view('backend.leave-reason.index', compact('segment'));
    }

    public function data(Request $request, string $segment)
    {
        $query = LeaveReason::query();
        $recordsTotal = (clone $query)->count();
        $recordsFiltered = (clone $query)->count();
        $leave_reasons = $query->get(['id', 'name', 'is_active']);

        $data = $leave_reasons->map(function ($b) use ($segment) {
            return [
                'id' => $b->id,
                'name' => e($b->name),
                'status' => $b->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>',
                'actions' => view('backend.leave-reason._actions', [
                    'segment' => $segment,
                    'leave_reason' => $b,
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
        $leave_reason = new LeaveReason();
        $action = route('leave-reason.store', ['segment' => $segment]);
        $method = 'POST';
        return view('backend.leave-reason._form', compact('leave_reason', 'action', 'method'));
    }

    public function store(Request $request, string $segment)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:leave_reasons,name'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = array_key_exists('is_active', $validated) ? (int) $validated['is_active'] : 1;
        LeaveReason::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Leave reason created successfully.',
        ]);
    }

    public function edit(Request $request, string $segment, LeaveReason $leave_reason)
    {
        $action = route('leave-reason.update', ['segment' => $segment, 'leave_reason' => $leave_reason->id]);
        $method = 'PUT';
        return view('backend.leave-reason._form', compact('leave_reason', 'action', 'method'));
    }

    public function update(Request $request, string $segment, LeaveReason $leave_reason)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('leave_reasons', 'name')->ignore($leave_reason->id)],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if (!array_key_exists('is_active', $validated)) {
            // If unchecked or not present, default to 0 when explicitly toggling
            $validated['is_active'] = $request->has('is_active') ? 0 : $leave_reason->is_active;
        }

        $leave_reason->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Leave reason updated successfully.',
        ]);
    }

    public function destroy(Request $request, string $segment, LeaveReason $leave_reason)
    {
        $leave_reason->delete();

        return response()->json([
            'success' => true,
            'message' => 'Leave reason deleted successfully.',
        ]);
    }
}

