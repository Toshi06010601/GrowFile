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
        'user_id' => 3,
        'slug' => 'minniemouse.com',
        'full_name' => 'Minnie Mouse',
        'profile_image_path' => 'storage/profile_photos/default.png',
        'background_image_path' => 'storage/background_photos/default.png',
        'headline' => 'Software Engineer',
        'bio' => fake()->text(200),
        'job_status' => 'exploring',
        'visibility' => true,
        'location' => 'London, UK',
        'github_link' => 'test_user.com',
        'linkedin_link' => 'test_user.com',
        ]);
    }
}
