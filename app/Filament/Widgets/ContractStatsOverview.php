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
        $increaseDueSoonCount = count(Contract::getIncreaseDueSoonIds(30));
        $totalProjects = Project::count();

        $activeContractsList = Contract::where('status', 'active')->get();
        $monthlyRevenue = $activeContractsList->sum(fn (Contract $contract) => $contract->current_rent_amount);
        $initialMonthlyRevenue = $activeContractsList->sum(fn (Contract $contract) => (float) $contract->rent_amount);
        $annualIncreaseTotal = $monthlyRevenue - $initialMonthlyRevenue;
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

            Stat::make('عقود تنتهي قريباً (30 يوم)', $endingSoon)
                ->description('تنبيه للمكتب لاتخاذ الإجراءات القانونية')
                ->descriptionIcon('heroicon-m-clock')
                ->color($endingSoon > 0 ? 'warning' : 'gray')
                ->url(route('filament.admin.resources.contracts.index', [
                    'tableFilters' => [
                        'ending_soon' => [
                            'isActive' => true,
                        ],
                    ],
                ])),

            Stat::make('زيادة سنوية قريباً (30 يوم)', $increaseDueSoonCount)
                ->description($increaseDueSoonCount > 0 ? 'عقود تستحق تطبيق الزيادة السنوية' : 'لا توجد عقود تستحق زيادة قريباً')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color($increaseDueSoonCount > 0 ? 'warning' : 'gray')
                ->url(route('filament.admin.resources.contracts.index', [
                    'tableFilters' => [
                        'increase_due_soon' => [
                            'isActive' => true,
                        ],
                    ],
                ])),

            Stat::make('العقود المنتهية', $expiredContracts)
                ->description('تحتاج لمتابعة التجديد أو إنهاء التعاقد')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($expiredContracts > 0 ? 'danger' : 'gray'),

            Stat::make('إجمالي الإيجارات الشهرية (الحالية)', number_format($monthlyRevenue, 0) . ' ج.م')
                ->description($annualIncreaseTotal > 0
                    ? 'شاملة الزيادات السنوية: +' . number_format($annualIncreaseTotal, 0) . ' ج.م (الأساسي: ' . number_format($initialMonthlyRevenue, 0) . ' ج.م)'
                    : 'الحصيلة الشهرية الفعلية للعقود السارية')
                ->descriptionIcon($annualIncreaseTotal > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-banknotes')
                ->color('success')
                ->chart([$initialMonthlyRevenue, ($initialMonthlyRevenue + $monthlyRevenue) / 2, $monthlyRevenue]),

            Stat::make('المشاريع والمباني', $totalProjects)
                ->description('مباني ومجمعات تجارية وإدارية')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('info'),
        ];
    }
}
