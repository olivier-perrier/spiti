<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Lots\LotResource;
use App\Models\Beneficiary;
use App\Models\Lot;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LotOverview extends BaseWidget
{
    protected static ?int $sort = -3;

    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        $places = Lot::where('team_id', Filament::getTenant()->id)->sum('capacity') - Beneficiary::where('team_id', Filament::getTenant()->id)->has('lot')->count();

        return [
            Stat::make('Place(s) disponible(s)', max($places, 0))
                ->url(LotResource::getUrl('index', parameters: ['tableFilters[availability][isActive]' => true])),
        ];
    }
}
