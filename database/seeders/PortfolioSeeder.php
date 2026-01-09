<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Portfolio;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Portfolio::create([
        'user_id' => 30,
        'title' => 'test portfolio',
        'site_image_path' => 'http://books.google.com/books/content?id=Bdh_RQAACAAJ&printsec=frontcover&img=1&zoom=5&source=gbs_api',
        'site_url' => 'http://localhost/professional_profile',
        'github_url' => 'https://github.com/Toshi06010601/GrowFile',
        'description' => 'test portfolio',
        'comment' => 'No comment'
        ]);
    }
}
