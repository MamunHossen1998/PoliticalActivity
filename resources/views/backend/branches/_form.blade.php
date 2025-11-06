<form class="ajax-submit" action="{{ $action }}" method="POST">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="mb-3">
        <label class="form-label small text-secondary">Name</label>
        <input type="text" name="name" value="{{ old('name', $branch->name) }}"
            class="form-control form-control-sm bg-transparent  border-secondary">
        <div class="invalid-feedback d-block" data-error-for="name"></div>
    </div>

    <div class="mb-3 form-check">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
               @checked(old('is_active', $branch->is_active ?? 1))>
        <label class="form-check-label" for="is_active">Active</label>
        <div class="invalid-feedback d-block" data-error-for="is_active"></div>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-outline-info cancel-btn" data-bs-dismiss="offcanvas">Cancel</button>
        <button type="submit" class="btn btn-accent">Save</button>
    </div>
</form>

<script>
    $(function() {
        bindAjaxForm($('.ajax-submit'), function() {
            closeOffcanvas();
            if (window.__branchesDT) {
                window.__branchesDT.ajax.reload(null, false);
            }
        });
    });
</script>

