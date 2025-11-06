<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\Branch;
use App\Models\Specialization;
use Illuminate\Support\Str;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $branches = Branch::query()->pluck('id')->all();
        $specializations = Specialization::query()->pluck('id')->all();

        if (empty($branches) || empty($specializations)) {
            return; // ensure foreign keys exist
        }

        $firstNames = ['Mehedi','Sadia','Ayesha','Nafis','Rafi','Tasnuba','Sakib','Arif','Nabila','Yasin','Hridoy','Mim','Tania','Fahim','Nusrat'];
        $lastNames  = ['Ahmed','Hassan','Rahman','Khan','Islam','Rashid','Chowdhury','Akter','Miah','Karmakar'];

        for ($i = 1; $i <= 50; $i++) {
            $name = $firstNames[array_rand($firstNames)].' '.$lastNames[array_rand($lastNames)];
            $email = Str::slug($name, '.')."$i@example.com";
            $phone = '01'.mt_rand(3,9).mt_rand(10000000,99999999);

            // Simple hours: Mon–Fri 10:00-18:00, Sat/Sun closed
            $openingHours = [
                'monday'    => ['10:00-18:00'],
                'tuesday'   => ['10:00-18:00'],
                'wednesday' => ['10:00-18:00'],
                'thursday'  => ['10:00-18:00'],
                'friday'    => ['10:00-18:00'],
                'saturday'  => [],
                'sunday'    => [],
            ];

            Doctor::create([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'branch_id' => $branches[array_rand($branches)],
                'specialization_id' => $specializations[array_rand($specializations)],
                'degree' => 'MBBS, FCPS',
                'designation' => 'Consultant',
                'gender' => ['male','female'][array_rand(['male','female'])],
                'location' => 'Dhaka, Bangladesh',
                'chamber_address' => 'Main Chamber, Dhaka',
                'first_visit_fee' => rand(500, 1500),
                'experience_years' => rand(1, 25),
                'registration_no' => 'REG-'.str_pad((string)rand(1,999999), 6, '0', STR_PAD_LEFT),
                'description' => null,
                'is_active' => 1,
                'opening_hours' => $openingHours,
            ]);
        }
    }
}

