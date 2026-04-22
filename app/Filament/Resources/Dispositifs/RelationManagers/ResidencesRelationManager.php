<?php

namespace App\Filament\Resources\Dispositifs\RelationManagers;

use App\Filament\Resources\Residences\ResidenceResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ResidencesRelationManager extends RelationManager
{
    protected static string $relationship = 'residences';

    protected static ?string $title = 'Résidences';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')->sortable(),
                TextColumn::make('address.street')->label('Adresse')->sortable(),
                TextColumn::make('type.label')->sortable(),
                TextColumn::make('lots_sum_capacity')->label('Capacité')
                    ->sum('lots', 'capacity')->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->url(ResidenceResource::getUrl('create', ['dispositif' => $this->getOwnerRecord()->id])),

            ])
            ->recordActions([
                ViewAction::make()
                    ->url(fn ($record) => ResidenceResource::getUrl('view', [$record])),
                EditAction::make()
                    ->url(fn ($record) => ResidenceResource::getUrl('edit', [$record])),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
