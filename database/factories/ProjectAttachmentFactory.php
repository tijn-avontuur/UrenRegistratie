<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectAttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'filename' => fake()->word(),
            'filepath' => fake()->word(),
            'uploaded_at' => fake()->dateTime(),
        ];
    }
}
