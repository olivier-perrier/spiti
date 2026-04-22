<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Partner>
 */
class PartnerFactory extends Factory
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
            'type' => fake()->randomElement(['Droit Commun', 'Association', 'Autre droit']),
            'phone' => fake()->phoneNumber(),
            'website' => fake()->url(),
            'address_id' => Address::factory(),
        ];
    }
}
