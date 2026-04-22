<?php

namespace App\Filament\Resources\Menages\Pages;

use App\Filament\Exports\MenageExporter;
use App\Filament\Resources\Menages\MenageResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;

class ListMenages extends ListRecords
{
    protected static string $resource = MenageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()->label('Exporter')
                ->modalHeading('Exporter les Ménages')
                ->exporter(MenageExporter::class),
            CreateAction::make(),
        ];
    }
}
