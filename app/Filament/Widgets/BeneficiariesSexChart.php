<?php

namespace App\Filament\Widgets;

use App\Models\Beneficiary;
use Filament\Facades\Filament;
use Filament\Widgets\ChartWidget;

class BeneficiariesSexChart extends ChartWidget
{
    protected ?string $heading = 'Bénéficaires par genre';

    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $data = Beneficiary::query()
            ->where('team_id', Filament::getTenant()->id)
            ->selectRaw('sex, count(id) as total')->groupBy('sex')->get();

        return [
            'datasets' => [
                [
                    'data' => $data->pluck('total'),
                    'backgroundColor' => [
                        '#FFCE56',
                        '#36A2EB',
                        '#FF6384',
                    ],
                ],
            ],
            'labels' => ['N/A', 'Homme', 'Femme'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
