<?php

namespace App\Filament\Resources\Menages\Pages;

use App\Filament\Resources\Menages\MenageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMenage extends EditRecord
{
    protected static string $resource = MenageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->modalHeading(fn ($record) => "Supprimer le Ménage {$record->name}"),
        ];
    }
}
