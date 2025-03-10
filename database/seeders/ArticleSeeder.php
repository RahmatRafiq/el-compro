<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 50; $i++) {
            Article::create([
                'category_id' => 10,
                'title' => "Sample Article $i",
                'content' => "This is the content of sample article $i.",
                'slug' => Str::slug("Sample Article $i"),
                'view_count' => rand(10, 1000),
                'tags' => json_encode(['tag1', 'tag2', 'tag3']),
            ]);
        }
    }
}
