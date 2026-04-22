<?php

namespace App\Filament\Resources\CollectiveActions\RelationManagers;

use App\Filament\Resources\Beneficiaries\Pages\ViewBeneficiary;
use App\Models\Beneficiary;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BeneficiariesRelationManager extends RelationManager
{
    protected static string $relationship = 'beneficiaries';

    protected static ?string $title = 'Bénéficiaires';

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
                TextColumn::make('name')
                    ->label('Nom')
                    ->sortable(),
                TextColumn::make('lot.residence.dispositif.name')
                    ->label('Dispositif')
                    ->sortable(),
                TextColumn::make('lot.residence.name')
                    ->label('Résidence')
                    ->sortable(),
                TextColumn::make('lot.number')
                    ->label('Lot')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make()
                    ->modalHeading('Attacher un bénéficiaire')
                    ->preloadRecordSelect()
                    ->multiple(),
                // Tables\Actions\CreateAction::make(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->url(fn (Beneficiary $record): string => ViewBeneficiary::getUrl(['record' => $record])),
                // Tables\Actions\EditAction::make(),
                DetachAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
