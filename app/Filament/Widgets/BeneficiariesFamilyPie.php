<?php

namespace App\Filament\Widgets;

use App\Models\Beneficiary;
use App\Models\Type;
use Filament\Facades\Filament;
use Filament\Widgets\ChartWidget;

class BeneficiariesFamilyPie extends ChartWidget
{
    protected static bool $isLazy = true;

    protected ?string $heading = 'Bénéficaires composition familiale';

    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $data = Type::query()
            ->select('label')
            ->withCount(['beneficiaries' => fn ($q) => $q->where('team_id', Filament::getTenant()->id)])
            ->whereHas('beneficiaries')
            ->where('typeable_type', Beneficiary::class.'.family')
            ->get();

        return [
            'datasets' => [
                [
                    'data' => $data->pluck('beneficiaries_count'),
                    'backgroundColor' => [
                        '#FFCE56',
                        '#36A2EB',
                        '#FF6384',
                    ],
                ],
            ],
            'labels' => $data->pluck('label'),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
