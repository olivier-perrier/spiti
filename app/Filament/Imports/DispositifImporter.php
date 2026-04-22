<?php

namespace App\Filament\Imports;

use App\Models\Address;
use App\Models\Dispositif;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Filament\Facades\Filament;

class DispositifImporter extends Importer
{
    protected static ?string $model = Dispositif::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')->label('Nom')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->example("Dispositif d'aide au logement"),
            ImportColumn::make('type')->label('Type')
                ->requiredMapping()
                ->relationship(resolveUsing: 'label')
                ->rules(['required'])
                ->example('CADA'),
            ImportColumn::make('finess_number')->label('N° finess')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->example('123456'),
            ImportColumn::make('opening_date')->label("Date d'ouverture")
                ->requiredMapping()
                ->rules(['required', 'date'])
                ->example('2024-10-10'),
            ImportColumn::make('closing_date')->label('Date de fermeture')
                ->rules(['date'])
                ->example('2024-10-10'),
            ImportColumn::make('address.street')->label('Rue')
                ->rules(['string'])
                ->example('53, Rue de la poste'),
            ImportColumn::make('address.city')->label('Ville')
                ->rules(['string'])
                ->example('Paris'),
            ImportColumn::make('address.country')->label('Pays')
                ->rules(['string'])
                ->example('France'),
            ImportColumn::make('address.postcode')->label('Code postal')
                ->rules(['string'])
                ->example('23154'),
        ];
    }

    public function resolveRecord(): ?Dispositif
    {
        // return Dispositif::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Dispositif;
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your dispositif import has completed and '.number_format($import->successful_rows).' '.str('row')->plural($import->successful_rows).' imported.';

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

    protected function afterCreate(): void
    {
        $data = $this->getData();
        // dd($data);

        $array_address = [];

        if (isset($data['street'])) {
            $array_address['street'] = $data['street'];
        }

        if (isset($data['city'])) {
            $array_address['city'] = $data['city'];
        }

        if (isset($data['country'])) {
            $array_address['country'] = $data['country'];
        }

        if (isset($data['postcode'])) {
            $array_address['postcode'] = $data['postcode'];
        }

        $address = Address::create($array_address);

        $this->getRecord()->address()->associate($address);
        $this->getRecord()->save();
    }
}
