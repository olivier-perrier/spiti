<?php

namespace App\Filament\Resources\Residences\Pages;

use App\Filament\Exports\ResidenceExporter;
use App\Filament\Imports\ResidenceImporter;
use App\Filament\Resources\Residences\ResidenceResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListResidences extends ListRecords
{
    protected static string $resource = ResidenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()->label('Exporter')
                ->modalHeading('Exporter les résidences')
                ->exporter(ResidenceExporter::class),
            ImportAction::make()->label('Importer')
                ->importer(ResidenceImporter::class),
            CreateAction::make(),
        ];
    }
}
