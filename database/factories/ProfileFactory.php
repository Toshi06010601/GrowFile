<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'full_name' => $name = fake()->name(),
            'slug' => \Illuminate\Support\Str::slug($name) . '-' . fake()->unique()->randomNumber(4),
            'profile_image_path' => 'profile_photos/default.svg',
            'background_image_path' => 'background_photos/default.jpg',
            'headline' => 'Backend Engineer',
            'bio' => fake()->text(200),
            'job_status' => 'exploring',
            'visibility' => true,
            'location' => 'Tokyo, Japan',
            'github_link' => 'test_user.com',
            'linkedin_link' => 'test_user.com',
        ];
    }
}
