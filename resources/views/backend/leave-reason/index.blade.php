<x-master>
    <x-slot name="title">Leave Reason</x-slot>

    <div class="container-fluid py-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold">Leave Reason</h4>
            <button class="btn btn-accent btn-sm" id="btnAddLeaveReason"
                data-url="{{ route('leave-reason.create', ['segment' => $segment]) }}">
                <i class="bi bi-plus-lg me-1"></i> Add Leave Reason
            </button>
        </div>

        <div class="glass-card p-3">
            <div class="table-responsive">
                <table id="LeaveReasonTable" class="table table-striped align-middle w-100">
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
            const table = $('#LeaveReasonTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('leave-reason.data', ['segment' => $segment]) }}',
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
            $('#btnAddLeaveReason').on('click', function() {
                const url = $(this).data('url');
                openOffcanvas(url, 'Add Leave Reason');
            });

            // Open Edit
            $(document).on('click', '.btnEditLeaveReason', function() {
                const url = $(this).data('url');
                openOffcanvas(url, 'Edit Leave Reason');
            });

            // Delete
            $(document).on('click', '.btnDeleteLeaveReason', function() {
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
