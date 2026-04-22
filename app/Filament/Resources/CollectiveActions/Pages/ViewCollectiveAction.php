<?php

namespace App\Filament\Resources\CollectiveActions\Pages;

use App\Filament\Resources\CollectiveActions\CollectiveActionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCollectiveAction extends ViewRecord
{
    protected static string $resource = CollectiveActionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
