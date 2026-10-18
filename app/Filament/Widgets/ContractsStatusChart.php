<?php

namespace App\Filament\Widgets;

use App\Models\Contract;
use Filament\Widgets\ChartWidget;

class ContractsStatusChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'مؤشر ومتابعة حالة العقود';

    protected function getData(): array
    {
        $activeCount = Contract::where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>', now()->addDays(30)->toDateString());
            })->count();

        $endingSoonCount = Contract::where('status', 'active')
            ->whereBetween('end_date', [now()->toDateString(), now()->addDays(30)->toDateString()])
            ->count();

        $expiredCount = Contract::where('status', 'expired')
            ->orWhere(function ($q) {
                $q->whereNotNull('end_date')
                  ->where('end_date', '<', now()->toDateString());
            })->count();

        return [
            'datasets' => [
                [
                    'label' => 'عدد العقود',
                    'data' => [$activeCount, $endingSoonCount, $expiredCount],
                    'backgroundColor' => [
                        '#10b981', // green
                        '#f59e0b', // amber
                        '#ef4444', // red
                    ],
                ],
            ],
            'labels' => ['سارية ومستقرة', 'تنتهي خلال 30 يوم', 'منتهية'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
