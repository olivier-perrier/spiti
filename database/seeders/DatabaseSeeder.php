<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Beneficiary;
use App\Models\CollectiveAction;
use App\Models\Convention;
use App\Models\Dispositif;
use App\Models\Lot;
use App\Models\Menage;
use App\Models\Partner;
use App\Models\Residence;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TypeSeeder::class,
        ]);

        $team = Team::factory()->create();

        $roleUser = Role::factory()->create(['name' => 'Utilisateur', 'code' => 'user']);
        $roleCommercial = Role::factory()->create(['name' => 'Commercial', 'code' => 'commercial']);
        $roleDirector = Role::factory()->create(['name' => 'Directeur', 'code' => 'director']);

        User::factory(10)
            ->hasAttached($team)
            ->create();

        User::factory()
            ->hasAttached($team)
            ->create([
                'name' => 'Admin Jhon',
                'email' => 'admin.john@spiti.fr',
                'is_admin' => true,
            ]);

        User::factory()
            ->hasAttached($team)
            ->hasAttached($roleUser, pivot: ['team_id' => $team->id])
            ->create([
                'name' => 'User Mack',
                'email' => 'user.mack@spiti.fr',
            ]);

        User::factory()
            ->hasAttached($team)
            ->hasAttached($roleCommercial, pivot: ['team_id' => $team->id])
            ->create([
                'name' => 'Commercial Mary',
                'email' => 'commercial.mary@spiti.fr',
            ]);

        User::factory()
            ->hasAttached($team)
            ->hasAttached($roleDirector, pivot: ['team_id' => $team->id])
            ->create([
                'name' => 'Director Katy',
                'email' => 'director.katy@spiti.fr',
            ]);

        Dispositif::factory(5)
            ->for($team)
            ->has(
                Residence::factory(5)
                    ->for($team)
                    ->has(
                        Lot::factory(5)
                            ->for($team)
                            ->has(Beneficiary::factory(3)->for($team))
                    )
            )
            ->has(
                Convention::factory(10)
                    ->for($team)
                    ->for(Partner::factory()->for($team))
            )
            ->has(
                CollectiveAction::factory(10)
                    ->for($team)
                    ->has(Partner::factory(10)->for($team))
            )
            ->create();

        Menage::factory(10)
            ->for($team)
            ->create();

        // Convention::factory(10)
        //     ->for($team)
        //     ->create();

        // Partner::factory(10)
        //     ->for($team)
        //     ->create();
    }
}
