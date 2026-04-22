<?php

namespace App\Filament\Exports;

use App\Models\Residence;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ResidenceExporter extends Exporter
{
    protected static ?string $model = Residence::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name')->label('Nom'),
            ExportColumn::make('dispositif.name')->label('Dispositif'),
            ExportColumn::make('address.street')->label('Adresse'),
            ExportColumn::make('type.label')->label('Type'),
            ExportColumn::make('lots_sum_capacity')->label('Capacité')
                ->sum('lots', 'capacity'),
            ExportColumn::make('tocPourcentage')->label('TOC'),
            ExportColumn::make('elevator')->label('Ascenseur'),
            ExportColumn::make('parking')->label('Parking'),
            ExportColumn::make('heating')->label('Chauffage'),
            ExportColumn::make('public_transport')->label('Accès aux transports en commun'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your residence export has completed and '.number_format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to export.';
        }

        return $body;
    }
}
