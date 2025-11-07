<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request, string $segment)
    {
        return view('backend.users.index', compact('segment'));
    }

    public function data(Request $request, string $segment)
    {
        $query = User::query();
        $recordsTotal = (clone $query)->count();
        $recordsFiltered = (clone $query)->count();
        $users = $query->with(['roles:id,name', 'branch:id,name'])->get(['id', 'name', 'email', 'branch_id']);
        $data = $users->map(function ($u) use ($segment) {
            return [
                'id' => $u->id,
                'name' => e($u->name),
                'email' => e($u->email),
                'branch' => e(optional($u->branch)->name ?? '-'),
                'roles' => e($u->roles->pluck('name')->join(', ')),
                'actions' => view('backend.users._actions', [
                    'segment' => $segment,
                    'user' => $u,
                ])->render(),
            ];
        });

        return response()->json([
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }

    public function create(Request $request, string $segment)
    {
        $user = new User();
        $action = route('users.store', ['segment' => $segment]);
        $method = 'POST';
        $roles = Role::query()->where('is_active', 1)->orderBy('name')->get(['id', 'name']);
        $branches = Branch::query()->where('is_active', 1)->orderBy('name')->get(['id', 'name']);
        return view('backend.users._form', compact('user', 'action', 'method', 'roles', 'branches'));
    }

    public function store(Request $request, string $segment)
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'string', 'min:6'],
                'branch_id' => ['nullable', 'integer', Rule::exists('branches', 'id')],
                'role_id' => ['nullable', 'integer', Rule::exists('roles', 'id')],
            ]);

            $user = User::create($validated);

            if (!empty($validated['role_id'])) {
                $role = Role::find($validated['role_id']);
                if ($role) {
                    $user->syncRoles([$role]);
                }
            }

            return response()->json([
                'type' => 'success',
                'message' => 'User created successfully.',
            ]);
        } catch (\Throwable $th) {
            return _commonSuccessOrErrorMsg('error', $th->getMessage());
        }
    }

    public function edit(Request $request, string $segment, User $user)
    {
        $action = route('users.update', ['segment' => $segment, 'user' => $user->id]);
        $method = 'PUT';
        $roles = Role::query()->where('is_active', 1)->orderBy('name')->get(['id', 'name']);
        $branches = Branch::query()->where('is_active', 1)->orderBy('name')->get(['id', 'name']);
        $user->load('roles:id,name');
        return view('backend.users._form', compact('user', 'action', 'method', 'roles', 'branches'));
    }

    public function update(Request $request, string $segment, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6'],
            'branch_id' => ['nullable', 'integer', Rule::exists('branches', 'id')],
            'role_id' => ['nullable', 'integer', Rule::exists('roles', 'id')],
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        if ($request->has('role_id')) {
            $role = !empty($validated['role_id']) ? Role::find($validated['role_id']) : null;
            $user->syncRoles($role ? [$role] : []);
        } elseif ($request->boolean('role_present')) {
            // Explicitly clear roles when no selection was made
            $user->syncRoles([]);
        }

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully.',
        ]);
    }

    public function destroy(Request $request, string $segment, User $user)
    {
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully.',
        ]);
    }
}
