<?php

namespace App\Filament\Resources\Beneficiaries\Pages;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBeneficiary extends ViewRecord
{
    protected static string $resource = BeneficiaryResource::class;

    protected static ?string $navigationLabel = 'Bénéficiaire';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user';

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
