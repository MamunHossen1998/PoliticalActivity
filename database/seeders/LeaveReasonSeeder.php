<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeaveReason;

class LeaveReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'Family emergency', 'is_active' => 1],
            ['name' => 'Health issues', 'is_active' => 1],
            ['name' => 'Medical appointment', 'is_active' => 1]
        ];

        foreach ($statuses as $b) {
            LeaveReason::updateOrCreate(
                ['name' => $b['name']],
                ['is_active' => $b['is_active']]
            );
        }
    }
}

