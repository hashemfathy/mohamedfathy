<?php

namespace App\Filament\Resources\Contracts\Pages;

use App\Filament\Resources\Contracts\ContractResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContracts extends ListRecords
{
    protected static string $resource = ContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('print_report')
                ->label('تقرير الحصر الشامل (PDF)')
                ->icon('heroicon-o-printer')
                ->color('success')
                ->url(route('contracts.report'), shouldOpenInNewTab: true),
            CreateAction::make(),
        ];
    }
}
