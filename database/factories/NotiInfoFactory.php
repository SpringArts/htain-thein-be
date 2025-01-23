<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NotiInfo>
 */
class NotiInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->unique(true)->numberBetween(1, 5),
            'report_id' => $this->faker->unique(true)->numberBetween(1, 30),
            'announcement_id' => $this->faker->unique(true)->numberBetween(1, 10),
            'firebase_notification_id' => $this->faker->unique(true)->numberBetween(1, 10),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'last_viewed_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
