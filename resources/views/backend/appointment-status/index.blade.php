<x-master>
    <x-slot name="title">Appointment Status</x-slot>

    <div class="container-fluid py-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold">Appointment Status</h4>
            <button class="btn btn-accent btn-sm" id="btnAddAppointmentStatus"
                data-url="{{ route('appointment-status.create', ['segment' => $segment]) }}">
                <i class="bi bi-plus-lg me-1"></i> Add Appointment Status
            </button>
        </div>

        <div class="glass-card p-3">
            <div class="table-responsive">
                <table id="AppointmentStatusTable" class="table table-striped align-middle w-100">
                    <thead>
                        <tr>
                            <th data-data="id">#</th>
                            <th data-data="name">Name</th>
                            <th data-data="status">Status</th>
                            <th data-data="actions" class="text-end">Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const table = $('#AppointmentStatusTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('appointment-status.data', ['segment' => $segment]) }}',
                columns: [{
                        data: 'id',
                        name: 'id',
                        width: '70px'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        className: 'text-end'
                    }
                ]
            });

            // Open Create
            $('#btnAddAppointmentStatus').on('click', function() {
                const url = $(this).data('url');
                openOffcanvas(url, 'Add Appointment Status');
            });

            // Open Edit
            $(document).on('click', '.btnEditAppointmentStatus', function() {
                const url = $(this).data('url');
                openOffcanvas(url, 'Edit Appointment Status');
            });

            // Delete
            $(document).on('click', '.btnDeleteAppointmentStatus', function() {
                const url = $(this).data('url');
                confirmAjaxDelete(url, function() {
                    table.ajax.reload(null, false);
                });
            });

            // Expose for forms in offcanvas
            window.__branchesDT = table;
        });
    </script>
</x-master>
