<?php

namespace App\Filament\Resources\Partners\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ConventionsRelationManager extends RelationManager
{
    protected static string $relationship = 'conventions';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Intitulé')
                    ->required()
                    ->maxLength(255),
                TextInput::make('dispositif.name')->label('Dispositif'),
                DatePicker::make('start_date')->label('Date de début'),
                DatePicker::make('end_date')->label('Date de fin'),
                TextInput::make('status')->label('Statut'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')->label('Intitulé'),
                TextColumn::make('start_date')->label('Date de début'),
                TextColumn::make('end_date')->label('Date de fin'),
                TextColumn::make('dispositif.name')->label('Dispositif'),
                TextColumn::make('status')->label('Statut'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
