<?php

namespace App\Filament\Resources\Contracts\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContractForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات العقار والوحدة')
                    ->description('ربط العقد بالمشروع ورقم الدور والوحدة')
                    ->schema([
                        Select::make('project_id')
                            ->label('المشروع / المبنى')
                            ->relationship('project', 'name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('اسم المشروع')
                                    ->required(),
                                TextInput::make('address')
                                    ->label('العنوان'),
                            ]),
                        TextInput::make('floor')
                            ->label('رقم الدور')
                            ->placeholder('مثال: الدور الأول / الأرضي')
                            ->required(),
                        TextInput::make('unit_number')
                            ->label('رقم الوحدة')
                            ->placeholder('مثال: شقة 4 / محل 2')
                            ->required(),
                    ])->columns(3),

                Section::make('بيانات المستأجر')
                    ->description('المعلومات الشخصية للمستأجر والاتصال')
                    ->schema([
                        TextInput::make('tenant_name')
                            ->label('اسم المستأجر')
                            ->required(),
                        TextInput::make('tenant_phone')
                            ->label('رقم الهاتف')
                            ->tel(),
                        TextInput::make('tenant_national_id')
                            ->label('الرقم القومي / رقم الهوية'),
                    ])->columns(3),

                Section::make('المدة والتواريخ وحالة العقد')
                    ->schema([
                        TextInput::make('duration')
                            ->label('مدة العقد')
                            ->placeholder('مثال: سنة / سنتين'),
                        DatePicker::make('start_date')
                            ->label('تاريخ بدء العقد'),
                        DatePicker::make('end_date')
                            ->label('تاريخ إنهاء العقد'),
                        Select::make('status')
                            ->label('حالة العقد')
                            ->options([
                                'active' => 'ساري',
                                'expired' => 'منتهي',
                                'terminated' => 'مفسوخ',
                            ])
                            ->default('active')
                            ->required(),
                    ])->columns(4),

                Section::make('البيانات المالية والزيادة السنوية')
                    ->schema([
                        TextInput::make('rent_amount')
                            ->label('القيمة الإيجارية')
                            ->suffix('ج.م')
                            ->required()
                            ->numeric()
                            ->default(0.0),
                        TextInput::make('insurance_amount')
                            ->label('مبلغ التأمين')
                            ->suffix('ج.م')
                            ->required()
                            ->numeric()
                            ->default(0.0),
                        TextInput::make('service_fees')
                            ->label('مقابل الخدمات')
                            ->suffix('ج.م')
                            ->required()
                            ->numeric()
                            ->default(0.0),
                        TextInput::make('annual_increase_rate')
                            ->label('الزيادة السنوية')
                            ->placeholder('مثال: 10% سنوياً'),
                        DatePicker::make('annual_increase_start_date')
                            ->label('تاريخ بدء الزيادة السنوية'),
                    ])->columns(3),

                Section::make('المرفقات والملاحظات')
                    ->schema([
                        FileUpload::make('file_path')
                            ->label('ملف العقد الأصلي (Word أو PDF)')
                            ->directory('contracts')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            ])
                            ->columnSpanFull(),
                        Textarea::make('notes')
                            ->label('ملاحظات إضافية وشروط خاصة')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
