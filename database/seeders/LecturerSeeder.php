<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LecturerSeeder extends Seeder
{
    public function run()
    {
        DB::table('lecturers')->insert([
            ['name' => 'Dr. John Doe', 'image' => 'john_doe.jpg'],
            ['name' => 'Prof. Jane Smith', 'image' => 'jane_smith.jpg'],
            ['name' => 'Dr. Alan Turing', 'image' => 'alan_turing.jpg'],
        ]);
        for ($i = 1; $i <= 200; $i++) {
            DB::table('lecturers')->insert([
                'name' => 'Lecturer ' . $i,
                'image' => 'lecturer_' . $i . '.jpg',
            ]);
        }
    }
}
