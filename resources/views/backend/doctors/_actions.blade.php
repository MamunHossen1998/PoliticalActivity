<div class="text-end">
    <a class="btn btn-sm btn-outline-info me-1"
       href="{{ route('doctors.edit', ['segment' => $segment, 'doctor' => $doctor->id]) }}">
        <i class="bi bi-pencil"></i>
    </a>
    <button class="btn btn-sm btn-outline-danger btnDeleteDoctor"
            data-url="{{ route('doctors.destroy', ['segment' => $segment, 'doctor' => $doctor->id]) }}">
        <i class="bi bi-trash"></i>
    </button>
</div>
