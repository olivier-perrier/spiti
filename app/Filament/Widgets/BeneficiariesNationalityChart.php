<?php

namespace App\Filament\Widgets;

use App\Models\Beneficiary;
use Filament\Facades\Filament;
use Filament\Widgets\ChartWidget;

class BeneficiariesNationalityChart extends ChartWidget
{
    protected ?string $heading = 'Bénéficaires par nationalité';

    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $data = Beneficiary::query()
            ->where('team_id', Filament::getTenant()->id)
            ->whereNotNull('nationality')
            ->selectRaw('nationality, count(*) as total')->groupBy('nationality')->pluck('total', 'nationality');

        return [
            'datasets' => [
                [
                    'data' => $data->values(),
                    'backgroundColor' => [
                        '#FFCE56',
                        '#36A2EB',
                        '#FF6384',
                    ],
                ],
            ],
            'labels' => $data->keys(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
