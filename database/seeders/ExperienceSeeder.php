<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Experience;

class ExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Experience::create([
            'user_id' => 1,
            'company_name' => 'Cambridge University Hospitals',
            'start_month' => '02/01/2022',
            'end_month' => '12/01/2024',
            'role' => 'RPA developer',
            'description' => 'Aspiring RPA Developer with 5.5 years of demonstrable expertise. Currently overseeing the team’s projects as a project manager while implementing end-to-end automation as an RPA developer.
                                In addition to RPA, I have been expanding my skillset by taking a web development course. My goal is to strengthen my ability to build websites and web applications to drive further automation. Currently, I work with HTML, CSS, JavaScript, React.js on the client side, while utilizing PHP, Node.js, and PostgreSQL on the server side.'
        ]);
    }
}
