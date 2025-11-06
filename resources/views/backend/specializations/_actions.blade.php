<div class="text-end">
    <button class="btn btn-sm btn-outline-info me-1 btnEditSpecialization"
        data-url="{{ route('specializations.edit', ['segment' => $segment, 'specialization' => $specialization->id]) }}">
        <i class="bi bi-pencil"></i>
    </button>
    <button class="btn btn-sm btn-outline-danger btnDeleteSpecialization"
        data-url="{{ route('specializations.destroy', ['segment' => $segment, 'specialization' => $specialization->id]) }}">
        <i class="bi bi-trash"></i>
    </button>
</div>
