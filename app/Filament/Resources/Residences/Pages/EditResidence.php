<?php

namespace App\Filament\Resources\Residences\Pages;

use App\Filament\Resources\Dispositifs\DispositifResource;
use App\Filament\Resources\Residences\ResidenceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditResidence extends EditRecord
{
    protected static string $resource = ResidenceResource::class;

    /**
     * @return array<string>
     */
    public function getBreadcrumbs(): array
    {
        $resource = static::getResource();

        $breadcrumbs = [
            DispositifResource::getUrl() => DispositifResource::getBreadcrumb(),
            DispositifResource::getUrl('edit', ['record' => $this->record->dispositif->id]) => $this->record->dispositif->name,
            $resource::getUrl() => $resource::getBreadcrumb(),
            ...(filled($breadcrumb = $this->getBreadcrumb()) ? [$breadcrumb] : []),
        ];

        if (filled($cluster = static::getCluster())) {
            return $cluster::unshiftClusterBreadcrumbs($breadcrumbs);
        }

        return $breadcrumbs;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
