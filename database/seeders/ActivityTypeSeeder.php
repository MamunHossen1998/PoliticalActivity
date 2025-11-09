<?php

namespace Database\Seeders;

use App\Models\ActivityType;
use Illuminate\Database\Seeder;

class ActivityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activityTypes = [
            ['name' => 'চাদাবাজি'],
            ['name' => 'মাদক'],
            ['name' => 'টেন্ডারবাজি'],
            ['name' => 'মামলা বানিজ্য'],
            ['name' => 'ধর্ষন'],
            ['name' => 'আন্ত:কোন্দল'],
            ['name' => 'কমিটি বানিজ্য'],
            ['name' => 'ঘুষ'],
            ['name' => 'খুন'],
            ['name' => 'হেনেস্তা'],
        ];
        foreach ($activityTypes as $activityType) {
            ActivityType::create($activityType);
        }
    }
}
