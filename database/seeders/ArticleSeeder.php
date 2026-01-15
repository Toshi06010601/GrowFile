<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Article::create([
            'user_id' => 30,
            'title' => 'test article',
            'description' => 'test article',
            'platform_name' => 'Zenn',
            'published_date' => 15/01/2026,
            'article_url' => 'http://localhost/professional_profile',
            'article_image_path' => 'screenshot.png',
        ]);
    }
}
