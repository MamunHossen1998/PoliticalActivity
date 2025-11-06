<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AppointmentStatus;

class AppointmentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'New', 'is_active' => 1],
            ['name' => 'Open', 'is_active' => 1],
            ['name' => 'Close', 'is_active' => 1]
        ];

        foreach ($statuses as $b) {
            AppointmentStatus::updateOrCreate(
                ['name' => $b['name']],
                ['is_active' => $b['is_active']]
            );
        }
    }
}

