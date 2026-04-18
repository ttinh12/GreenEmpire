<?php

namespace App\Filament\Resources\Invoices\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            // ── SECTION 1: Thông tin hóa đơn ─────────────────────
            Section::make('Thông tin hóa đơn')
                ->icon('heroicon-o-document-text')
                ->columns(2)
                ->schema([

                    TextInput::make('code')
                        ->label('Mã hóa đơn')
                        ->required(),

                    Select::make('contract_id')
                        ->label('Hợp đồng')
                        ->relationship('contract', 'code')
                        ->searchable()
                        ->required(),

                    Select::make('customer_id')
                        ->label('Khách hàng')
                        ->relationship('customer', 'name')
                        ->searchable()
                        ->required(),

                    Select::make('department_id')
                        ->label('Phòng ban')
                        ->relationship('department', 'name')
                        ->searchable(),

                    DatePicker::make('issue_date')
                        ->label('Ngày lập')
                        ->required(),

                    DatePicker::make('due_date')
                        ->label('Hạn thanh toán')
                        ->required(),
                ]),

            // ── SECTION 2: Thanh toán ────────────────────────────
            Section::make('Thông tin thanh toán')
                ->icon('heroicon-o-currency-dollar')
                ->columns(2)
                ->schema([

                    TextInput::make('subtotal')
                        ->label('Tạm tính')
                        ->numeric()
                        ->prefix('₫')
                        ->default(0),

                    TextInput::make('vat_rate')
                        ->label('VAT (%)')
                        ->numeric()
                        ->default(10),

                    TextInput::make('vat_amount')
                        ->label('Tiền VAT')
                        ->numeric()
                        ->prefix('₫')
                        ->default(0),

                    TextInput::make('total_amount')
                        ->label('Tổng tiền')
                        ->numeric()
                        ->prefix('₫')
                        ->default(0),

                    TextInput::make('paid_amount')
                        ->label('Đã thanh toán')
                        ->numeric()
                        ->prefix('₫')
                        ->default(0),

                    TextInput::make('remaining')
                        ->label('Còn lại')
                        ->numeric()
                        ->prefix('₫'),
                ]),

            // ── SECTION 3: Trạng thái ───────────────────────────
            Section::make('Trạng thái & Thanh toán')
                ->icon('heroicon-o-check-circle')
                ->columns(2)
                ->schema([

                    Select::make('status')
                        ->label('Trạng thái')
                        ->options([
                            1 => 'Đã thanh toán',
                            2 => 'Chờ thanh toán',
                            3 => 'Chưa thanh toán',
                        ])
                        ->required(),

                    Select::make('payment_method')
                        ->label('Phương thức')
                        ->options([
                            1 => 'Tiền mặt',
                            2 => 'Chuyển khoản',
                            3 => 'Ngân hàng',
                        ]),
                ]),

            // ── SECTION 4: Ghi chú ──────────────────────────────
            Section::make('Thông tin bổ sung')
                ->icon('heroicon-o-pencil-square')
                ->schema([

                    Textarea::make('bank_info')
                        ->label('Thông tin ngân hàng')
                        ->columnSpanFull(),

                    Textarea::make('notes')
                        ->label('Ghi chú')
                        ->columnSpanFull(),
                ]),
        ]);
    }
}