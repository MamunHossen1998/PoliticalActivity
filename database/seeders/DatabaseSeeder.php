<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleModelSeeder::class,
            BranchSeeder::class,
            AppointmentStatusSeeder::class,
            LeaveReasonSeeder::class,
            SpecializationSeeder::class,
            DoctorSeeder::class,
            UserSeeder::class,
        ]);
    }
}
