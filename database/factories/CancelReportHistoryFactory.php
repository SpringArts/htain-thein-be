<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CancelReportHistory>
 */
class CancelReportHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => $this->faker->numberBetween(1000, 5000),
            'description' => $this->faker->text(),
            'type' => $this->faker->randomElement(['INCOME', 'EXPENSE']),
            'reporter_id' => $this->faker->numberBetween(1, 30),
            'rejecter_id' => $this->faker->numberBetween(1, 30),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
