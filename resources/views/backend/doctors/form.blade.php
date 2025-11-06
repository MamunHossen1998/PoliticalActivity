<x-master>
    <x-slot name="title">{{ $method === 'POST' ? 'Add Doctor' : 'Edit Doctor' }}</x-slot>

    <div class="container-fluid py-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold">{{ $method === 'POST' ? 'Doctor Create' : 'Edit Doctor' }}</h4>
            <a class="btn btn-outline-info btn-sm"
                href="{{ route('doctors.index', ['segment' => request()->route('segment')]) }}">Back</a>
        </div>

        <div class="glass-card p-3">
            <form action="{{ $action }}" method="POST">
                @csrf
                @if ($method !== 'POST')
                    @method($method)
                @endif

                <div class="row g-3">
                    {{-- Doctor Name --}}
                    <div class="col-md-4">
                        <label class="form-label small text-secondary">Doctor Name <span
                                class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $doctor->name) }}"
                            class="form-control form-control-sm bg-transparent border-secondary">
                        @error('name')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Doctor No --}}
                    <div class="col-md-4">
                        <label class="form-label small text-secondary">Doctor No <span
                                class="text-danger">*</span></label>
                        <input type="text" name="doctor_no" value="{{ old('doctor_no', $doctor->doctor_no) }}"
                            class="form-control form-control-sm bg-transparent border-secondary">
                        @error('doctor_no')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Degree --}}
                    <div class="col-md-4">
                        <label class="form-label small text-secondary">Doctor Degree <span
                                class="text-danger">*</span></label>
                        <input type="text" name="degree" value="{{ old('degree', $doctor->degree) }}"
                            class="form-control form-control-sm bg-transparent border-secondary">
                        @error('degree')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Specialty --}}
                    <div class="col-md-4">
                        <label class="form-label small text-secondary">Doctor Specialty <span
                                class="text-danger">*</span></label>
                        <input type="text" name="specialty" value="{{ old('specialty', $doctor->specialty) }}"
                            class="form-control form-control-sm bg-transparent border-secondary">
                        @error('specialty')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- First Visit Fee --}}
                    <div class="col-md-4">
                        <label class="form-label small text-secondary">First Visit Fee <span
                                class="text-danger">*</span></label>
                        <input type="number" name="first_visit_fee"
                            value="{{ old('first_visit_fee', $doctor->first_visit_fee) }}"
                            class="form-control form-control-sm bg-transparent border-secondary">
                        @error('first_visit_fee')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Follow-Up Fee --}}
                    <div class="col-md-4">
                        <label class="form-label small text-secondary">Follow-Up Fee <span
                                class="text-danger">*</span></label>
                        <input type="number" name="follow_up_fee"
                            value="{{ old('follow_up_fee', $doctor->follow_up_fee) }}"
                            class="form-control form-control-sm bg-transparent border-secondary">
                        @error('follow_up_fee')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Follow-Up Validity --}}
                    <div class="col-md-4">
                        <label class="form-label small text-secondary">Follow-Up Validity (Days) <span
                                class="text-danger">*</span></label>
                        <input type="number" name="follow_up_validity_days"
                            value="{{ old('follow_up_validity_days', $doctor->follow_up_validity_days) }}"
                            class="form-control form-control-sm bg-transparent border-secondary">
                        @error('follow_up_validity_days')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Location --}}
                    <div class="col-md-4">
                        <label class="form-label small text-secondary">Location <span
                                class="text-danger">*</span></label>
                        <input type="text" name="location" value="{{ old('location', $doctor->location) }}"
                            class="form-control form-control-sm bg-transparent border-secondary"
                            placeholder="Chamber (S-282)">
                        @error('location')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Avg. Duration --}}
                    <div class="col-md-4">
                        <label class="form-label small text-secondary">Avg. Duration (Minutes) <span
                                class="text-danger">*</span></label>
                        <input type="number" name="avg_duration"
                            value="{{ old('avg_duration', $doctor->avg_duration) }}"
                            class="form-control form-control-sm bg-transparent border-secondary">
                        @error('avg_duration')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Avg. Load --}}
                    <div class="col-md-4">
                        <label class="form-label small text-secondary">Avg. Load <span
                                class="text-danger">*</span></label>
                        <input type="number" name="avg_load" value="{{ old('avg_load', $doctor->avg_load) }}"
                            class="form-control form-control-sm bg-transparent border-secondary">
                        @error('avg_load')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Reserved --}}
                    <div class="col-md-4">
                        <label class="form-label small text-secondary">Reserved Slots <span
                                class="text-danger">*</span></label>
                        <input type="number" name="reserved" value="{{ old('reserved', $doctor->reserved) }}"
                            class="form-control form-control-sm bg-transparent border-secondary">
                        @error('reserved')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="col-md-4">
                        <label class="form-label small text-secondary">Email</label>
                        <input type="email" name="email" value="{{ old('email', $doctor->email) }}"
                            class="form-control form-control-sm bg-transparent border-secondary">
                        @error('email')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div class="col-md-4">
                        <label class="form-label small text-secondary">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $doctor->phone) }}"
                            class="form-control form-control-sm bg-transparent border-secondary">
                        @error('phone')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Branch --}}
                    <div class="col-md-4">
                        <label class="form-label small text-secondary">Branch</label>
                        @php($currentBranchId = old('branch_id', $doctor->branch_id ?? null))
                        <select name="branch_id" class="form-select form-select-sm bg-transparent border-secondary">
                            <option value="">-- None --</option>
                            @foreach ($branches ?? [] as $b)
                                <option value="{{ $b->id }}" @if ((string) $currentBranchId === (string) $b->id) selected @endif>
                                    {{ $b->name }}</option>
                            @endforeach
                        </select>
                        @error('branch_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Specialization --}}
                    <div class="col-md-4">
                        <label class="form-label small text-secondary">Specialization</label>
                        @php($currentSpecId = old('specialization_id', $doctor->specialization_id ?? null))
                        <select name="specialization_id"
                            class="form-select form-select-sm bg-transparent border-secondary">
                            <option value="">-- None --</option>
                            @foreach ($specializations ?? [] as $s)
                                <option value="{{ $s->id }}" @if ((string) $currentSpecId === (string) $s->id) selected @endif>
                                    {{ $s->name }}</option>
                            @endforeach
                        </select>
                        @error('specialization_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="col-md-12">
                        <label class="form-label small text-secondary">Description</label>
                        <textarea name="description" rows="3" class="form-control form-control-sm bg-transparent border-secondary">{{ old('description', $doctor->description) }}</textarea>
                        @error('description')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Weekly Opening Hours --}}
                <div class="col-12 mt-5">
                    <label class="form-label d-block">Weekly Opening Hours</label>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:20%">Day</th>
                                    <th style="width:15%">Open?</th>
                                    <th style="width:25%">Opens</th>
                                    <th style="width:25%">Closes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'])
                                @foreach ($days as $d)
                                    <tr>
                                        <td class="text-capitalize">{{ $d }}</td>
                                        <td>
                                            <input type="checkbox" class="form-check-input"
                                                onchange="(function(cb){const tr=cb.closest('tr');const on=cb.checked;tr.querySelectorAll('input[type=time]').forEach(function(el){el.disabled=!on;});})(this)">
                                        </td>
                                        <td>
                                            <input type="time" name="weekly[{{ $d }}][opens]"
                                                class="form-control"
                                                value="{{ old('weekly.' . $d . '.opens', $weekly[$d]['opens'] ?? '') }}">
                                        </td>
                                        <td>
                                            <input type="time" name="weekly[{{ $d }}][closes]"
                                                class="form-control"
                                                value="{{ old('weekly.' . $d . '.closes', $weekly[$d]['closes'] ?? '') }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('doctors.index', ['segment' => request()->route('segment')]) }}"
                        class="btn btn-outline-info">Cancel</a>
                    <button type="submit" class="btn btn-accent">Save</button>
                </div>
            </form>
        </div>
    </div>
</x-master>
