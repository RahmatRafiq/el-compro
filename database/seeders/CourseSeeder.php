<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    public function run()
    {
        DB::table('courses')->insert([
            ['course_code' => 'PHY101', 'name' => 'Physics I', 'credits' => 3],
            ['course_code' => 'CHEM102', 'name' => 'Organic Chemistry', 'credits' => 4],
            ['course_code' => 'ENGR103', 'name' => 'Introduction to Engineering', 'credits' => 3],
        ]);
    }
}
