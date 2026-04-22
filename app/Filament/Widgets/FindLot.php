<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Lots\Pages\ViewLot;
use App\Models\Lot;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class FindLot extends TableWidget
{
    protected static ?string $pollingInterval = null;

    public function table(Table $table): Table
    {
        return $table
            ->heading('Trouver un lot')
            ->query(fn (): Builder => Lot::query()->withCount('beneficiaries')->havingRaw('beneficiaries_count < capacity'))
            ->columns([
                TextColumn::make('number')->label('Numéro')->sortable(),
                TextColumn::make('residence.dispositif.name')->label('Dispositif')->sortable(),
                TextColumn::make('availability')
                    ->label('Nombre de places restantes')
                    ->counts('beneficiaries')
                    ->getStateUsing(fn (Lot $record) => max($record->capacity - $record->beneficiaries_count, 0))
                    ->sortable(query: fn (Builder $query, string $direction) => $query->withCount('beneficiaries')->orderByRaw("capacity - beneficiaries_count $direction")),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordUrl(fn (Lot $record) => ViewLot::getUrl([$record]))
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
