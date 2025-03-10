<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LecturerSeeder extends Seeder
{
    public function run()
    {
        DB::table('lecturers')->insert([
            ['name' => 'Dr. John Doe', 'image' => 'john_doe.jpg', 'about' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'],
            ['name' => 'Prof. Jane Smith', 'image' => 'jane_smith.jpg', 'about' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'],
            ['name' => 'Dr. Alan Turing', 'image' => 'alan_turing.jpg', 'about' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'],
        ]);
        for ($i = 1; $i <= 200; $i++) {
            DB::table('lecturers')->insert([
                'name' => 'Lecturer ' . $i,
                'image' => 'lecturer_' . $i . '.jpg',
                'about' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ]);
        }
    }
}
