<?php

namespace Database\Seeders;

use App\Models\PoliticalParty;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PoliticalPartySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $politicalParties = [
            ['name' => 'Bangladesh Nationalist Party', 'abbreviation' => 'BNP', 'founded_year' =>'1978-09-01'],
            ['name' => 'Bangladesh Awami League', 'abbreviation' => 'BAL', 'founded_year' =>'1949-06-23'],
            ['name' => 'Bangladesh Jamaat-e-Islami', 'abbreviation' => 'BJI', 'founded_year' => '1941-08-26'],
            ['name' => 'Islami Andolan Bangladesh', 'abbreviation' => 'IAB', 'founded_year' => '1987-03-13'],
            ['name' => 'National Citizen Party', 'abbreviation' => 'NCP', 'founded_year' => '2025-02-28'],
        ];
        foreach ($politicalParties as $party) {
            PoliticalParty::create($party);
        }
    }
}
