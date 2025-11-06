<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Specialization;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportAppointmentController extends Controller
{
    public function index(Request $request, string $segment)
    {
        // Get doctors sorted by name ASC
        $doctors = Doctor::with('specialization')
            ->orderBy('name', 'asc')
            ->get(['id', 'name', 'specialization_id']);

        return view('backend.export-appointment.index', compact('segment', 'doctors'));
    }

    public function data(Request $request, string $segment)
    {
        $doctorId = $request->input('doctor_id');
        $date = $request->input('date');

        $query = Appointment::with('doctor');

        if ($doctorId) {
            $query->where('doctor_id', $doctorId);
        }

        if ($date) {
            $query->whereDate('created_at', $date);
        }

        $appointments = $query->get(['id', 'doctor_id', 'name', 'phone', 'gender', 'age', 'type']);

        $data = $appointments->map(function ($a) {
            return [
                'id' => $a->id,
                'doctor_name' => $a->doctor?->name,
                'name' => e($a->name),
                'phone' => e($a->phone),
                'gender' => e($a->gender),
                'age' => e($a->age),
                'type' => e($a->type),
            ];
        });

        return response()->json(['data' => $data]);
    }

    public function exportPdf(Request $request, string $segment)
    {
        $doctorId = $request->input('doctor_id');
        $date = $request->input('date');

        $query = Appointment::with('doctor');

        if ($doctorId) {
            $query->where('doctor_id', $doctorId);
        }

        if ($date) {
            $query->whereDate('created_at', $date);
        }

        $doctor = null;
        if ($doctorId) {
            $doctor = \App\Models\Doctor::find($doctorId);
        }

        $appointments = $query->get();

        $pdf = Pdf::loadView('backend.export-appointment.pdf', [
            'appointments' => $appointments,
            'doctor' => $doctor,
            'date' => $date
        ]);

        return $pdf->download('appointments_' . now()->format('Ymd_His') . '.pdf');
    }
}
