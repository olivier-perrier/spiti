<?php

namespace App\Filament\Exports;

use App\Models\Beneficiary;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class BeneficiaryExporter extends Exporter
{
    protected static ?string $model = Beneficiary::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name')->label('Nom'),
            ExportColumn::make('lot.residence.name')->label('Résidence'),
            ExportColumn::make('lot.number')->label('N° Lot'),
            ExportColumn::make('birthday')->label('aze'),
            ExportColumn::make('menage.name')->label('Ménage'),
            ExportColumn::make('phone')->label('Téléphone'),
            ExportColumn::make('mobile_phone')->label('Téléphone mobile'),
            ExportColumn::make('email')->label('Email'),
            ExportColumn::make('AGDREF')->label('AGDREF'),
            ExportColumn::make('sex')->label('Sexe'),
            ExportColumn::make('birth_name')->label('Nom de naissance'),
            ExportColumn::make('nationality')->label('Nationnalité'),
            ExportColumn::make('birth_country')->label('Pays de naissance'),
            ExportColumn::make('birth_city')->label('Ville de naissance'),
            ExportColumn::make('date_entry_dispositif')->label("Date d'entrée dans le dispositif"),
            ExportColumn::make('date_arrival_france')->label("Date d'arrivée en France"),
            ExportColumn::make('typeFamily.label')->label('Situation familliale'),
            ExportColumn::make('typeAdministratif.label')->label('Situation administrative'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your beneficiary export has completed and '.number_format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to export.';
        }

        return $body;
    }
}
