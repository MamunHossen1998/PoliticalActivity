<div class="text-end">
    <button class="btn btn-sm btn-outline-info me-1 btnEditLeaveReason"
        data-url="{{ route('leave-reason.edit', ['segment' => $segment, 'leave_reason' => $leave_reason->id]) }}">
        <i class="bi bi-pencil"></i>
    </button>
    <button class="btn btn-sm btn-outline-danger btnDeleteLeaveReason"
        data-url="{{ route('leave-reason.destroy', ['segment' => $segment, 'leave_reason' => $leave_reason->id]) }}">
        <i class="bi bi-trash"></i>
    </button>
</div>
