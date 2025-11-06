<x-master>
    <x-slot name="title">Export Appointment</x-slot>

    <div class="container-fluid py-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold">Export Appointment</h4>
        </div>

        <div class="glass-card p-3">
            <!-- Filters Section -->
            <div class="filter-section mb-3 gap-2" style="display: grid; grid-template-columns: repeat(3,1fr);">
                <!-- Doctor Dropdown -->
                <select id="doctorSelect" class="form-select">
                    <option value="">Select Doctor</option>
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}">
                            {{ $doctor->name }}
                            @if ($doctor->specialization)
                                ({{ $doctor->specialization->name }})
                            @endif
                        </option>
                    @endforeach
                </select>

                <!-- Date Picker -->
                <input type="date" id="appointmentDate" class="form-control" />

                <!-- Search Button -->
                <button id="searchBtn" class="btn btn-accent btn-sm" style="width: 100px;">
                    <i class="bi bi-search me-1"></i> Search
                </button>
            </div>

            <!-- Table and Export Button Section -->
            <div id="resultSection" style="display:none;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="fw-bold my-0">Appointment List</h5>
                    <button id="exportBtn" class="btn btn-success btn-sm">
                        <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
                    </button>
                </div>

                <div class="table-responsive">
                    <table id="ExportAppointmentTable" class="table table-striped align-middle w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Doctor</th>
                                <th>Patient Name</th>
                                <th>Phone</th>
                                <th>Gender</th>
                                <th>Age</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Select2 for searchable dropdown -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Enable searchable dropdown
            $('#doctorSelect').select2({
                placeholder: 'Select Doctor',
                allowClear: true,
                width: '100%'
            });

            let table = $('#ExportAppointmentTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: '{{ route('export-appointment.data', ['segment' => $segment]) }}',
                    data: function(d) {
                        // Always get current values
                        d.doctor_id = $('#doctorSelect').val();
                        d.date = $('#appointmentDate').val();
                    }
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'doctor_name'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'phone'
                    },
                    {
                        data: 'gender'
                    },
                    {
                        data: 'age'
                    },
                    {
                        data: 'type'
                    },
                ]
            });

            // Hide the table initially
            $('#resultSection').hide();

            // Search button action
            $('#searchBtn').on('click', function() {
                const doctorId = $('#doctorSelect').val();
                const date = $('#appointmentDate').val();

                if (!doctorId || !date) {
                    alert('Please select both Doctor and Date.');
                    return;
                }

                // Show table
                $('#resultSection').show();

                // Reload DataTable with updated parameters
                table.ajax.reload();
            });

            // Export button action
            $('#exportBtn').on('click', function() {
                const doctorId = $('#doctorSelect').val();
                const date = $('#appointmentDate').val();

                if (!doctorId || !date) {
                    alert('Please select both Doctor and Date.');
                    return;
                }

                const url = '{{ route('export-appointment.exportPdf', ['segment' => $segment]) }}' +
                    '?doctor_id=' + doctorId + '&date=' + date;

                window.open(url, '_blank');
            });
        });
    </script>
</x-master>
