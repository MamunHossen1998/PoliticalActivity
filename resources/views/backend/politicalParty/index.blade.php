<x-master>
    <x-slot name="title">Admin Users</x-slot>

    <div class="container-fluid py-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold">Admin Users</h4>
            <button class="btn btn-accent btn-sm" id="btnAddUser"
                data-url="{{ route('politicalParty.create', ['segment' => $segment]) }}">
                <i class="bi bi-person-plus me-1"></i> Add Party
            </button>
        </div>

        <div class="glass-card p-3">
            <div class="table-responsive">
                <table id="politicalPartyList" class="table table-striped align-middle w-100">
                    <thead>
                        <tr>
                            <th data-data="id">Sl</th>
                            <th data-data="name">Name</th>
                            <th data-data="email">Abbreviation</th>
                            <th data-data="roles">Founded year</th>
                            <th data-data="roles">Created at</th>
                            <th data-data="actions" class="text-end">Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const table = $('#politicalPartyList').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('politicalParty.data', ['segment' => $segment]) }}',
                columns: [
                    {
                        data: 'sl',
                        name: 'Sl'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'abbreviation',
                        name: 'abbreviation'
                    },
                    {
                        data: 'founded_year',
                        name: 'founded_year'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
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
            $('#btnAddUser').on('click', function() {
                const url = $(this).data('url');
                openOffcanvas(url, 'Add User');
            });

            // Open Edit
            $(document).on('click', '.btnEditUser', function() {
                const url = $(this).data('url');
                openOffcanvas(url, 'Edit User');
            });

            // Delete
            $(document).on('click', '.btnDeleteUser', function() {
                const url = $(this).data('url');
                confirmAjaxDelete(url, function() {
                    table.ajax.reload(null, false);
                });
            });

            // Expose for forms in offcanvas
            window.__usersDT = table;
        });
    </script>
</x-master>
