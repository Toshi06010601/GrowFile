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
        'profile_image' => 'images/profiles/profile_img_1.jpg',
        'headline' => 'RPA developer',
        'bio' => fake()->text(200),
        'job_status' => 'open',
        'visibility' => true,
        'location' => 'London, UK',
        'github_link' => 'test_user.com',
        'linkedin_link' => 'test_user.com',
        ]);
    }
}
