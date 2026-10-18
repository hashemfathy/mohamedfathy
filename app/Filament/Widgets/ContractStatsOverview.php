<?php

namespace App\Filament\Widgets;

use App\Models\Contract;
use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContractStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalContracts = Contract::count();
        $activeContracts = Contract::where('status', 'active')->count();
        $expiredContracts = Contract::where('status', 'expired')->count();
        $endingSoon = Contract::whereBetween('end_date', [now()->toDateString(), now()->addDays(30)->toDateString()])->count();
        $totalProjects = Project::count();
        $monthlyRevenue = Contract::where('status', 'active')->sum('rent_amount');
        $totalInsurance = Contract::sum('insurance_amount');

        $activePercentage = $totalContracts > 0 ? round(($activeContracts / $totalContracts) * 100) : 0;

        return [
            Stat::make('إجمالي العقود المعتمدة', $totalContracts)
                ->description('موزعة على كافة وحدات وأدوار المبنى')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary')
                ->chart([30, 35, 42, $totalContracts]),

            Stat::make('العقود السارية', $activeContracts)
                ->description("تشكل {$activePercentage}% من إجمالي العقود")
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success')
                ->chart([20, 25, 35, $activeContracts]),

            Stat::make('العقود المنتهية', $expiredContracts)
                ->description('تحتاج لمتابعة التجديد أو إنهاء التعاقد')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($expiredContracts > 0 ? 'danger' : 'gray'),

            Stat::make('عقود تنتهي قريباً (30 يوم)', $endingSoon)
                ->description('تنبيه للمكتب لاتخاذ الإجراءات القانونية')
                ->descriptionIcon('heroicon-m-clock')
                ->color($endingSoon > 0 ? 'warning' : 'gray'),

            Stat::make('المشاريع والمباني', $totalProjects)
                ->description('مباني ومجمعات تجارية وإدارية')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('info'),

            Stat::make('إجمالي الإيجارات الشهرية', number_format($monthlyRevenue, 0) . ' ج.م')
                ->description('الحصيلة الشهرية للعقود السارية')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success')
                ->chart([$monthlyRevenue * 0.7, $monthlyRevenue * 0.85, $monthlyRevenue]),
        ];
    }
}
