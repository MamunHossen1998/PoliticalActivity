<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

/*
 * @author Mehedi Hasan Shamim <sh158399@gmail.com>
 */

class RoleModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Super Admin', 'route_segment' => 'SuperAdmin'],
            ['name' => 'Admin', 'route_segment' => 'Admin'],
            ['name' => 'Front Desk', 'route_segment' => 'FrontDesk'],
            ['name' => 'Doctor Assistant', 'route_segment' => 'DoctorAssistant'],
            ['name' => 'Call Center', 'route_segment' => 'CallCenter'],
        ];

        foreach ($data as $item) {
            Role::create([
                'name' => $item['name'],
                'route_segment' => strtolower(str_replace([' ', '-', '_'], '', $item['route_segment'])),
                'guard_name' => 'web',
                'is_active' => 1,
            ]);
        }
    }
}
