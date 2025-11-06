<form class="ajax-submit" action="{{ $action }}" method="POST">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="mb-3">
        <label class="form-label small text-secondary">Name</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}"
            class="form-control form-control-sm bg-transparent  border-secondary">
        <div class="invalid-feedback d-block" data-error-for="name"></div>
    </div>

    <div class="mb-3">
        <label class="form-label small text-secondary">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}"
            class="form-control form-control-sm bg-transparent  border-secondary">
        <div class="invalid-feedback d-block" data-error-for="email"></div>
    </div>

    <div class="mb-3">
        <label class="form-label small text-secondary">Branch</label>
        @php($currentBranchId = old('branch_id', isset($user) && $user->exists ? $user->branch_id : null))
        <select name="branch_id" class="form-select form-select-sm bg-transparent border-secondary">
            <option value="">-- None --</option>
            @foreach ($branches ?? [] as $b)
                <option value="{{ $b->id }}" @if ((string)$currentBranchId === (string)$b->id) selected @endif>
                    {{ $b->name }}</option>
            @endforeach
        </select>
        <div class="invalid-feedback d-block" data-error-for="branch_id"></div>
    </div>

    <div class="mb-3">
        <label class="form-label small text-secondary">Password @if ($method === 'POST')
                <span class="text-danger">*</span>
            @endif
        </label>
        <input type="password" name="password" class="form-control form-control-sm bg-transparent  border-secondary"
            placeholder="{{ $method === 'POST' ? 'Required' : 'Leave blank to keep unchanged' }}">
        <div class="invalid-feedback d-block" data-error-for="password"></div>
    </div>

    <div class="mb-3">
        <label class="form-label small text-secondary">Role</label>
        <input type="hidden" name="role_present" value="1">
        @php($currentRoleId = isset($user) && $user->exists && $user->roles ? optional($user->roles->first())->id : null)
        <select name="role_id" class="form-select form-select-sm bg-transparent border-secondary">
            <option value="">-- None --</option>
            @foreach ($roles ?? [] as $r)
                <option value="{{ $r->id }}" @if ($currentRoleId === $r->id) selected @endif>
                    {{ $r->name }}</option>
            @endforeach
        </select>
        <div class="invalid-feedback d-block" data-error-for="role_id"></div>
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
