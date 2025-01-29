<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LecturerCourseSeeder extends Seeder
{
    public function run()
    {
        DB::table('lecturer_course')->insert([
            ['lecturer_id' => 1, 'course_id' => 1],
            ['lecturer_id' => 2, 'course_id' => 2],
            ['lecturer_id' => 3, 'course_id' => 3],
            ['lecturer_id' => 1, 'course_id' => 2], // Dr. John Doe juga mengajar Chemistry
        ]);
    }
}
