<?php

namespace App\Filament\Widgets;

use App\Models\Contract;
use Filament\Widgets\ChartWidget;

class ContractsByFloorChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected ?string $heading = 'توزيع الوحدات والعقود حسب أدوار المبنى';

    protected function getData(): array
    {
        $floors = [
            'الدور الأرضي',
            'الدور الأول',
            'الدور الثاني',
            'الدور الثالث',
            'الدور الرابع',
            'الدور الخامس',
            'الدور السادس',
        ];

        $counts = [];
        foreach ($floors as $floor) {
            $counts[] = Contract::where('floor', $floor)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'عدد العقود والوحدات',
                    'data' => $counts,
                    'backgroundColor' => [
                        '#6366f1',
                        '#3b82f6',
                        '#0ea5e9',
                        '#14b8a6',
                        '#10b981',
                        '#f59e0b',
                        '#8b5cf6',
                    ],
                ],
            ],
            'labels' => $floors,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
