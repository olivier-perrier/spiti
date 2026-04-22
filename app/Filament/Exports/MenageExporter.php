<?php

namespace App\Filament\Exports;

use App\Models\Menage;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class MenageExporter extends Exporter
{
    protected static ?string $model = Menage::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name')->label('Nom'),
            ExportColumn::make('referent.name')->label('Référent'),
            ExportColumn::make('dispositif.name')->label('Dispositif'),
            ExportColumn::make('address.street')->label('Adresse'),
            ExportColumn::make('beneficiaries_count')->label('Adresse')
                ->counts('beneficiaries'),
            ExportColumn::make('code')->label('Code'),
            ExportColumn::make('date_entry')->label("Date d'entrée dans dispositif"),
            ExportColumn::make('has_social_right')->label('Eligible aux droits sociaux'),
            ExportColumn::make('badge_key')->label('Badge / Clef'),
            ExportColumn::make('animal')->label('Animal de compagnie'),
            ExportColumn::make('animal_type')->label('Espèce'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your menage export has completed and '.number_format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to export.';
        }

        return $body;
    }
}
