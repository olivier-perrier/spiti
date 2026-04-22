<?php

namespace App\Filament\Resources\Dispositifs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DispositifsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nom')->sortable()->searchable(),
                TextColumn::make('address.street')->label('Adresse')->sortable()->searchable()->toggleable(),
                TextColumn::make('type.label')->sortable()->searchable()->toggleable(),
                TextColumn::make('finess_number')->label('N° finess')->sortable()->searchable()->toggleable(),
                TextColumn::make('opening_date')->label("Date d'ouverture")->sortable()->searchable()->toggleable(),
                TextColumn::make('lots_sum_capacity')->sum('lots', 'capacity')->label('Places')->sortable()->toggleable(),
                TextColumn::make('lots_count')->counts('lots')->label('Nombre de lot')->sortable()->toggleable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->relationship('type', 'label'),
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
