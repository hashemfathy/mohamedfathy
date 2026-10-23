<?php

namespace App\Filament\Resources\Contracts\Schemas;

use App\Models\Contract;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ContractInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('project.name')
                    ->label('Project')
                    ->placeholder('-'),
                TextEntry::make('floor'),
                TextEntry::make('unit_number'),
                TextEntry::make('tenant_name'),
                TextEntry::make('tenant_phone')
                    ->placeholder('-'),
                TextEntry::make('tenant_national_id')
                    ->placeholder('-'),
                TextEntry::make('duration')
                    ->placeholder('-'),
                TextEntry::make('start_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('end_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('rent_amount')
                    ->label('القيمة الإيجارية الابتدائية')
                    ->suffix(' ج.م')
                    ->numeric(),
                TextEntry::make('current_rent_amount')
                    ->label('القيمة الإيجارية الحالية (شاملة الزيادة)')
                    ->suffix(' ج.م')
                    ->color('success')
                    ->weight('bold')
                    ->numeric(),
                TextEntry::make('insurance_amount')
                    ->label('مبلغ التأمين')
                    ->suffix(' ج.م')
                    ->numeric(),
                TextEntry::make('annual_increase_start_date')
                    ->label('تاريخ بدء الزيادة السنوية')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('annual_increase_rate')
                    ->label('الزيادة السنوية')
                    ->placeholder('-'),
                TextEntry::make('next_annual_increase_date')
                    ->label('موعد الزيادة السنوية القادمة')
                    ->date()
                    ->badge()
                    ->color(fn (Contract $record): string => $record->is_annual_increase_due_soon ? 'warning' : 'gray')
                    ->placeholder('لا توجد زيادة قادمة'),
                TextEntry::make('next_rent_amount')
                    ->label('الإيجار المتوقع بعد الزيادة')
                    ->suffix(' ج.م')
                    ->color('warning')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('service_fees')
                    ->label('مقابل الخدمات')
                    ->suffix(' ج.م')
                    ->numeric(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('file_path')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
