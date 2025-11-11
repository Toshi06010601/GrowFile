<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Profile;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Profile::create([
        'user_id' => 1,
        'slug' => 'test_user.com',
        'full_name' => 'Test User',
        'profile_image_path' => 'storage/profile_photos/default.jpg',
        'background_image_path' => 'storage/background_photos/default.png',
        'headline' => 'RPA developer',
        'bio' => fake()->text(200),
        'job_status' => 'open_to_work',
        'visibility' => true,
        'location' => 'London, UK',
        'github_link' => 'test_user.com',
        'linkedin_link' => 'test_user.com',
        ]);
    }
}
