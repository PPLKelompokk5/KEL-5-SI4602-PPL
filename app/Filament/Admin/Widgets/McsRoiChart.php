<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\McsRoi;

class McsRoiChart extends ChartWidget
{
    protected static ?string $heading = 'Diagram Data MCS ROI';
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $data = McsRoi::selectRaw('MONTH(created_at) as month, SUM(harga) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Total Harga MCS ROI',
                    'data' => array_values($data),
                ],
            ],
            'labels' => array_map(fn($m) => date('F', mktime(0,0,0,$m,1)), array_keys($data)),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
