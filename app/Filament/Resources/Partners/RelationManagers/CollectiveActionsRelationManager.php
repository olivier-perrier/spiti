<?php

namespace App\Filament\Resources\Partners\RelationManagers;

use App\Filament\Resources\CollectiveActions\CollectiveActionResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CollectiveActionsRelationManager extends RelationManager
{
    protected static string $relationship = 'collectiveActions';

    protected static ?string $title = 'Actions collectives';

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
                TextColumn::make('name')->label('Nom'),
                TextColumn::make('theme')->label('Thème'),
                TextColumn::make('subtheme')->label('Sous thème'),
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
                ViewAction::make()
                    ->url(fn ($record) => CollectiveActionResource::getUrl('view', [$record])),
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
