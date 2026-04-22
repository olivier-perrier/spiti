<?php

namespace App\Filament\Resources\CollectiveActions\Pages;

use App\Filament\Resources\CollectiveActions\CollectiveActionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCollectiveAction extends CreateRecord
{
    protected static string $resource = CollectiveActionResource::class;
}
