<?php

namespace App\Filament\Exports;

use App\Models\Lot;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class LotExporter extends Exporter
{
    protected static ?string $model = Lot::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('number')->label('N° lot'),
            ExportColumn::make('residence.dispositif.name')->label('Dispositif'),
            ExportColumn::make('residence.name')->label('Résidence'),
            ExportColumn::make('type.label')->label('Typologie'),
            ExportColumn::make('surface')->label('Surface'),
            ExportColumn::make('capacity')->label('Capacité'),
            ExportColumn::make('agreed_capacity')->label('Capacité conventionnée'),
            ExportColumn::make('building')->label('Batiment'),
            ExportColumn::make('floor')->label('Etage'),
            ExportColumn::make('PMR')->label('PMR'),
            ExportColumn::make('tocPourcentage')->label('TOC (%)'),
            ExportColumn::make('address.street')->label('Adresse'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your lot export has completed and '.number_format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to export.';
        }

        return $body;
    }
}
