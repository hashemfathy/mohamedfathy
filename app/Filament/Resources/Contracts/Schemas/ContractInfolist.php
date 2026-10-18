<?php

namespace App\Filament\Resources\Contracts\Schemas;

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
                    ->numeric(),
                TextEntry::make('insurance_amount')
                    ->numeric(),
                TextEntry::make('annual_increase_start_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('annual_increase_rate')
                    ->placeholder('-'),
                TextEntry::make('service_fees')
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
