<?php

namespace App\Filament\Resources\Beneficiaries\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ResourcesRelationManager extends RelationManager
{
    protected static string $relationship = 'resources';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('periodicity')->label('Périodicité')
                    ->options([
                        'ponctuelle' => 'Ponctuelle',
                        'mensuelle' => 'Mensuelle',
                        'trimestrielle' => 'Trimestrielle',
                        'semestrielle' => 'Semestrielle',
                        'annuelle' => 'Annuelle',
                    ])
                    ->default('ponctuelle')
                    ->required(),
                TextInput::make('amount')->label('Montant')
                    ->numeric()
                    ->suffix('€')
                    ->required()
                    ->default(0)
                    ->maxLength(255),
                DatePicker::make('start_date')->label('Date (de début)')
                    ->default(now())
                    ->required(),
                DatePicker::make('end_date')->label('Date de fin'),
                Select::make('type')->label('Type')
                    ->required()
                    ->options([
                        'salaire' => 'Salaire',
                        'allocation' => 'Allocation',
                        'pension' => 'Pension',
                        'rsa' => 'RSA',
                        'ass' => 'ASS',
                        'aah' => 'AAH',
                        'aspa' => 'ASPA',
                        'ada' => 'ADA',
                        'autre' => 'Autre',
                    ]),
                Textarea::make('comment')->label('Commentaire')
                    ->maxLength(2000),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('amount')
            ->columns([
                TextColumn::make('periodicity')->label('Périodicité')->sortable(),
                TextColumn::make('start_date')->label('Date de début')->sortable(),
                TextColumn::make('end_date')->label('Date de fin')->sortable(),
                TextColumn::make('type')->label('Type')->sortable(),
                TextColumn::make('amount')->label('Montant')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('comment')->label('Commentaire')->limit(20)->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}
