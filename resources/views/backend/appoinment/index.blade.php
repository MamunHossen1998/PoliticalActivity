<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Doctor Appointment System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.css" rel="stylesheet" />
    <style>
        /* General input styling */
        input[type="date"],
        input[type="time"],
        input[type="datetime-local"] {
            color-scheme: dark;
            /* Ensures white icons in dark backgrounds */
            color: #fff;
            background-color: transparent;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
        }

        /* Chrome, Edge, Safari */
        input[type="date"]::-webkit-calendar-picker-indicator,
        input[type="time"]::-webkit-calendar-picker-indicator,
        input[type="datetime-local"]::-webkit-calendar-picker-indicator {
            filter: brightness(0) invert(1);
            /* Makes icons white */
            opacity: 0.9;
            cursor: pointer;
        }

        /* Firefox */
        input[type="date"],
        input[type="time"],
        input[type="datetime-local"] {
            --calendar-picker-color: #fff;
        }

        /* Optional hover effect */
        input[type="date"]:hover::-webkit-calendar-picker-indicator,
        input[type="time"]:hover::-webkit-calendar-picker-indicator {
            opacity: 1;
            transform: scale(1.1);
        }

        .form-check-input {
            appearance: none;
            -webkit-appearance: none;
            width: 14px;
            height: 14px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            background-color: transparent;
            border-radius: 3px;
            display: inline-block;
            position: relative;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        .form-check-input:checked {
            background-color: #00e6ff;
            /* neon cyan */
            border-color: #00e6ff;
            box-shadow: 0 0 5px #00e6ff, 0 0 15px #00e6ff;
        }

        /* Create the tick mark */
        .form-check-input:checked::after {
            content: "";
            position: absolute;
            top: 2px;
            left: 4px;
            width: 4px;
            height: 8px;
            border: solid #000;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        /* Optional hover glow */
        .form-check-input:hover {
            box-shadow: 0 0 8px rgba(0, 230, 255, 0.5);
        }

        .form-check-label {
            cursor: pointer;
            user-select: none;
            color: #ccc;
        }

        /* Dropdown arrow for modern browsers */


        /* On focus */

        /* <option> text and background fix */
        option {
            color: #000;
        }

        /* Optional hover/focus for open dropdowns (Chrome/Edge) */

        :root {
            --neon-cyan: #00bfff;
            --dark-bg: #0b0f1a;
            --panel-bg: rgba(20, 26, 40, 0.6);
            --text-light: #e5e5e5;
            --border-color: rgba(255, 255, 255, 0.08);
            --glow: 0 0 12px rgba(0, 245, 255, 0.3);
        }

        body {
            font-size: 13px;
            background: var(--dark-bg);
            color: var(--text-light);
            font-family: 'Segoe UI', sans-serif;
            overflow-x: hidden;
        }

        .panel {
            background: var(--panel-bg);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            box-shadow: inset 1px 1px 2px rgba(255, 255, 255, 0.06), 0 0 18px rgba(0, 245, 255, 0.05);
            backdrop-filter: blur(10px);
            padding: 12px;
            transition: all 0.3s ease;
        }

        .panel:hover {
            box-shadow: 0 0 20px rgba(0, 245, 255, 0.2);
            transform: translateY(-2px);
        }

        .section-title {
            font-weight: 600;
            font-size: 14px;
            color: var(--neon-cyan);
            border-bottom: 1px solid rgba(0, 245, 255, 0.25);
            margin-bottom: 8px;
            padding-bottom: 3px;
            text-shadow: 0 0 5px rgba(0, 245, 255, 0.4);
        }

        input,
        select,
        .form-control,
        .form-select {
            font-size: 12px;
            height: 28px;
            padding: 2px 6px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(0, 245, 255, 0.15);
            color: var(--text-light);
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        input:focus,
        select:focus {
            outline: none;
            background: rgba(0, 245, 255, 0.08);
            border-color: var(--neon-cyan);
            box-shadow: 0 0 8px rgba(0, 245, 255, 0.25);
            color: #fff;
        }

        input::placeholder {
            color: #bbb;
        }

        .table {
            color: var(--text-light);
            border-color: rgba(255, 255, 255, 0.1) !important;
        }

        .table thead th {
            background: rgba(0, 245, 255, 0.08) !important;
            color: var(--neon-cyan) !important;
            border-bottom: 1px solid rgba(0, 245, 255, 0.15);
        }

        .table tbody tr:hover {
            background: rgba(0, 245, 255, 0.05);
            transition: 0.2s;
        }

        .btn {
            border-radius: 6px;
            font-size: 12px;
            padding: 3px 10px;
            border: 1px solid transparent;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: var(--neon-cyan);
            border: none;
            color: #000;
            font-weight: 600;
            box-shadow: var(--glow);
        }

        .btn-primary:hover {
            /* background: #00ffff; */
            box-shadow: 0 0 15px rgba(0, 245, 255, 0.4);
        }

        .btn-outline-secondary {
            color: var(--text-light);
            border: 1px solid rgba(0, 245, 255, 0.2);
        }

        .btn-outline-secondary:hover {
            background: rgba(0, 245, 255, 0.1);
            color: var(--neon-cyan);
        }

        .nav-tabs .nav-link {
            color: #aaa;
            border: none;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link.active {
            color: var(--neon-cyan);
            background-color: rgba(0, 245, 255, 0.12);
            border-bottom: 2px solid var(--neon-cyan);
            box-shadow: 0 0 10px rgba(0, 245, 255, 0.2);
        }

        .badge {
            font-size: 10px;
            border-radius: 6px;
            padding: 3px 6px;
            box-shadow: 0 0 8px rgba(0, 245, 255, 0.15);
        }

        .small-label {
            font-size: 11px;
            color: #aaa;
        }

        .progress {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 5px;
        }

        .progress-bar {
            box-shadow: 0 0 8px rgba(0, 245, 255, 0.4);
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(0, 245, 255, 0.3);
            border-radius: 4px;
        }

        /* Doctor list interactions */
        #doctors-table tbody tr {
            cursor: pointer;
        }

        #doctors-table tbody tr.table-active {
            font-weight: 700;
        }
    </style>
</head>

<body>

    <div class="container-fluid p-2">
        <div class="row g-3">

            <!-- Doctor List -->
            <div class="col-lg-3 col-md-4">
                <div class="panel">
                    <div class="section-title">Doctor List</div>
                    <div class="mb-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 5px;">
                        <input type="date" class="form-control" id="filter_date" value="<?php echo date('Y-m-d'); ?>">
                        <select class="form-select">
                            <option>Morning</option>
                            <option>Evening</option>
                        </select>
                        <input type="text" placeholder="Doctor Name" class="form-control" id="filter_name">
                        <select class="form-select" id="filter_specialization">
                            <option value="">Select Specialization</option>
                            @foreach ($specializations ?? [] as $spec)
                                <option value="{{ $spec->id }}">{{ $spec->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="table-responsive" style="max-height:70vh; overflow:auto;">
                        <table class="table table-bordered table-hover table-sm align-middle" id="doctors-table"
                            style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th>SL</th>
                                    <th>Doctor Name</th>
                                    <th>Specialization</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Appointment Slab -->
            <div class="col-lg-4 col-md-8">
                <div class="panel">
                    <div class="section-title mb-3">Appointment Slab</div>
                    <div class="row g-2 mb-3 align-items-end">
                        <div class="col-md-7">
                            <label class="small-label mb-1">App. Time</label>
                            <div class="d-flex">
                                <input type="time" class="form-control form-control-sm me-1" value="10:00">
                                <input type="time" class="form-control form-control-sm" value="13:00">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="small-label mb-1">Avg. Load</label>
                            <input type="number" class="form-control form-control-sm" value="100">
                        </div>
                        <div class="col-md-2">
                            <label class="small-label mb-1">Duration</label>
                            <input type="number" class="form-control form-control-sm" value="5">
                        </div>
                    </div>
                    <button class="btn btn-primary btn-sm w-100 mb-3">Generate New Slot</button>
                    <div class="d-flex justify-content-between mb-2 small">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <label class="form-check-label" style="display: flex; align-items: center; gap: 3px;"><input
                                    type="radio" name="priority" checked> Normal</label>
                            <label class="form-check-label" style="display: flex; align-items: center; gap: 3px;"><input
                                    type="radio" name="priority"> VIP</label>
                        </div>
                        <div>
                            <span class="badge bg-info text-dark">Fast</span>
                            <span class="badge bg-warning text-dark">Split</span>
                            <span class="badge bg-secondary">R.Slot</span>
                        </div>
                    </div>
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered table-sm align-middle" id="appointments-table">
                            <thead class="table-light small">
                                <tr>
                                    <th style="width:50px">SL</th>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody class="small" id="appointments-body"></tbody>
                        </table>
                    </div>
                    {{-- <div class="d-flex justify-content-between small">
                        <div><span class="badge bg-success">Occupied</span></div>
                        <div><span class="badge bg-danger">Expired</span></div>
                        <div><span class="badge bg-info text-dark">Prs.com</span></div>
                        <div><span class="badge bg-warning text-dark">Paid</span></div>
                        <div><span class="badge bg-secondary">Cancel</span></div>
                    </div> --}}
                </div>
            </div>

            <!-- Doctor Info -->
            <div class="col-lg-5">
                <div class="panel" style="max-height: 85vh; overflow-y: auto;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="section-title">Doctor's Information</div>
                        <div>
                            <button class="btn btn-outline-secondary btn-sm me-1">View Schedule</button>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" id="extDoc">
                                <label class="form-check-label small" for="extDoc">External Doctor?</label>
                            </div>
                        </div>
                    </div>

                    <div class="row g-2 mb-3 text-light" id="doctor-info">
                        <div class="col-6"><strong class="text-info">Doctor No :</strong> <span
                                id="info_doctor_no">-</span></div>
                        <div class="col-6"><strong class="text-info">Name :</strong> <span id="info_name">-</span>
                        </div>
                        <div class="col-6"><strong class="text-info">Degree :</strong> <span
                                id="info_degree">-</span></div>
                        <div class="col-6"><strong class="text-info">Specialty :</strong> <span
                                id="info_specialty">-</span></div>
                        <div class="col-6 text-danger"><strong class="text-info">Remarks :</strong> <span
                                id="info_remarks">-</span></div>
                        <div class="col-6"><strong class="text-info">Location :</strong> <span
                                id="info_location">-</span></div>
                        <div class="col-6"><strong class="text-info">Phone :</strong> <span id="info_phone">-</span>
                        </div>
                        <div class="col-6"><strong class="text-info">Prev. Ins. :</strong> <span
                                id="info_prev_ins">-</span></div>
                        <div class="col-6"><strong class="text-info">Start Time :</strong> <span
                                id="info_start">-</span></div>
                        <div class="col-6"><strong class="text-info">End Time :</strong> <span
                                id="info_end">-</span></div>
                        <div class="col-6"><strong class="text-info">Avg. Duration :</strong> <span
                                id="info_avg_duration">-</span></div>
                        <div class="col-6"><strong class="text-info">Avg. Load :</strong> <span id="info_avg_load">-</span></div>
                        <div class="col-6"><strong class="text-info">Reg. No :</strong> <span id="info_registration_no">-</span></div>
                        <div class="col-6"><strong class="text-info">Experience (Years) :</strong> <span id="info_experience_years">-</span></div>
                        <div class="col-6"><strong class="text-info">First Visit Fee :</strong> <span id="info_first_visit_fee">-</span></div>
                        <div class="col-6"><strong class="text-info">Follow-up Fee :</strong> <span id="info_follow_up_fee">-</span></div>
                        <div class="col-6"><strong class="text-info">Follow-up Validity (Days) :</strong> <span id="info_follow_up_validity_days">-</span></div>
                        <div class="col-6"><strong class="text-info">Reserved :</strong> <span id="info_reserved">-</span></div>
                    </div>

                    <hr class="my-2 border-secondary">

                    <ul class="nav nav-tabs small mb-2" id="appTabs" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab"
                                href="#appointment">Appointment</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#cancel">Cancelled</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#replace">Replaced</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="appointment">
                            <input type="hidden" id="selected_doctor_id" value="">
                            <div id="error_doctor_id" class="invalid-feedback d-block"></div>
                            <div id="appointmentForm" class="row g-2">
                                <div class="col-6">
                                    <label class="small-label">Patient</label>
                                    <input type="text" class="form-control form-control-sm" id="patient_name"
                                        placeholder="Full name">
                                    <div class="invalid-feedback d-block" id="error_name"></div>
                                </div>
                                <div class="col-6">
                                    <label class="small-label">Age</label>
                                    <input type="text" class="form-control form-control-sm" id="patient_age"
                                        placeholder="YY">
                                    <div class="invalid-feedback d-block" id="error_age"></div>
                                </div>
                                <div class="col-6">
                                    <label class="small-label">Phone</label>
                                    <input type="text" class="form-control form-control-sm" id="patient_phone"
                                        placeholder="01XXXXXXXXX">
                                    <div class="invalid-feedback d-block" id="error_phone"></div>
                                </div>
                                <div class="col-6">
                                    <label class="small-label">Gender</label>
                                    <select class="form-select form-select-sm" id="patient_gender">
                                        <option value="">Select</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <div class="invalid-feedback d-block" id="error_gender"></div>
                                </div>
                                <div class="col-6">
                                    <label class="small-label">Patient Type</label>
                                    <select class="form-select form-select-sm" id="patient_type">
                                        <option value="">Select</option>
                                        <option value="New">New</option>
                                        <option value="Old">Old</option>
                                        <option value="Follow-Up">Follow-Up</option>
                                    </select>
                                    <div class="invalid-feedback d-block" id="error_type"></div>
                                </div>
                            </div>
                            <div class="mt-3 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <a href="{{ route('dashboard', ['segment' => $segment]) }}"
                                            class="btn btn-outline-secondary btn-sm">
                                            <i class="bi bi-arrow-left"></i> Back Dashboard
                                        </a>
                                    </div>
                                </div>
                                <div>
                                    <button class="btn btn-primary btn-sm" id="btnSaveAppointment">New Appointment
                                    </button>

                                    <button class="btn btn-info btn-sm text-dark">Report</button>
                                </div>
                            </div>
                            <div class="progress mt-3" style="height: 8px;">
                                <div class="progress-bar bg-success" style="width: 70%;"></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="cancel">
                            <p class="small text-light mt-2">Cancelled appointments list here...</p>
                        </div>
                        <div class="tab-pane fade" id="replace">
                            <p class="small text-light mt-2">Cancelled & replaced appointments list here...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast container -->
    <div class="position-fixed bottom-0 start-0 p-3" style="z-index: 1080;">
        <div id="toastSuccess" class="toast align-items-center text-bg-success border-0" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="toastSuccessBody">Success</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.js"></script>
    <script>
        (function() {
            const table = $('#doctors-table').DataTable({
                processing: false,
                serverSide: false,
                searching: false,
                lengthChange: false,
                paging: false,
                info: false,
                ajax: {
                    url: "{{ route('appoinment.doctors.data', ['segment' => $segment]) }}",
                    dataSrc: 'data',
                    data: function(d) {
                        d.doctor_name = $('#filter_name').val();
                        d.specialization_id = $('#filter_specialization').val();
                        d.date = $('#filter_date').val();
                    }
                },
                columns: [{
                        data: null,
                        name: 'sl',
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        },
                        orderable: false,
                        searchable: false,
                    },

                    {

                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'specialization',
                        name: 'specialization'
                    },
                ],
                order: [
                    [1, 'asc']
                ],
            });

            // Trigger reload on filters
            $('#filter_name').on('keyup', debounce(() => table.ajax.reload(), 300));
            $('#filter_specialization, #filter_date').on('change', () => table.ajax.reload());

            // Row click -> load doctor details
            $('#doctors-table tbody').on('click', 'tr', function() {
                const row = table.row(this);
                if (!row.data()) return;
                $('#doctors-table tbody tr').removeClass('table-active');
                $(this).addClass('table-active');
                const id = row.data().id; // present in JSON payload even if not a column
                const url = "{{ url($segment . '/appoinment/doctors') }}" + '/' + id;
                fetch(url)
                    .then(r => r.json())
                    .then(d => {
                        // set selected doctor id and enable Save
                        $('#selected_doctor_id').val(id);
                        $('#btnSaveAppointment').prop('disabled', false);
                        setInfo('#info_doctor_no', d.doctor_no);
                        setInfo('#info_name', d.name);
                        setInfo('#info_degree', d.degree);
                        setInfo('#info_specialty', d.specialty);
                        setInfo('#info_remarks', d.remarks);
                        setInfo('#info_location', d.location || d.chamber_address);
                        setInfo('#info_phone', d.phone);
                        setInfo('#info_start', d.start_time_label || d.start_time);
                        setInfo('#info_end', d.end_time_label || d.end_time);
                        setInfo('#info_avg_duration', d.avg_duration ? (d.avg_duration + ' Min') : '-');
                        setInfo('#info_avg_load', d.avg_load ? (d.avg_load + '/Day') : '-');
                        setInfo('#info_registration_no', d.registration_no);
                        setInfo('#info_experience_years', d.experience_years);
                        setInfo('#info_first_visit_fee', d.first_visit_fee ? (d.first_visit_fee + ' Tk') : '-');
                        setInfo('#info_follow_up_fee', d.follow_up_fee ? (d.follow_up_fee + ' Tk') : '-');
                        setInfo('#info_follow_up_validity_days', d.follow_up_validity_days ? (d.follow_up_validity_days + ' Days') : '-');
                        setInfo('#info_reserved', (d.reserved === 1 || d.reserved === true) ? 'Yes' : 'No');
                        loadAppointments(id);
                    })
                    .catch(() => {});
            });

            function setInfo(sel, val) {
                $(sel).text(val && String(val).trim() !== '' ? val : '-');
            }

            function debounce(fn, wait) {
                let t;
                return function() {
                    clearTimeout(t);
                    t = setTimeout(fn, wait);
                };
            }

            function loadAppointments(doctorId) {
                if (!doctorId) {
                    $('#appointments-body').html('');
                    return;
                }
                const listUrl = '{{ route('appoinment.appointments.list', ['segment' => $segment]) }}' + '?doctor_id=' +
                    doctorId;
                fetch(listUrl)
                    .then(r => r.json())
                    .then(res => {
                        const rows = (res.data || []).map((item, idx) => {
                            const t = new Date(item.created_at).toLocaleString();
                            return `
                                <tr>
                                    <td>${idx + 1}</td>
                                    <td>${item.name ?? '-'}</td>
                                    <td>${item.age ?? '-'}</td>
                                    <td>${item.type ?? '-'}</td>
                                </tr>
                            `;
                        }).join('');
                        $('#appointments-body').html(rows ||
                            '<tr><td colspan="7" class="text-center small">No appointments</td></tr>');
                    })
                    .catch(() => {
                        $('#appointments-body').html(
                            '<tr><td colspan="7" class="text-center text-danger small">Failed to load</td></tr>'
                        );
                    });
            }

            function clearFieldErrors() {
                $('#appointmentForm .is-invalid').removeClass('is-invalid');
                $('#error_name, #error_phone, #error_gender, #error_age, #error_type, #error_doctor_id').text('');
            }

            function showFieldError(field, message) {
                const fieldMap = {
                    doctor_id: '#selected_doctor_id',
                    name: '#patient_name',
                    phone: '#patient_phone',
                    gender: '#patient_gender',
                    age: '#patient_age',
                    type: '#patient_type',
                };
                const inputSel = fieldMap[field];
                if (inputSel) $(inputSel).addClass('is-invalid');
                const errSel = '#error_' + field;
                $(errSel).text(message || '');
            }

            function showToastSuccess(msg) {
                $('#toastSuccessBody').text(msg || 'Success');
                const el = document.getElementById('toastSuccess');
                const t = new bootstrap.Toast(el, {
                    delay: 2000
                });
                t.show();
            }

            // Save appointment via AJAX
            $(document).on('click', '#btnSaveAppointment', function() {
                clearFieldErrors();
                const payload = {
                    doctor_id: $('#selected_doctor_id').val(),
                    name: $('#patient_name').val()?.trim(),
                    phone: $('#patient_phone').val()?.trim(),
                    gender: $('#patient_gender').val(),
                    age: $('#patient_age').val()?.trim(),
                    type: $('#patient_type').val() === 'Old' ? 'Follow-Up' : $('#patient_type').val()
                };

                if (!payload.doctor_id) {
                    showFieldError('doctor_id', 'Please select a doctor.');
                    return;
                }

                fetch("{{ route('appoinment.appointments.store', ['segment' => $segment]) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute(
                                'content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(async (r) => {
                        if (!r.ok) {
                            const err = await r.json().catch(() => ({}));
                            throw err;
                        }
                        return r.json();
                    })
                    .then((res) => {
                        showToastSuccess('Appointment created successfully');
                        // reset simple fields
                        $('#patient_name').val('');
                        $('#patient_phone').val('');
                        $('#patient_gender').val('');
                        $('#patient_age').val('');
                        $('#patient_type').val('');
                        const did = $('#selected_doctor_id').val();
                        loadAppointments(did);
                    })
                    .catch((err) => {
                        if (err && err.errors) {
                            Object.entries(err.errors).forEach(([field, messages]) => {
                                showFieldError(field, messages && messages[0] ? messages[0] :
                                    'Invalid');
                            });
                        } else {
                            showToastSuccess('Failed to create appointment');
                        }
                    });
            });
        })();
    </script>
</body>

</html>
