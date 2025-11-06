<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    public function run()
    {
        // First user with all permissions
        $users = [
            [
                'name'     => 'Abdul Alim',
                'email'    => 'aa@ihelpbd.com',
                'password' => Hash::make('12345678'),
            ],
        ];

        foreach ($users as $userData) {
            $user = User::create($userData);
            $user->assignRole(1); // assuming role ID 1 exists
            $user->syncPermissions(Permission::all());
        }

        // Second user without permissions
        $usersSu = [
            [
                'name'     => 'Mehedi Hasan Shamim',
                'email'    => 'mehedi@ihelpbd.com',
                'password' => Hash::make('12345678@'),
            ],
        ];

        foreach ($usersSu as $userSuData) {
            $userSu = User::create($userSuData);
            $userSu->assignRole(1); // same role or change if needed
            $user->syncPermissions(Permission::all());
        }
    }
}
