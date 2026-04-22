<?php

namespace App\Filament\Widgets;

use App\Models\Beneficiary;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Widgets\ChartWidget;

class BeneficiariesAgeChart extends ChartWidget
{
    protected ?string $heading = 'Bénéficaires par age';

    protected int|string|array $columnSpan = 'full';

    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $data = Beneficiary::query()
            ->where('team_id', Filament::getTenant()->id)
            ->select('birthday')->get();

        $data = $data->countBy(function ($item, int $key) {
            return Carbon::createFromDate($item->birthday)->age;
        })->sortKeys();

        return [
            'datasets' => [
                [
                    'label' => 'Bénéficaires par age',
                    'data' => $data->values(),
                ],
            ],
            'labels' => $data->keys(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
