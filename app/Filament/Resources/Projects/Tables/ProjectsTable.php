<?php

namespace App\Filament\Resources\Projects\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('اسم المشروع / المبنى')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('code')
                    ->label('كود المشروع')
                    ->searchable(),
                TextColumn::make('address')
                    ->label('العنوان / الموقع')
                    ->searchable(),
                TextColumn::make('contracts_count')
                    ->label('عدد العقود')
                    ->counts('contracts')
                    ->badge()
                    ->color('primary')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime('Y-m-d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
