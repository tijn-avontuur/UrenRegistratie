<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-3 months', '+1 month');

        return [
            'title' => fake()->sentence(4),
            'description' => fake()->text(),
            'color' => fake()->hexColor(),
            'start_date' => $startDate,
            'end_date' => fake()->dateTimeBetween($startDate, '+6 months'),
        ];
    }
}
