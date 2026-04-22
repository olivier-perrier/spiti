<?php

namespace App\Filament\Pages\Tenancy;

use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Tenancy\EditTenantProfile;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EditTeamProfile extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return 'Association '.Filament::getTenant()->name;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)->schema([
                    Section::make()->schema([
                        TextInput::make('name')->label('Nom')->required()->live(),
                        TextInput::make('phone')->label('Téléphone')->tel(),
                    ])->columnSpan(2),
                    Section::make('Adresse')
                        ->relationship('address')
                        ->schema([
                            TextInput::make('street')->label('Rue'),
                            TextInput::make('postcode')->label('Code postal'),
                            TextInput::make('city')->label('Ville'),
                            TextInput::make('country')->label('Pays'),
                        ])->columns(2)->columnSpan(1),
                ]),
                // ...
            ]);
    }
}
