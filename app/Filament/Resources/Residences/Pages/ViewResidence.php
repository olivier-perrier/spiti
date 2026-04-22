<?php

namespace App\Filament\Resources\Residences\Pages;

use App\Filament\Resources\Residences\ResidenceResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewResidence extends ViewRecord
{
    protected static string $resource = ResidenceResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Résidence '.$this->record->name;
    }

    public function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
