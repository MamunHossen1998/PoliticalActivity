<form class="ajax-submit" action="{{ $action }}" method="POST">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="mb-3">
        <label class="form-label small text-secondary">Name</label>
        <input type="text" name="name" value="{{ old('name', $politicalParty->name) }}"
            class="form-control form-control-sm bg-transparent  border-secondary">
        <div class="invalid-feedback d-block" data-error-for="name"></div>
    </div>

    <div class="mb-3">
        <label class="form-label small text-secondary">Abbreviation</label>
        <input type="text" name="abbreviation" value="{{ old('abbreviation', $politicalParty->abbreviation) }}"
            class="form-control form-control-sm bg-transparent  border-secondary">
        <div class="invalid-feedback d-block" data-error-for="abbreviation"></div>
    </div>

    <div class="mb-3">
        <label class="form-label small text-secondary">Founded year</label>
        <input type="date" name="founded_year" value="{{ old('founded_year', $politicalParty->founded_year) }}"
            class="form-control form-control-sm bg-transparent  border-secondary">
        <div class="invalid-feedback d-block" data-error-for="founded_year"></div>
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
