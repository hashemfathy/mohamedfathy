<?php

namespace App\Filament\Resources\Contracts\Tables;

use App\Models\Contract;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ContractsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tenant_name')
                    ->label('اسم المستأجر')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('project.name')
                    ->label('المشروع / المبنى')
                    ->searchable()
                    ->sortable()
                    ->placeholder('بدون مشروع'),

                TextColumn::make('floor')
                    ->label('الدور')
                    ->alignCenter()
                    ->searchable(),

                TextColumn::make('unit_number')
                    ->label('رقم الوحدة')
                    ->alignCenter()
                    ->searchable(),

                TextColumn::make('status')
                    ->label('حالة العقد')
                    ->badge()
                    ->state(fn (Contract $record): string => $record->calculated_status)
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'expired' => 'danger',
                        'terminated' => 'gray',
                        default => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => 'ساري',
                        'expired' => 'منتهي',
                        'terminated' => 'مفسوخ',
                        default => $state,
                    })
                    ->sortable(),

                TextColumn::make('current_rent_amount')
                    ->label('الإيجار الحالي')
                    ->numeric(decimalPlaces: 2)
                    ->suffix(' ج.م')
                    ->description(function (Contract $record): ?string {
                        if ($record->is_annual_increase_due_soon) {
                            $nextRent = $record->next_rent_amount ? number_format($record->next_rent_amount, 0) . ' ج.م' : '';
                            return "⚠️ زيادة خلال {$record->days_until_next_annual_increase} يوم ({$nextRent})";
                        }
                        if ($record->has_rent_increase) {
                            return 'الأساسي: ' . number_format($record->rent_amount, 0) . ' ج.م (+' . number_format($record->rent_increase_difference, 0) . ')';
                        }
                        return null;
                    })
                    ->color(fn (Contract $record): ?string => 
                        $record->is_annual_increase_due_soon ? 'warning' : ($record->has_rent_increase ? 'success' : null)
                    )
                    ->sortable(query: fn (Builder $query, string $direction): Builder => $query->orderBy('rent_amount', $direction)),

                TextColumn::make('rent_amount')
                    ->label('الإيجار الأساسي')
                    ->numeric(decimalPlaces: 2)
                    ->suffix(' ج.م')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('start_date')
                    ->label('تاريخ البدء')
                    ->date('Y-m-d')
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label('تاريخ الإنهاء')
                    ->date('Y-m-d')
                    ->sortable(),

                TextColumn::make('next_annual_increase_date')
                    ->label('موعد الزيادة القادمة')
                    ->date('Y-m-d')
                    ->badge()
                    ->color(fn (Contract $record): string => $record->is_annual_increase_due_soon ? 'warning' : 'gray')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('duration')
                    ->label('المدة')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('insurance_amount')
                    ->label('التأمين')
                    ->numeric(decimalPlaces: 2)
                    ->suffix(' ج.م')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('annual_increase_rate')
                    ->label('الزيادة السنوية')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('service_fees')
                    ->label('مقابل الخدمات')
                    ->numeric(decimalPlaces: 2)
                    ->suffix(' ج.م')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('tenant_phone')
                    ->label('هاتف المستأجر')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('floor')
                    ->label('الدور في المبنى')
                    ->options([
                        'الدور الأرضي' => 'الدور الأرضي',
                        'الدور الأول' => 'الدور الأول',
                        'الدور الثاني' => 'الدور الثاني',
                        'الدور الثالث' => 'الدور الثالث',
                        'الدور الرابع' => 'الدور الرابع',
                        'الدور الخامس' => 'الدور الخامس',
                        'الدور السادس' => 'الدور السادس',
                    ]),

                SelectFilter::make('status')
                    ->label('حالة العقد')
                    ->options([
                        'active' => 'ساري',
                        'expired' => 'منتهي',
                        'terminated' => 'مفسوخ',
                    ]),

                SelectFilter::make('project_id')
                    ->label('المشروع')
                    ->relationship('project', 'name'),

                Filter::make('increase_due_soon')
                    ->label('عقود تستحق زيادة سنوية (خلال 30 يوم)')
                    ->query(fn (Builder $query): Builder => $query->increaseDueSoon(30)),

                Filter::make('ending_soon')
                    ->label('عقود تنتهي خلال 30 يوم')
                    ->query(fn (Builder $query): Builder => $query->whereBetween('end_date', [now()->toDateString(), now()->addDays(30)->toDateString()])),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->headerActions([
                \Filament\Actions\Action::make('print_report_table')
                    ->label('طباعة تقرير الحصر (PDF)')
                    ->icon('heroicon-o-printer')
                    ->color('primary')
                    ->url(route('contracts.report'), shouldOpenInNewTab: true),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
