<?php

namespace App\Filament\Resources\Residences\RelationManagers;

use App\Filament\Resources\Lots\LotResource;
use App\Models\Lot;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ReplicateAction;
use Filament\Actions\ViewAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LotsRelationManager extends RelationManager
{
    protected static string $relationship = 'lots';

    protected static ?string $title = 'Lots associés';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('number')->label('N° lot')
                    ->required()
                    ->numeric()->minValue(0),
                Select::make('type_id')->label('Type')->required()
                    ->relationship('type', 'label'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('number')
            ->columns([
                TextColumn::make('number')->label('N° lot')->sortable(),
                TextColumn::make('residence.dispositif.name')->label('Dispositif')->sortable()->toggleable(),
                TextColumn::make('type.label')->label('Typologie')->sortable(),
                TextColumn::make('surface')->label('Surface')->sortable()->toggleable(),
                TextColumn::make('capacity')->label('Capacité')->sortable(),
                TextColumn::make('building')->label('Batiment')->sortable()->toggleable(),
                TextColumn::make('floor')->label('Etage')->sortable()->toggleable(),
                IconColumn::make('PMR')->label('PMR')->boolean(true)->sortable()->toggleable(),
                TextColumn::make('beneficiaries_count')->label('Bénéficiaires')->counts('beneficiaries')->sortable(),
                TextColumn::make('tocPourcentage')->label('TOC')->suffix('%')->toggleable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Créer un lot')
                    ->mutateDataUsing(function (array $data): array {
                        $data['team_id'] = Filament::getTenant()->id;

                        return $data;
                    }),
            ])
            ->recordActions([
                ViewAction::make()
                    ->url(fn (Lot $record) => LotResource::getUrl('view', [$record])),
                EditAction::make()
                    ->url(fn (Lot $record) => LotResource::getUrl('edit', [$record])),
                ReplicateAction::make()->hiddenLabel(false)
                    ->modalHeading(fn ($record) => 'Dupliquer le lot n°'.$record->number)
                    ->excludeAttributes(['beneficiaries_count']),
                DeleteAction::make()
                    ->disabled(fn (Lot $record) => $record->beneficiaries_count > 0),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
