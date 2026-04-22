<?php

namespace App\Filament\Resources\Beneficiaries\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BeneficiaryOQTFTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('date_notification_48h')->label('Date décision 48h')->toggleable(),
                TextColumn::make('date_notification_15d')->label('Date décision 15h')->toggleable(),
                TextColumn::make('date_appeal')->label('Date recours')->toggleable(),
                TextColumn::make('date_notification_TA')->label('Date notification TA')->toggleable(),
                TextColumn::make('decision_TA')->label('Décision TA')->toggleable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->mutateDataUsing(function ($data) {
                        $data['team_id'] = Filament::getTenant()->id;

                        return $data;
                    }),
            ])
            ->recordActions([
                Action::make('generatePDF')->label('Exporter')
                    ->action('generatePDF')
                    ->icon('heroicon-c-arrow-down-tray'),
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
