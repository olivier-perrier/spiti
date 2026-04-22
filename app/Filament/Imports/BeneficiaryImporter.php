<?php

namespace App\Filament\Imports;

use App\Models\Beneficiary;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Filament\Facades\Filament;

class BeneficiaryImporter extends Importer
{
    protected static ?string $model = Beneficiary::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->label('Nom')
                ->requiredMapping()
                ->rules(['required'])
                ->example('Jean Rousseau'),
            ImportColumn::make('birth_name')
                ->label('Nom de naissance')
                ->example('Adam'),
            ImportColumn::make('AGDREF')
                ->label('AGDREF')
                ->example('64785043'),
            ImportColumn::make('sex')
                ->label('Sexe')
                ->example('man'),
            ImportColumn::make('birthday')
                ->label('Date de naissance')
                ->rules(['date'])
                ->example('2000-10-10'),
            ImportColumn::make('nationality')
                ->label('Nationnalité')
                ->example('Française'),
            ImportColumn::make('birth_country')
                ->label('Pays de naissance')
                ->example('France'),
            ImportColumn::make('birth_city')
                ->label('Ville de naissance')
                ->example('Montpellier'),
            ImportColumn::make('date_entry_dispositif')
                ->label("Date d'entré dans le dispositif")
                ->rules(['date'])
                ->example('2024-01-10'),
            ImportColumn::make('date_arrival_france')
                ->label("Date d'arrivé en France")
                ->rules(['date'])
                ->example('2023-01-10'),
            ImportColumn::make('typeFamily')
                ->label('Situation familliale')
                ->relationship(resolveUsing: 'label')
                ->example('Adulte sans enfant'),
            ImportColumn::make('typeAdministratif')
                ->label('Situation administrative')
                ->relationship(resolveUsing: 'label')
                ->example('Avec document séjour'),
            ImportColumn::make('phone')
                ->label('Téléphone')
                ->example(fake()->phoneNumber()),
            ImportColumn::make('mobile_phone')
                ->example(fake()->phoneNumber()),
            ImportColumn::make('email')
                ->label('Email')
                ->rules(['email'])
                ->example(fake()->email()),
            ImportColumn::make('lot')
                ->label('N° lot')
                ->relationship(resolveUsing: 'number')
                ->helperText('Le n° de lot doit obligatoirement exister')
                ->example(68183),
            // ImportColumn::make('menage')
            //     ->relationship(),
        ];
    }

    public function resolveRecord(): ?Beneficiary
    {
        // return Beneficiary::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Beneficiary;
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your beneficiary import has completed and '.number_format($import->successful_rows).' '.str('row')->plural($import->successful_rows).' imported.';

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
