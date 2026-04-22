<?php

namespace App\Filament\Resources\Beneficiaries\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProceduresRelationManager extends RelationManager
{
    protected static string $relationship = 'procedures';

    protected static ?string $title = 'Démarches / Ouvertures de droits';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->options([
                        'rsa' => 'RSA',
                        'housing_allocation' => 'Allocation logement',
                        'no_resource' => 'Sans resource',
                        'CEJ' => 'CEJ',
                        'ASS' => 'ASS',
                        'AAH' => 'AAH',
                    ])
                    ->required(),
                DatePicker::make('start_date')->label('Date de la demande')
                    ->default(now()),
                DatePicker::make('notification_date')->label('Date de notification d\'ouverture'),
                DatePicker::make('opening_date')->label('Date effective d\'ouverture'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('type')
            ->columns([
                TextColumn::make('type')->label('Type d\'allocation')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('start_date')->label('Date de la demande')
                    ->date()
                    ->sortable(),
                TextColumn::make('notification_date')->label('Date de notification d\'ouverture')
                    ->date()
                    ->sortable(),
                TextColumn::make('opening_date')->label('Date effective d\'ouverture')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->modalHeading('Ajouter une démarche / ouverture de droit'),
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
