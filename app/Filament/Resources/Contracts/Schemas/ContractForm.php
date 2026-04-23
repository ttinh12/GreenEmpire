<?php

namespace App\Filament\Resources\Contracts\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContractForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            // ── SECTION 1: Thông tin cơ bản ──────────────────────────────
            Section::make('Thông tin hợp đồng')
                ->description('Thông tin chính của hợp đồng')
                ->icon('heroicon-o-document-text')
                ->schema([
                    TextInput::make('code')
                        ->label("Mã hợp đồng")
                        ->required(),

                    TextInput::make('title')
                        ->label("Tiêu đề")
                        ->required(),

                    Select::make('customer_id')
                        ->label("Khách hàng")
                        ->relationship('customer', 'name')
                        ->required(),

                    Select::make('department_id')
                        ->label("Phòng ban")
                        ->relationship('department', 'name'),

                    Textarea::make('description')
                        ->label("Mô tả")
                        ->columnSpanFull(),
                ]),

            // ── SECTION 2: Giá trị hợp đồng ──────────────────────────────
            Section::make('Giá trị hợp đồng')
                ->description('Thông tin tiền và thuế')
                ->icon('heroicon-o-banknotes')
                ->columns(2)
                ->schema([
                    TextInput::make('value')
                        ->label("Giá trị hợp đồng")
                        ->numeric()
                        ->required()
                        ->default(0),

                    TextInput::make('vat_rate')
                        ->label("VAT (%)")
                        ->numeric()
                        ->default(10),

                    TextInput::make('vat_amount')
                        ->label("Tiền VAT")
                        ->numeric()
                        ->default(0),

                    TextInput::make('total_value')
                        ->label("Tổng giá trị")
                        ->numeric()
                        ->required(),
                ]),

            // ── SECTION 3: Thời gian ─────────────────────────────────────
            Section::make('Thời gian hợp đồng')
                ->description('Các mốc thời gian quan trọng')
                ->icon('heroicon-o-calendar-days')
                ->columns(3)
                ->schema([
                    DatePicker::make('start_date')
                        ->label("Ngày bắt đầu"),

                    DatePicker::make('end_date')
                        ->label("Ngày kết thúc"),

                    DatePicker::make('signed_date')
                        ->label("Ngày ký"),
                ]),

            // ── SECTION 4: Thanh toán & bảo hành ─────────────────────────
            Section::make('Thanh toán & bảo hành')
                ->icon('heroicon-o-credit-card')
                ->schema([
                    Textarea::make('payment_terms')
                        ->label("Điều khoản thanh toán")
                        ->placeholder("Thanh toán theo thỏa thuận")
                        ->columnSpanFull(),

                    TextInput::make('warranty_months')
                        ->label("Bảo hành (tháng)")
                        ->numeric()
                        ->default(0),
                ]),

            // ── SECTION 5: Thông tin khác ────────────────────────────────
            Section::make('Thông tin hệ thống')
                ->icon('heroicon-o-cog-6-tooth')
                ->columns(2)
                ->collapsed()
                ->schema([
                    TextInput::make('file_url')
                        ->label("File hợp đồng")
                        ->url(),

                    TextInput::make('status')
                        ->label("Trạng thái")
                        ->numeric()
                        ->default(1),

                    TextInput::make('created_by')
                        ->label("Người tạo")
                        ->numeric(),

                    TextInput::make('updated_by')
                        ->label("Người cập nhật")
                        ->numeric(),
                ]),
            // ── SECTION 6: Phân công Task ────────────────────────────────
            Section::make('Phân công công việc')
                ->description('Chọn người thực hiện cho các task tự động')
                ->icon('heroicon-o-user-group')
                ->schema([
                    Select::make('task_assignee_id')
                        ->label('Người thực hiện tasks')
                        ->options(\App\Models\User::where('is_active', 1)->pluck('name', 'id'))
                        ->searchable()
                        ->nullable()
                        ->helperText('Người này sẽ được assign vào 5 tasks tự động khi tạo hợp đồng'),
                ]),
        ]);
    }
}
