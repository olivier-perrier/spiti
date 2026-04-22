<?php

namespace App\Filament\Imports;

use App\Models\Residence;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Filament\Facades\Filament;

class ResidenceImporter extends Importer
{
    protected static ?string $model = Residence::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')->label('Nom')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->example('Résidence des fleures'),
            ImportColumn::make('elevator')->label('Ascenseur')
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean'])
                ->example('1'),
            ImportColumn::make('parking')->label('Parking')
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean'])
                ->example('1'),
            ImportColumn::make('heating')->label('Chauffage')
                ->example('1'),
            ImportColumn::make('public_transport')->label('Accès aux transports en commun')
                ->example('1'),
            ImportColumn::make('dispositif')->label('Dispositif (nom)')
                ->requiredMapping()
                ->relationship(resolveUsing: 'name')
                ->rules(['required'])
                ->helperText('Ce nom de dispositif doit obligatoirement exister')
                ->example('Dispositif eum'),
            ImportColumn::make('type')->label('Type')
                ->relationship(resolveUsing: 'label')
                ->example('Maison'),
        ];
    }

    public function resolveRecord(): ?Residence
    {
        // return Residence::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Residence;
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your residence import has completed and '.number_format($import->successful_rows).' '.str('row')->plural($import->successful_rows).' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to import.';
        }

        return $body;
    }

    protected function beforeCreate(): void
    {
        $this->getRecord()->team_id = Filament::getTenant()->id;
        $this->getRecord()->save();
    }
}
