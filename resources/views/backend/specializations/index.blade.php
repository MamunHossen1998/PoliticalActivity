<x-master>
    <x-slot name="title">Specializations</x-slot>

    <div class="container-fluid py-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold">Specializations</h4>
            <button class="btn btn-accent btn-sm" id="btnAddSpecialization"
                data-url="{{ route('specializations.create', ['segment' => $segment]) }}">
                <i class="bi bi-plus-lg me-1"></i> Add Specialization
            </button>
        </div>

        <div class="glass-card p-3">
            <div class="table-responsive">
                <table id="specializationsTable" class="table table-striped align-middle w-100">
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
            const table = $('#specializationsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('specializations.data', ['segment' => $segment]) }}',
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
            $('#btnAddSpecialization').on('click', function() {
                const url = $(this).data('url');
                openOffcanvas(url, 'Add Specialization');
            });

            // Open Edit
            $(document).on('click', '.btnEditSpecialization', function() {
                const url = $(this).data('url');
                openOffcanvas(url, 'Edit Specialization');
            });

            // Delete
            $(document).on('click', '.btnDeleteSpecialization', function() {
                const url = $(this).data('url');
                confirmAjaxDelete(url, function() {
                    table.ajax.reload(null, false);
                });
            });

            window.__specializationsDT = table;
        });
    </script>
</x-master>
