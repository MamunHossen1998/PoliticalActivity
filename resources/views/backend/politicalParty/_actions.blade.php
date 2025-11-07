<div class="text-end">
    <button class="btn btn-sm btn-outline-info me-1 btnEditUser"
        data-url="{{ route('politicalParty.edit', ['segment' => $segment, 'politicalParty' => $politicalParty->uuid]) }}">
        <i class="bi bi-pencil"></i>
    </button>
    <button class="btn btn-sm btn-outline-danger btnDeleteUser"
        data-url="{{ route('politicalParty.destroy', ['segment' => $segment, 'politicalParty' => $politicalParty->uuid]) }}">
        <i class="bi bi-trash"></i>
    </button>
</div>
