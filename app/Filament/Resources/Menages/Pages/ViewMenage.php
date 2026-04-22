<?php

namespace App\Filament\Resources\Menages\Pages;

use App\Filament\Resources\Menages\MenageResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMenage extends ViewRecord
{
    protected static string $resource = MenageResource::class;

    public function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
