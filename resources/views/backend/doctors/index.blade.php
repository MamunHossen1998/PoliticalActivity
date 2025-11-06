<x-master>
    <x-slot name="title">Doctors</x-slot>

    <div class="container-fluid py-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold">Doctors</h4>
            <a class="btn btn-accent btn-sm" href="{{ route('doctors.create', ['segment' => $segment]) }}">
                <i class="bi bi-plus-lg me-1"></i> Add Doctor
            </a>
        </div>

        <div class="glass-card p-3">
            <div class="table-responsive">
                <table id="doctorsTable" class="table table-striped align-middle w-100">
                    <thead>
                        <tr>
                            <th data-data="id">SL</th>
                            <th data-data="name">Name</th>
                            <th data-data="name">Degree</th>
                            <th data-data="specialization">Specialization</th>
                            <th data-data="phone">Phone</th>
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
            const table = $('#doctorsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('doctors.data', ['segment' => $segment]) }}',
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
                        data: 'degree',
                        name: 'degree'
                    },
                    {
                        data: 'specialization',
                        name: 'specialization'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
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

            $(document).on('click', '.btnDeleteDoctor', function() {
                const url = $(this).data('url');
                confirmAjaxDelete(url, function() {
                    table.ajax.reload(null, false);
                });
            });

            window.__doctorsDT = table;
        });
    </script>
</x-master>
