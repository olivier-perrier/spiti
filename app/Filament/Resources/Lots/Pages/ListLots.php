<?php

namespace App\Filament\Resources\Lots\Pages;

use App\Filament\Exports\LotExporter;
use App\Filament\Imports\LotImporter;
use App\Filament\Resources\Lots\LotResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListLots extends ListRecords
{
    protected static string $resource = LotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()->label('Exporter')
                ->modalHeading('Exporter les lots')
                ->exporter(LotExporter::class),
            ImportAction::make()->label('Importer')
                ->importer(LotImporter::class),
            CreateAction::make(),
        ];
    }
}
