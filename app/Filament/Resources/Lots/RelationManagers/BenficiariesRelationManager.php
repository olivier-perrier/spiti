<?php

namespace App\Filament\Resources\Lots\RelationManagers;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Models\Beneficiary;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DissociateAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BenficiariesRelationManager extends RelationManager
{
    protected static string $relationship = 'beneficiaries';

    protected static ?string $title = 'Bénéficiaires associés';

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
                TextColumn::make('name')->label('Nom')
                    ->sortable(),
                TextColumn::make('email')
                    ->sortable(),
                TextColumn::make('menage.name')->label('Ménage')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
                AssociateAction::make()
                    ->preloadRecordSelect()
                    ->modalHeading('Associer un bénéficiaire'),
            ])
            ->recordActions([
                ViewAction::make()
                    ->url(fn (Beneficiary $record) => BeneficiaryResource::getUrl('view', [$record])),
                // Tables\Actions\EditAction::make(),
                DissociateAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->inverseRelationship('lot');
    }
}
