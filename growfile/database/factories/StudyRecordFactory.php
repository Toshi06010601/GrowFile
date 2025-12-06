<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudyRecord>
 */
class StudyRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // 1. Generate the start time and capture it in a variable
        $start = fake()->dateTimeBetween('-1 year', 'now');

        return [
            'user_id' => 30,
            'category' => 'Siid',
            'activity' => 'Step24',
            // 2. Use the captured variable for start_datetime
            'start_datetime' => $start, 

            // 3. Generate end_datetime that is guaranteed to be AFTER the start time
            // We use $start as the minimum boundary for the second date.
            'end_datetime' => fake()->dateTimeBetween($start, $start->format('Y-m-d H:i:s') . ' +1 hour'),
        ];
    }
}
