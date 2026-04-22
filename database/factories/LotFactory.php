<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Lot;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lot>
 */
class LotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => fake()->randomNumber(5),
            'building' => fake()->buildingNumber(),
            'floor' => fake()->numberBetween(1, 10),
            'surface' => fake()->numberBetween(10, 150),
            'capacity' => fake()->numberBetween(1, 10),
            'agreed_capacity' => fake()->numberBetween(1, 10),
            'PMR' => fake()->boolean(),
            'address_id' => Address::factory(),
            'type_id' => Type::where('typeable_type', Lot::class)->get()->random(),
        ];
    }
}
