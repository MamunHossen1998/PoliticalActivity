<div class="text-end">
    <button class="btn btn-sm btn-outline-info me-1 btnEditAppointmentStatus"
        data-url="{{ route('appointment-status.edit', ['segment' => $segment, 'appointment_status' => $appointment_status->id]) }}">
        <i class="bi bi-pencil"></i>
    </button>
    <button class="btn btn-sm btn-outline-danger btnDeleteAppointmentStatus"
        data-url="{{ route('appointment-status.destroy', ['segment' => $segment, 'appointment_status' => $appointment_status->id]) }}">
        <i class="bi bi-trash"></i>
    </button>
</div>
