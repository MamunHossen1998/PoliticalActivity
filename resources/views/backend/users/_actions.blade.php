<div class="text-end">
    <button class="btn btn-sm btn-outline-info me-1 btnEditUser"
        data-url="{{ route('users.edit', ['segment' => $segment, 'user' => $user->id]) }}">
        <i class="bi bi-pencil"></i>
    </button>
    <button class="btn btn-sm btn-outline-danger btnDeleteUser"
        data-url="{{ route('users.destroy', ['segment' => $segment, 'user' => $user->id]) }}">
        <i class="bi bi-trash"></i>
    </button>
</div>
