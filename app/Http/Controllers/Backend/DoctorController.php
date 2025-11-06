<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Branch;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\OpeningHours\OpeningHours;

class DoctorController extends Controller
{
    public function index(Request $request, string $segment)
    {
        return view('backend.doctors.index', compact('segment'));
    }

    public function data(Request $request, string $segment)
    {
        $query = Doctor::query();

        $recordsTotal = (clone $query)->count();
        $recordsFiltered = (clone $query)->count();

        ## Global search
        $search = $request->input('search.value');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name','like',"%{$search}%")
                ->orWhere('email','like',"%{$search}%")
                ->orWhere('phone','like',"%{$search}%");
            });
        }

        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);
        if ($length !== -1) {
            $query->skip($start)->take($length);
        }

        $items = $query->get();

        $items = $query->with(['branch:id,name', 'specialization:id,name'])
            ->get(['id','name','degree','phone','branch_id','specialization_id','is_active','opening_hours']);

        $data = $items->map(function ($d) use ($segment) {
            $labels = ['sunday' => 'Sun','monday' => 'Mon','tuesday' => 'Tue','wednesday' => 'Wed','thursday' => 'Thu','friday' => 'Fri','saturday' => 'Sat'];
            $raw = $d->getRawOriginal('opening_hours');
            $oh = $raw ? (json_decode($raw, true) ?: []) : [];
            $parts = [];
            foreach (['sunday','monday','tuesday','wednesday','thursday','friday','saturday'] as $dayKey) {
                $ranges = $oh[$dayKey] ?? [];
                $dayLabel = $labels[$dayKey];
                if (empty($ranges)) {
                    $parts[] = $dayLabel . ': Closed';
                } else {
                    $parts[] = $dayLabel . ': ' . implode(',', array_map(function($r){ return substr($r,0,5) . '-' . substr($r,6,5); }, $ranges));
                }
            }

            return [
                'id' => $d->id,
                'name' => e($d->name),
                'degree' => e($d->degree ?? '-'),
                'phone' => e($d->phone ?? '-'),
                // 'branch' => e(optional($d->branch)->name ?? '-'),
                'specialization' => e(optional($d->specialization)->name ?? '-'),
                // 'hours' => '<div>'.e(implode(' | ', $parts)).'</div>',
                // 'hours' => '<div>' . nl2br(e(implode("\n", $parts))) . '</div>',
                'status' => $d->is_active ? '<span class=\"badge bg-success\">Active</span>' : '<span class=\"badge bg-secondary\">Inactive</span>',
                'actions' => view('backend.doctors._actions', [
                    'segment' => $segment,
                    'doctor' => $d,
                ])->render(),
            ];
        });

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }

    public function create(Request $request, string $segment)
    {
        $doctor = new Doctor();
        $action = route('doctors.store', ['segment' => $segment]);
        $method = 'POST';
        $branches = Branch::where('is_active', 1)->orderBy('name')->get(['id', 'name']);
        $specializations = Specialization::where('is_active', 1)->orderBy('name')->get(['id', 'name']);
        // Prefill weekly structure for the form
        $days = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
        $weekly = [];
        foreach ($days as $d) { $weekly[$d] = ['opens' => '', 'closes' => '']; }
        return view('backend.doctors.form', compact('doctor', 'action', 'method', 'branches', 'specializations', 'weekly'));
    }

    public function store(Request $request, string $segment)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'branch_id' => ['nullable', 'integer', Rule::exists('branches', 'id')],
            'specialization_id' => ['nullable', 'integer', Rule::exists('specializations', 'id')],
            'is_active' => ['nullable', 'boolean'],
            'degree' => ['nullable', 'string', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'string', 'max:10'],
            'date_of_birth' => ['nullable', 'date'],
            'address' => ['nullable', 'string'],
            'chamber_address' => ['nullable', 'string'],
            'consultation_fee' => ['nullable', 'numeric', 'min:0'],
            'experience_years' => ['nullable', 'integer', 'min:0'],
            'registration_no' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'photo_path' => ['nullable', 'string', 'max:255'],
            'opening_hours' => ['nullable', 'array'],
        ]);

        $validated['is_active'] = $validated['is_active'] ?? 1;

        // Build opening_hours array from weekly[day][opens|closes]
        $weekly = $request->input('weekly', []);
        $days = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
        $openingHours = [];
        foreach ($days as $dayKey) {
            $opens = $weekly[$dayKey]['opens'] ?? null;
            $closes = $weekly[$dayKey]['closes'] ?? null;
            if ($opens && $closes) {
                $openingHours[$dayKey] = [sprintf('%s-%s', $opens, $closes)];
            } else {
                $openingHours[$dayKey] = [];
            }
        }
        // Validate shape via Spatie; then save array (cast to JSON)
        try { OpeningHours::create($openingHours); } catch (\Throwable $e) {}
        $validated['opening_hours'] = $openingHours;

        Doctor::create($validated);

        return redirect()->route('doctors.index', ['segment' => $segment])
            ->with('success', 'Doctor created successfully.');
    }

    public function edit(Request $request, string $segment, Doctor $doctor)
    {
        $action = route('doctors.update', ['segment' => $segment, 'doctor' => $doctor->id]);
        $method = 'PUT';
        $branches = Branch::where('is_active', 1)->orderBy('name')->get(['id', 'name']);
        $specializations = Specialization::where('is_active', 1)->orderBy('name')->get(['id', 'name']);

        // Prepare weekly values for form from opening_hours
        $opening = is_string($doctor->getRawOriginal('opening_hours'))
            ? (json_decode($doctor->getRawOriginal('opening_hours'), true) ?: [])
            : ($doctor->opening_hours ?: []);
        $days = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
        $weekly = [];
        foreach ($days as $d) {
            $first = $opening[$d][0] ?? '';
            if ($first && strpos($first, '-') !== false) {
                [$op,$cl] = explode('-', $first, 2);
            } else { $op = $cl = ''; }
            $weekly[$d] = ['opens' => $op, 'closes' => $cl];
        }

        return view('backend.doctors.form', compact('doctor', 'action', 'method', 'branches', 'specializations', 'weekly'));
    }

    public function update(Request $request, string $segment, Doctor $doctor)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'branch_id' => ['nullable', 'integer', Rule::exists('branches', 'id')],
            'specialization_id' => ['nullable', 'integer', Rule::exists('specializations', 'id')],
            'is_active' => ['nullable', 'boolean'],
            'degree' => ['nullable', 'string', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'string', 'max:10'],
            'date_of_birth' => ['nullable', 'date'],
            'address' => ['nullable', 'string'],
            'chamber_address' => ['nullable', 'string'],
            'consultation_fee' => ['nullable', 'numeric', 'min:0'],
            'experience_years' => ['nullable', 'integer', 'min:0'],
            'registration_no' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'photo_path' => ['nullable', 'string', 'max:255'],
            'opening_hours' => ['nullable', 'array'],
        ]);

        // Build opening_hours from posted weekly
        $weekly = $request->input('weekly', []);
        $days = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
        $openingHours = [];
        foreach ($days as $dayKey) {
            $opens = $weekly[$dayKey]['opens'] ?? null;
            $closes = $weekly[$dayKey]['closes'] ?? null;
            if ($opens && $closes) {
                $openingHours[$dayKey] = [sprintf('%s-%s', $opens, $closes)];
            } else {
                $openingHours[$dayKey] = [];
            }
        }
        try { OpeningHours::create($openingHours); } catch (\Throwable $e) {}
        $validated['opening_hours'] = $openingHours;

        $doctor->update($validated);

        return redirect()->route('doctors.index', ['segment' => $segment])
            ->with('success', 'Doctor updated successfully.');
    }

    public function destroy(Request $request, string $segment, Doctor $doctor)
    {
        $doctor->delete();
        return response()->json([
            'success' => true,
            'message' => 'Doctor deleted successfully.',
        ]);
    }
}

