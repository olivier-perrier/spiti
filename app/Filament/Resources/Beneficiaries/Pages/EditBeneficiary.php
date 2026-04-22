<?php

namespace App\Filament\Resources\Beneficiaries\Pages;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Menages\MenageResource;
use App\Models\Beneficiary;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBeneficiary extends EditRecord
{
    protected static string $resource = BeneficiaryResource::class;

    protected static ?string $navigationLabel = 'Bénéficiaire';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            Action::make('view_menage')->label('Voir le ménage')
                ->url(fn (Beneficiary $record) => MenageResource::getUrl('view', [$record]))
                ->color('info'),
        ];
    }
}
