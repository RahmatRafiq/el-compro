<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Hapus data lama jika ada
        Category::truncate();
        
        // Enable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $categories = [
            ['name' => 'Teknologi Informasi', 'type' => 'Technology'],
            ['name' => 'Pemrograman', 'type' => 'Technology'],
            ['name' => 'Database', 'type' => 'Technology'],
            ['name' => 'Jaringan Komputer', 'type' => 'Technology'],
            ['name' => 'Sistem Informasi', 'type' => 'Technology'],
            ['name' => 'Web Development', 'type' => 'Technology'],
            ['name' => 'Mobile Development', 'type' => 'Technology'],
            ['name' => 'Data Science', 'type' => 'Technology'],
            ['name' => 'Artificial Intelligence', 'type' => 'Technology'],
            ['name' => 'Berita Kampus', 'type' => 'News'],
            ['name' => 'Pengumuman', 'type' => 'News'],
            ['name' => 'Event', 'type' => 'News'],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'type' => $category['type'],
            ]);
        }
    }
}
