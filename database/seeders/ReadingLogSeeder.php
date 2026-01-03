<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ReadingLog;

class ReadingLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ReadingLog::create([
        'user_id' => 30,
        'title' => 'test book',
        'cover_url' => 'http://books.google.com/books/content?id=Bdh_RQAACAAJ&printsec=frontcover&img=1&zoom=5&source=gbs_api',
        'current_page' => 100,
        'total_pages' => 300,
        'author' => 'souseki natsume',
        'review' => 'No review'
        ]);
    }
}
