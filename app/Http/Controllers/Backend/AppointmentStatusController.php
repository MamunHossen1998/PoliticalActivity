<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AppointmentStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AppointmentStatusController extends Controller
{
    public function index(Request $request, string $segment)
    {
        return view('backend.appointment-status.index', compact('segment'));
    }

    public function data(Request $request, string $segment)
    {
        $query = AppointmentStatus::query();
        $recordsTotal = (clone $query)->count();
        $recordsFiltered = (clone $query)->count();
        $appointment_statuses = $query->get(['id', 'name', 'is_active']);

        $data = $appointment_statuses->map(function ($b) use ($segment) {
            return [
                'id' => $b->id,
                'name' => e($b->name),
                'status' => $b->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>',
                'actions' => view('backend.appointment-status._actions', [
                    'segment' => $segment,
                    'appointment_status' => $b,
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
        $appointment_status = new AppointmentStatus();
        $action = route('appointment-status.store', ['segment' => $segment]);
        $method = 'POST';
        return view('backend.appointment-status._form', compact('appointment_status', 'action', 'method'));
    }

    public function store(Request $request, string $segment)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:appointment_statuses,name'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = array_key_exists('is_active', $validated) ? (int) $validated['is_active'] : 1;
        AppointmentStatus::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Appointment status created successfully.',
        ]);
    }

    public function edit(Request $request, string $segment, AppointmentStatus $appointment_status)
    {
        $action = route('appointment-status.update', ['segment' => $segment, 'appointment_status' => $appointment_status->id]);
        $method = 'PUT';
        return view('backend.appointment-status._form', compact('appointment_status', 'action', 'method'));
    }

    public function update(Request $request, string $segment, AppointmentStatus $appointment_status)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('appointment_statuses', 'name')->ignore($appointment_status->id)],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if (!array_key_exists('is_active', $validated)) {
            // If unchecked or not present, default to 0 when explicitly toggling
            $validated['is_active'] = $request->has('is_active') ? 0 : $appointment_status->is_active;
        }

        $appointment_status->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Appointment status updated successfully.',
        ]);
    }

    public function destroy(Request $request, string $segment, AppointmentStatus $appointment_status)
    {
        $appointment_status->delete();

        return response()->json([
            'success' => true,
            'message' => 'Appointment status deleted successfully.',
        ]);
    }
}

