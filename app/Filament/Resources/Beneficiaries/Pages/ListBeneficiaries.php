<?php

namespace App\Filament\Resources\Beneficiaries\Pages;

use App\Filament\Exports\BeneficiaryExporter;
use App\Filament\Imports\BeneficiaryImporter;
use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListBeneficiaries extends ListRecords
{
    protected static string $resource = BeneficiaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()->label('Exporter')
                ->modalHeading('Exporter les bénéficiaires')
                ->exporter(BeneficiaryExporter::class),
            ImportAction::make()->label('Importer')
                ->importer(BeneficiaryImporter::class),
            CreateAction::make(),
        ];
    }
}
