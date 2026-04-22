<?php

namespace App\Filament\Resources\Residences\Pages;

use App\Filament\Resources\Residences\ResidenceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateResidence extends CreateRecord
{
    protected static string $resource = ResidenceResource::class;

    public function mount(): void
    {
        parent::mount();

        if (request()->has('dispositif')) {
            $this->form->fill(['dispositif_id' => request()->dispositif]);
        }
    }
}
