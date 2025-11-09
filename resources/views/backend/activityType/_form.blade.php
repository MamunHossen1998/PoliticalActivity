<form class="ajax-submit" action="{{ $action }}" method="POST">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="mb-3">
        <label class="form-label small text-secondary">Name</label>
        <input type="text" name="name" value="{{ old('name', $activityType->name) }}"
            class="form-control form-control-sm bg-transparent  border-secondary">
        <div class="invalid-feedback d-block" data-error-for="name"></div>
    </div>


    <div class="d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-outline-info" data-bs-dismiss="offcanvas">Cancel</button>
        <button type="submit" class="btn btn-accent">Save</button>
    </div>
</form>

<script>
    $(function() {
        bindAjaxForm($('.ajax-submit'), function() {
            closeOffcanvas();
            if (window.__usersDT) {
                window.__usersDT.ajax.reload(null, false);
            }
        });
    });
</script>
