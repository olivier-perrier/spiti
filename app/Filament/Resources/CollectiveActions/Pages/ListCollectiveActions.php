<?php

namespace App\Filament\Resources\CollectiveActions\Pages;

use App\Filament\Resources\CollectiveActions\CollectiveActionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCollectiveActions extends ListRecords
{
    protected static string $resource = CollectiveActionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
