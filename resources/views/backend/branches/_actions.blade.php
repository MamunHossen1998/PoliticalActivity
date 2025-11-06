<div class="text-end">
    <button class="btn btn-sm btn-outline-info me-1 btnEditBranch"
        data-url="{{ route('branches.edit', ['segment' => $segment, 'branch' => $branch->id]) }}">
        <i class="bi bi-pencil"></i>
    </button>
    <button class="btn btn-sm btn-outline-danger btnDeleteBranch"
        data-url="{{ route('branches.destroy', ['segment' => $segment, 'branch' => $branch->id]) }}">
        <i class="bi bi-trash"></i>
    </button>
</div>
