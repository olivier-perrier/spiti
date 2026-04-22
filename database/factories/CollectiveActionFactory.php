<?php

namespace Database\Factories;

use App\Models\CollectiveAction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CollectiveAction>
 */
class CollectiveActionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),

            'objectif' => fake()->words(3, true),
            // "theme",
            // "subtheme",
            'target' => fake()->words(3, true),
            'description' => fake()->text(100),

            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
            'duration' => fake()->numberBetween(1, 30),
            'mobilisation' => fake()->boolean(),
            'location' => fake()->city(),

            'participation' => fake()->numberBetween(1, 100),
            'summary' => fake()->text(100),
            'status' => fake()->boolean(),
        ];
    }
}
