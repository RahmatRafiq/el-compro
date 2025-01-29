<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Physics', 'slug' => Str::slug('Physics'), 'type' => 'Science'],
            ['name' => 'Chemistry', 'slug' => Str::slug('Chemistry'), 'type' => 'Science'],
            ['name' => 'Engineering', 'slug' => Str::slug('Engineering'), 'type' => 'Technology'],
        ]);
    }
}
