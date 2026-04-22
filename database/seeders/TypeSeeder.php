<?php

namespace Database\Seeders;

use App\Models\Beneficiary;
use App\Models\Convention;
use App\Models\Dispositif;
use App\Models\Lot;
use App\Models\Residence;
use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Type::factory()->create(['label' => 'ASI', 'typeable_type' => Dispositif::class]);
        Type::factory()->create(['label' => 'SOC', 'typeable_type' => Dispositif::class]);
        Type::factory()->create(['label' => 'HIN', 'typeable_type' => Dispositif::class]);
        Type::factory()->create(['label' => 'HLO', 'typeable_type' => Dispositif::class]);
        Type::factory()->create(['label' => 'CADA', 'typeable_type' => Dispositif::class]);
        Type::factory()->create(['label' => 'HUDA', 'typeable_type' => Dispositif::class]);
        Type::factory()->create(['label' => 'PRAHDA', 'typeable_type' => Dispositif::class]);

        Type::factory()->create(['label' => 'HML', 'typeable_type' => Residence::class]);
        Type::factory()->create(['label' => 'Maison', 'typeable_type' => Residence::class]);
        Type::factory()->create(['label' => 'Immeuble', 'typeable_type' => Residence::class]);

        Type::factory()->create(['label' => 'Chambre', 'typeable_type' => Lot::class]);
        Type::factory()->create(['label' => 'T1', 'typeable_type' => Lot::class]);
        Type::factory()->create(['label' => 'T2', 'typeable_type' => Lot::class]);
        Type::factory()->create(['label' => 'T3', 'typeable_type' => Lot::class]);
        Type::factory()->create(['label' => 'T4', 'typeable_type' => Lot::class]);
        Type::factory()->create(['label' => 'F1', 'typeable_type' => Lot::class]);

        Type::factory()->create(['label' => 'Mari(é)é', 'typeable_type' => Beneficiary::class.'.family']);
        Type::factory()->create(['label' => 'Divorc(é)e', 'typeable_type' => Beneficiary::class.'.family']);
        Type::factory()->create(['label' => 'Enfants', 'typeable_type' => Beneficiary::class.'.family']);
        Type::factory()->create(['label' => 'Adulte avec enfant(s)', 'typeable_type' => Beneficiary::class.'.family']);
        Type::factory()->create(['label' => 'Adulte sans enfant', 'typeable_type' => Beneficiary::class.'.family']);
        Type::factory()->create(['label' => 'Couple avec enfant(s)', 'typeable_type' => Beneficiary::class.'.family']);
        Type::factory()->create(['label' => 'Couple sans enfant', 'typeable_type' => Beneficiary::class.'.family']);

        Type::factory()->create(['label' => 'Avec document séjour', 'typeable_type' => Beneficiary::class.'.administratif']);
        Type::factory()->create(['label' => 'Protection subsidiaire', 'typeable_type' => Beneficiary::class.'.administratif']);
        Type::factory()->create(['label' => 'Demande de titre en cours', 'typeable_type' => Beneficiary::class.'.administratif']);
        Type::factory()->create(['label' => "Demandeur d'asile", 'typeable_type' => Beneficiary::class.'.administratif']);
        Type::factory()->create(['label' => 'Réfugié', 'typeable_type' => Beneficiary::class.'.administratif']);

        Type::factory()->create(['label' => 'Ebauche', 'typeable_type' => Convention::class.'.type']);
        Type::factory()->create(['label' => 'Mise en oeuvre', 'typeable_type' => Convention::class.'.type']);
    }
}
