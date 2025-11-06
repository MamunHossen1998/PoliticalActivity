<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Specialization;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AppoinmentController extends Controller
{
    public function index(Request $request, string $segment)
    {
        $specializations = Specialization::where('is_active', 1)->orderBy('name')->get(['id','name']);
        return view('backend.appoinment.index', compact('segment', 'specializations'));
    }

    public function doctorsData(Request $request, string $segment)
    {
        $query = Doctor::query()->with(['specialization:id,name']);

        $recordsTotal = (clone $query)->count();

        // Filters
        if ($name = $request->input('doctor_name')) {
            $query->where('name', 'like', "%{$name}%");
        }
        if ($spec = $request->input('specialization_id')) {
            $query->where('specialization_id', $spec);
        }
        if ($date = $request->input('date')) {
            try {
                $day = strtolower(Carbon::parse($date)->format('l'));
                // Only doctors who are open on the selected weekday (Spatie OpeningHours weekly keys)
                $query->whereRaw('COALESCE(JSON_LENGTH(JSON_EXTRACT(opening_hours, ?)), 0) > 0', ['$.'.$day]);
            } catch (\Throwable $e) {
                // ignore invalid date
            }
        }

        // Only active doctors
        $query->where('is_active', 1);

        $recordsFiltered = (clone $query)->count();

        // Sorting (default by name)
        $query->orderBy('name');

        $items = $query->get(['id','doctor_no','name','specialization_id']);

        $data = $items->map(function ($d) {
            return [
                'id' => $d->id,
                'doctor_no' => e($d->doctor_no ?? '-'),
                'name' => e($d->name),
                'specialization' => e(optional($d->specialization)->name ?? '-'),
            ];
        });

        return response()->json([
            'data' => $data,
        ]);
    }

    public function showDoctor(Request $request, string $segment, Doctor $doctor)
    {
        $openingRaw = $doctor->getRawOriginal('opening_hours');
        $openingArr = $openingRaw ? (json_decode($openingRaw, true) ?: []) : [];
        $today = strtolower(Carbon::now()->format('l'));
        $firstRange = $openingArr[$today][0] ?? null; // e.g. "09:00-17:00"
        $start = $end = null;
        if ($firstRange && strpos($firstRange, '-') !== false) {
            [$start, $end] = explode('-', $firstRange, 2);
        }

        $payload = [
            'id' => $doctor->id,
            'doctor_no' => $doctor->doctor_no,
            'name' => $doctor->name,
            'degree' => $doctor->degree,
            'designation' => $doctor->designation,
            'specialty' => $doctor->specialty ?: optional($doctor->specialization)->name,
            'location' => $doctor->location,
            'chamber_address' => $doctor->chamber_address,
            'phone' => $doctor->phone,
            'registration_no' => $doctor->registration_no,
            'experience_years' => $doctor->experience_years,
            'first_visit_fee' => $doctor->first_visit_fee,
            'follow_up_fee' => $doctor->follow_up_fee,
            'follow_up_validity_days' => $doctor->follow_up_validity_days,
            'reserved' => $doctor->reserved,
            'avg_duration' => $doctor->avg_duration,
            'avg_load' => $doctor->avg_load,
            'start_time' => $start,
            'end_time' => $end,
            // formatted for Asia/Dhaka with AM/PM
            'start_time_label' => $start ? Carbon::createFromFormat('H:i', $start, 'Asia/Dhaka')->format('h:i A') : null,
            'end_time_label'   => $end ? Carbon::createFromFormat('H:i', $end, 'Asia/Dhaka')->format('h:i A') : null,
            'remarks' => empty($openingArr[$today]) ? 'Closed Today' : null,
        ];

        return response()->json($payload);
    }

    public function appointmentsList(Request $request, string $segment)
    {
        $request->validate([
            'doctor_id' => ['required', 'exists:doctors,id'],
        ]);

        $items = Appointment::query()
            ->where('doctor_id', $request->integer('doctor_id'))
            ->latest('id')
            ->limit(100)
            ->get(['id','name','phone','gender','age','type','created_at']);

        return response()->json([
            'data' => $items,
        ]);
    }

    public function store(Request $request, string $segment)
    {
        $validated = $request->validate([
            'doctor_id' => ['required', 'exists:doctors,id'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'gender' => ['required', 'in:Male,Female,Other'],
            'age' => ['required', 'integer', 'min:0', 'max:150'],
            'type' => ['required', 'in:New,Follow-Up'],
        ]);

        $appointment = Appointment::create($validated);

        return response()->json([
            'message' => 'Appointment created successfully',
            'appointment' => $appointment,
        ]);
    }
}
