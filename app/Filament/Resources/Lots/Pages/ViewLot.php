<?php

namespace App\Filament\Resources\Lots\Pages;

use App\Filament\Resources\Dispositifs\DispositifResource;
use App\Filament\Resources\Lots\LotResource;
use App\Filament\Resources\Residences\ResidenceResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLot extends ViewRecord
{
    protected static string $resource = LotResource::class;

    /**
     * @return array<string>
     */
    public function getBreadcrumbs(): array
    {
        $resource = static::getResource();

        $breadcrumbs = [
            DispositifResource::getUrl() => DispositifResource::getBreadcrumb(),
            DispositifResource::getUrl('edit', ['record' => $this->record->residence->dispositif->id]) => $this->record->residence->dispositif->name,
            ResidenceResource::getUrl() => ResidenceResource::getBreadcrumb(),
            ResidenceResource::getUrl('edit', ['record' => $this->record->residence->id]) => $this->record->residence->name,
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
            EditAction::make(),
        ];
    }
}
