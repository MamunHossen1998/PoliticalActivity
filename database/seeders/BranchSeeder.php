<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            ['name' => 'Main Branch', 'is_active' => 1],
            ['name' => 'Uttara Branch', 'is_active' => 1],
            ['name' => 'Dhanmondi Branch', 'is_active' => 1],
            ['name' => 'Gulshan Branch', 'is_active' => 1],
            ['name' => 'Banani Branch', 'is_active' => 1],
        ];

        foreach ($branches as $b) {
            Branch::updateOrCreate(
                ['name' => $b['name']],
                ['is_active' => $b['is_active']]
            );
        }
    }
}

