<?php

namespace App\Filament\Resources\CollectiveActions\Pages;

use App\Filament\Resources\CollectiveActions\CollectiveActionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCollectiveAction extends EditRecord
{
    protected static string $resource = CollectiveActionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
