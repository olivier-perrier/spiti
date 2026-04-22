<?php

namespace App\Filament\Resources\Menages\RelationManagers;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Models\Beneficiary;
use App\Models\Lot;
use App\Models\Residence;
use Filament\Actions\Action;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\ViewAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BeneficiariesRelationManager extends RelationManager
{
    protected static string $relationship = 'beneficiaries';

    protected static ?string $title = 'Membres du ménage';

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
                    ->sortable(),
                TextColumn::make('email')
                    ->sortable(),
                TextColumn::make('birthday')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('phone')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('lot.residence.name')->label('Résidence')->toggleable(),
                TextColumn::make('lot.number')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('lot.address.street')->label('Adresse')->toggleable(),
                TextColumn::make('lot.type.label')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->mutateDataUsing(function (array $data): array {
                        $data['team_id'] = Filament::getTenant()->id;

                        return $data;
                    }),
                AssociateAction::make()
                    ->preloadRecordSelect(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->url(fn (Beneficiary $record) => BeneficiaryResource::getUrl('view', [$record])),
                Action::make('change_lot')->label('Changer lot')
                    ->fillForm(fn (Beneficiary $record): array => [
                        'residence' => $record->lot?->residence?->id,
                        'lot' => @$record->lot?->id,
                    ])
                    ->schema([
                        Group::make([
                            Select::make('residence')->label('Résidence')
                                ->options(Residence::pluck('name', 'id'))
                                ->live(),
                            Select::make('lot')->label('Lot')
                                ->options(fn (Get $get) => Lot::where('residence_id', $get('residence'))->pluck('number', 'id'))
                                ->disabled(fn (Get $get) => $get('residence') == null),
                        ])->columns(2),
                    ])
                    ->action(function (array $data, Beneficiary $record): void {
                        $record->lot()->associate($data['lot']);
                        $record->save();

                        Notification::make()->title('Sauvegardé')->success()->send();
                    }),
                DissociateAction::make(),
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->inverseRelationship('menage');
    }
}
