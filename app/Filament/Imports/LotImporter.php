<?php

namespace App\Filament\Imports;

use App\Models\Lot;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Filament\Facades\Filament;

class LotImporter extends Importer
{
    protected static ?string $model = Lot::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('number')->label('N° Lot')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer'])
                ->example('123456'),
            ImportColumn::make('type')
                ->relationship(resolveUsing: 'label')
                ->example('Chambre'),
            ImportColumn::make('surface')
                ->numeric()
                ->rules(['integer'])
                ->example('24'),
            ImportColumn::make('building')->label('Batiment')
                ->example('Bat 2'),
            ImportColumn::make('floor')->label('Etage')
                ->example('4'),
            ImportColumn::make('capacity')->label('Capacité')
                ->numeric()
                ->rules(['nullable', 'integer'])
                ->example('2'),
            ImportColumn::make('agreed_capacity')->label('Capacité conventionnée')
                ->numeric()
                ->rules(['nullable', 'integer'])
                ->example('2'),
            ImportColumn::make('PMR')->label('PMR')
                ->requiredMapping()
                ->boolean()
                ->rules(['nullable', 'boolean'])
                ->example(true),
            ImportColumn::make('residence')
                ->requiredMapping()
                ->relationship(resolveUsing: 'name')
                ->rules(['required'])
                ->helperText('Ce nom de résidence doit obligatoirement exister')
                ->example('modi'),
        ];
    }

    public function resolveRecord(): ?Lot
    {
        // return Lot::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Lot;
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your lot import has completed and '.number_format($import->successful_rows).' '.str('row')->plural($import->successful_rows).' imported.';

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
