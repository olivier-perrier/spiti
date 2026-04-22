<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Dispositif;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Dispositif>
 */
class DispositifFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Dispositif '.fake()->word(),
            'finess_number' => fake()->randomNumber(5),
            'opening_date' => fake()->date(),
            'closing_date' => fake()->date(),
            'address_id' => Address::factory(),
            'type_id' => Type::where('typeable_type', Dispositif::class)->get()->random(),
        ];
    }
}
