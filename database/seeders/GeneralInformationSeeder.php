<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeneralInformationSeeder extends Seeder
{
    public function run()
    {
        DB::table('general_information')->insert([
            ['type' => 'concentration', 'name' => 'AI & Machine Learning', 'description' => 'Focuses on AI and deep learning.'],
            ['type' => 'career_prospects', 'name' => 'Software Engineer', 'description' => 'Opportunities in software development.'],
            ['type' => 'advantages', 'name' => 'Industry Collaboration', 'description' => 'Partnerships with leading tech companies.'],
        ]);
    }
}
