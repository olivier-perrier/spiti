<?php

namespace App\Filament\Exports;

use App\Models\Dispositif;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class DispositifExporter extends Exporter
{
    protected static ?string $model = Dispositif::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name')->label('Dispositif'),
            ExportColumn::make('address.postcode')->label('Département'),
            ExportColumn::make('type.label')->label('Type'),
            ExportColumn::make('finess_number')->label('N° finess'),
            ExportColumn::make('opening_date')->label("Date d'ouverture"),
            ExportColumn::make('lots_count')->counts('lots')->label('Nombre de lot'),
            ExportColumn::make('lots_sum_capacity')->sum('lots', 'capacity')->label('Places'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = "L'export des dispositifs est terminé avec ".number_format($export->successful_rows).' '.str('ligne')->plural($export->successful_rows);

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('ligne')->plural($failedRowsCount)." n'ont pas pu être exportées.";
        }

        return $body;
    }
}
