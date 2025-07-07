<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        // Ambil ID kategori yang ada
        $categoryIds = Category::pluck('id')->toArray();
        
        if (empty($categoryIds)) {
            // Jika tidak ada kategori, buat kategori default
            $category = Category::create([
                'name' => 'General',
                'slug' => 'general',
                'type' => 'General'
            ]);
            $categoryIds = [$category->id];
        }

        for ($i = 1; $i <= 50; $i++) {
            Article::create([
                'category_id' => $categoryIds[array_rand($categoryIds)], // Pilih random dari kategori yang ada
                'title' => "Sample Article $i",
                'content' => "This is the content of sample article $i.",
                'slug' => Str::slug("Sample Article $i"),
                'view_count' => rand(10, 1000),
                'tags' => json_encode(['tag1', 'tag2', 'tag3']),
            ]);
        }
    }
}
