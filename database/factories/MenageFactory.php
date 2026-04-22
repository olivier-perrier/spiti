<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Menage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Menage>
 */
class MenageFactory extends Factory
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
            'address_id' => Address::factory(),
            'referent_id' => User::get()->random(),
        ];
    }
}
