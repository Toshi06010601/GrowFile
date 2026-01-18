<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::create([
            'user_id' => 30,
            'name' => 'test course',
            'description' => 'description...',
            'provider' => 'Udemy',
            'course_url' => 'http://localhost/professional_profile',
            'progress_status' => 'completed',
            'certificate_url' => 'http://localhost/professional_profile',
            'completion_date' => '2026-01-11'
        ]);
    }
}
