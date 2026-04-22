<?php

namespace Database\Factories;

use App\Models\Beneficiary;
use App\Models\Lot;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Beneficiary>
 */
class BeneficiaryFactory extends Factory
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
            'birth_name' => fake()->lastName(),
            'AGDREF' => fake()->randomNumber(8),
            'birthday' => fake()->date(),
            'sex' => fake()->randomElement(['man', 'woman', null]),
            'nationality' => fake()->randomElement(['Française', 'Affricaine', 'Américaine', 'Union Européenne', 'Hors UE', 'Amérique latine', 'Asiatique',  'Autralienne']),
            'birth_country' => fake()->country(),
            'birth_city' => fake()->city(),
            'date_entry_dispositif' => fake()->date(),
            'family_situation_id' => Type::where('typeable_type', Beneficiary::class.'.family')->get()->random(),
            'administrative_situation_id' => Type::where('typeable_type', Beneficiary::class.'.administratif')->get()->random(),
            'date_arrival_france' => fake()->date(),
            // 'referent_id'=> fake()->name(),
            'lot_id' => Lot::factory(),

            'phone' => fake()->phoneNumber(),
            'mobile_phone' => fake()->phoneNumber(),
            'email' => fake()->email(),
        ];
    }
}
