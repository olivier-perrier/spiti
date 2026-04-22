<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\CollectiveActions\Pages\ViewCollectiveAction;
use App\Models\CollectiveAction;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class NextCollectiveActions extends TableWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->heading('Actions collectives à venir')
            ->query(fn (): Builder => CollectiveAction::query()->futures()->limit(5))
            ->columns([
                TextColumn::make('name')->label('Intitulé')->sortable(),
                TextColumn::make('start_date')->label('Date de mis en oeuvre')->sortable()->date(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordUrl(fn (CollectiveAction $record) => ViewCollectiveAction::getUrl([$record]))
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ])
            ->paginated(false);
    }
}
