<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Dispositif;
use App\Models\Residence;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Residence>
 */
class ResidenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word,
            'dispositif_id' => Dispositif::factory(),
            'elevator' => fake()->boolean(),
            'parking' => fake()->boolean(),
            'heating' => fake()->sentence(),
            'public_transport' => fake()->sentence(),
            'address_id' => Address::factory(),
            'type_id' => Type::where('typeable_type', Residence::class)->get()->random(),
        ];
    }
}
