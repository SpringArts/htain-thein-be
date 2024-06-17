<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => $this->faker->numberBetween(500, 2500) * 2,
            'description' => $this->faker->text(),
            'type' => $this->faker->randomElement(['INCOME', 'EXPENSE']),
            'confirm_status' => $this->faker->numberBetween(0, 1),
            'reporter_id' => $this->faker->unique(true)->numberBetween(1, 3),
            'verifier_id' => $this->faker->numberBetween(1, 3),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
