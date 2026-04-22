<?php

namespace App\Filament\Resources\Beneficiaries\Tables;

use App\Filament\Resources\Beneficiaries\Pages\EditBeneficiary;
use App\Filament\Resources\Beneficiaries\Pages\ViewBeneficiary;
use App\Filament\Resources\Menages\MenageResource;
use App\Filament\Resources\Residences\ResidenceResource;
use App\Models\Beneficiary;
use App\Models\Dispositif;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BeneficiariesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nom')->sortable()->searchable(),
                TextColumn::make('lot.residence.name')->label('Résidence')->searchable()->sortable()
                    ->url(fn (Beneficiary $record): ?string => $record->lot ? ResidenceResource::getUrl('view', [$record->lot->residence]) : null)
                    ->extraAttributes(['class' => 'text-blue-500 hover:underline']),
                TextColumn::make('lot.number')->label('N° lot')->searchable()->sortable(),
                TextColumn::make('birthday')->label('Date de naissance')->searchable()->sortable()->toggleable(),
                TextColumn::make('menage.name')->label('Ménage')->searchable()->sortable(),
                TextColumn::make('phone')->label('Téléphone')->searchable()->sortable()->toggleable(),
                TextColumn::make('email')->label('Email')->searchable()->sortable()->toggleable(),
                TextColumn::make('AGDREF')->label('AGDREF')->searchable()->sortable()->toggleable(),
                TextColumn::make('menage.referent.name')->label('Référent')->searchable()->sortable(),
            ])
            ->filters([
                Filter::make('dispositf')->label('Dispositif')
                    ->schema([
                        Select::make('dispositif')
                            ->searchable()
                            ->preload()
                            ->options(Dispositif::pluck('name', 'id')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when($data['dispositif'], function (Builder $query, $data) {
                            return $query->whereHas('lot.residence.dispositif', function (Builder $query) use ($data) {
                                return $query->where('id', $data);
                            });
                        });
                    }),
                SelectFilter::make('menage')
                    ->label('Ménage')
                    ->relationship('menage', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('administrative_situation_id')
                    ->label('Situation administrative')
                    ->relationship('typeAdministratif', 'label'),
                SelectFilter::make('family_situation_id')
                    ->label('Composition familiale')
                    ->relationship('typeFamily', 'label'),
                Filter::make('no_lot')->label('Bénéficiaires sans lot')
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->whereDoesntHave('lot');
                    })
                    ->toggle(),
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                ViewAction::make(),
                ViewAction::make('menage')->label('Menage')->icon('heroicon-s-user-group')
                    ->disabled(fn ($record) => ! $record->menage)
                    ->url(fn ($record) => $record->menage ? MenageResource::getUrl('view', [$record->menage]) : null),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->recordUrl(function (Beneficiary $record): string {
                if (request()->user()->can('update', $record)) {
                    return EditBeneficiary::getUrl([$record]);
                } else {
                    return ViewBeneficiary::getUrl([$record]);
                }
            });
    }
}
