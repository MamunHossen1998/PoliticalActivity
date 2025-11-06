<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles with route segments
        $roles = [
            ['name' => 'admin', 'guard_name' => 'web', 'route_segment' => 'admin', 'is_active' => 1],
            ['name' => 'doctor', 'guard_name' => 'web', 'route_segment' => 'doctor', 'is_active' => 1],
            ['name' => 'reception', 'guard_name' => 'web', 'route_segment' => 'reception', 'is_active' => 1],
        ];

        foreach ($roles as $data) {
            Role::query()->updateOrCreate(
                ['name' => $data['name'], 'guard_name' => $data['guard_name']],
                ['route_segment' => $data['route_segment'], 'is_active' => $data['is_active']]
            );
        }

        // Example permissions (optional)
        $permissions = [
            'appointments.view',
            'appointments.create',
            'appointments.update',
            'appointments.delete',
        ];

        foreach ($permissions as $perm) {
            Permission::query()->firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // Assign some permissions to roles (optional)
        Role::findByName('admin')->givePermissionTo($permissions);
        Role::findByName('doctor')->givePermissionTo(['appointments.view', 'appointments.update']);
        Role::findByName('reception')->givePermissionTo(['appointments.view', 'appointments.create']);

        // If there's a first user, ensure at least one role assigned (optional)
        if ($user = User::query()->first()) {
            if (! $user->hasAnyRole(['admin','doctor','reception'])) {
                $user->assignRole('admin');
            }
        }
    }
}
