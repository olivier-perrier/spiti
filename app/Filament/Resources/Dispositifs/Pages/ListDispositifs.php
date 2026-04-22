<?php

namespace App\Filament\Resources\Dispositifs\Pages;

use App\Filament\Exports\DispositifExporter;
use App\Filament\Imports\DispositifImporter;
use App\Filament\Resources\Dispositifs\DispositifResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListDispositifs extends ListRecords
{
    protected static string $resource = DispositifResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()->label('Exporter')
                ->modalHeading('Exporter les dispositfs')
                ->exporter(DispositifExporter::class),
            ImportAction::make()->label('Importer')
                ->importer(DispositifImporter::class),
            CreateAction::make(),
        ];
    }
}
