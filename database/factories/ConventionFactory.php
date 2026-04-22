<?php

namespace Database\Factories;

use App\Models\Convention;
use App\Models\Dispositif;
use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Convention>
 */
class ConventionFactory extends Factory
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
            'dispositif_id' => Dispositif::factory(),
            // "partner_id" => Partner::factory(),
            'signature_date' => fake()->date(),
            'end_date' => fake()->date(),
            'start_date' => fake()->date(),
            // "status_id",
            'funding' => fake()->boolean(),
            // "theme",
            // "subtheme",
            'goals' => fake()->word(),
        ];
    }
}
