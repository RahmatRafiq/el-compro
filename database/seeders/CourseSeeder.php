<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $concentrations = [
            'mata_kuliah_dasar',
            'teknik_tenaga_listrik',
            'teknik_telekomunikasi',
            'semua_konsentrasi',
        ];

        // Seeder statis
        DB::table('courses')->insert([
            [
                'course_code' => 'PHY101',
                'name' => 'Physics I',
                'credits' => 3,
                'semester' => 1,
                'major_concentration' => 'mata_kuliah_dasar',
            ],
            [
                'course_code' => 'CHEM102',
                'name' => 'Organic Chemistry',
                'credits' => 4,
                'semester' => 2,
                'major_concentration' => 'mata_kuliah_dasar',
            ],
            [
                'course_code' => 'ENGR103',
                'name' => 'Introduction to Engineering',
                'credits' => 3,
                'semester' => 1,
                'major_concentration' => 'mata_kuliah_dasar',
            ],
        ]);

        // Seeder dinamis dengan faker
        for ($i = 0; $i < 200; $i++) {
            DB::table('courses')->insert([
                'course_code' => strtoupper($faker->unique()->bothify('CSE###')),
                'name' => ucfirst($faker->words(rand(2, 4), true)),
                'semester' => rand(1, 8),
                'credits' => rand(1, 5),
                'major_concentration' => $concentrations[array_rand($concentrations)],
            ]);
        }
    }
}
