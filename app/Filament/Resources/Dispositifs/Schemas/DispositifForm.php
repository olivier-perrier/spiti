<?php

namespace App\Filament\Resources\Dispositifs\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DispositifForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    TextInput::make('name')->label('Nom du dispositif')
                        ->required(),
                    Select::make('type_id')->label('Type')->required()
                        ->relationship('type', 'label'),
                    TextInput::make('finess_number')->label('N° finess')
                        ->numeric()->required(),
                    TextEntry::make('lots_sum_capacity')->sum('lots', 'capacity')->label('Capacité'),
                    Group::make([
                        DatePicker::make('opening_date')->label("Date d'ouverture")
                            ->required(),
                        DatePicker::make('closing_date')->label('Date de fermeture'),
                    ])->columns(2)->columnSpanFull(),
                ])->columns(2)->columnSpan(2),
                Section::make('Adresse')
                    ->relationship('address')
                    ->schema([
                        TextInput::make('country')->label('Pays'),
                        TextInput::make('street')->label('Rue'),
                        TextInput::make('postcode')->label('Code postal'),
                        TextInput::make('city')->label('Ville'),
                    ])
                    ->columns(2)
                    ->columnSpan(1),
            ])
            ->columns(3);
    }
}
