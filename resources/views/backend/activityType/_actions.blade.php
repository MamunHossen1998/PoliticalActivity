<div class="text-end">
    <button class="btn btn-sm btn-outline-info me-1 btnEditUser"
        data-url="{{ route('activityType.edit', ['segment' => $segment, 'activityType' => $activityType->uuid]) }}">
        <i class="bi bi-pencil"></i>
    </button>
    <button class="btn btn-sm btn-outline-danger btnDeleteUser"
        data-url="{{ route('activityType.destroy', ['segment' => $segment, 'activityType' => $activityType->uuid]) }}">
        <i class="bi bi-trash"></i>
    </button>
</div>
