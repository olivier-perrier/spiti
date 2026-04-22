<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Team;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;

class RegisterTeam extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Créer votre nouvelle association';
    }

    public function getRegisterFormAction(): Action
    {
        return parent::getRegisterFormAction()
            ->label('Créer');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Nom de votre association')->required(),
                TextInput::make('phone')->label('Téléphone principal')->tel(),
                Fieldset::make('Adresse')
                    ->relationship('address')->label('Adresse (facultatif)')
                    ->schema([
                        TextInput::make('street')->label('Rue'),
                        TextInput::make('postcode')->label('Code postal'),
                        TextInput::make('city')->label('Ville'),
                        TextInput::make('country')->label('Pays'),
                    ])->columns(2)->columnSpan(1),
            ]);
    }

    protected function handleRegistration(array $data): Team
    {
        $team = Team::create($data);

        $team->members()->attach(auth()->user());

        return $team;
    }
}
