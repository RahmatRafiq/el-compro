<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VirtualSeeder extends Seeder
{
    public function run()
    {
        DB::table('virtuals')->insert([
            [
                'category_id' => 1,
                'name' => 'Physics Simulation',
                'url_embed' => 'https://example.com/physics_simulation',
                'description' => 'An interactive physics simulation.',
            ],
            [
                'category_id' => 2,
                'name' => 'Chemistry Lab Demo',
                'url_embed' => 'https://example.com/chemistry_lab',
                'description' => 'A virtual chemistry lab experience.',
            ],
        ]);
    }
}
