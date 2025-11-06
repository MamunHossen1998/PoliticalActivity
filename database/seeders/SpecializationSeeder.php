<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Specialization;

class SpecializationSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'Cardiology', 'is_active' => 1],
            ['name' => 'Neurology', 'is_active' => 1],
            ['name' => 'Orthopedics', 'is_active' => 1],
            ['name' => 'Dermatology', 'is_active' => 1],
            ['name' => 'Pediatrics', 'is_active' => 1],
        ];

        foreach ($items as $i) {
            Specialization::updateOrCreate(
                ['name' => $i['name']],
                ['is_active' => $i['is_active']]
            );
        }
    }
}

