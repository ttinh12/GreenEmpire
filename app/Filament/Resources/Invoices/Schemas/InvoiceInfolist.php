<?php

namespace App\Filament\Resources\Invoices\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InvoiceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            // ── SECTION 1: Thông tin chính ─────────────────────
            Section::make('Thông tin hóa đơn')
                ->icon('heroicon-o-document-text')
                ->columns(2)
                ->schema([

                    TextEntry::make('code')
                        ->label('Mã hóa đơn')
                        ->size('xl')
                        ->weight('bold')
                        ->color('primary')
                        ->columnSpanFull(),

                    TextEntry::make('customer.name')
                        ->label('Khách hàng')
                        ->icon('heroicon-o-user'),

                    TextEntry::make('contract.code')
                        ->label('Hợp đồng'),

                    TextEntry::make('department.name')
                        ->label('Phòng ban')
                        ->default('-'),

                    TextEntry::make('issue_date')
                        ->label('Ngày lập')
                        ->date(),

                    TextEntry::make('due_date')
                        ->label('Hạn thanh toán')
                        ->date(),
                ]),

            // ── SECTION 2: Thanh toán ──────────────────────────
            Section::make('Thanh toán')
                ->icon('heroicon-o-currency-dollar')
                ->columns(2)
                ->schema([

                    TextEntry::make('subtotal')
                        ->label('Tạm tính')
                        ->money('VND'),

                    TextEntry::make('vat_amount')
                        ->label('VAT')
                        ->money('VND'),

                    TextEntry::make('total_amount')
                        ->label('Tổng tiền')
                        ->money('VND')
                        ->color('success')
                        ->weight('bold'),

                    TextEntry::make('paid_amount')
                        ->label('Đã thanh toán')
                        ->money('VND'),

                    TextEntry::make('remaining')
                        ->label('Còn lại')
                        ->money('VND')
                        ->color(fn($state) => $state > 0 ? 'danger' : 'success'),
                ]),

            // ── SECTION 3: Trạng thái ─────────────────────────
            Section::make('Trạng thái')
                ->icon('heroicon-o-check-circle')
                ->schema([

                    TextEntry::make('status')
                        ->label('Trạng thái')
                        ->badge()
                        ->color(fn($state) => match ($state) {
                            1 => 'success',
                            2 => 'warning',
                            3 => 'danger',
                            default => 'gray',
                        })
                        ->formatStateUsing(fn($state) => match ($state) {
                            1 => 'Đã thanh toán',
                            2 => 'Chờ thanh toán',
                            3 => 'Chưa thanh toán',
                            default => $state,
                        }),

                    TextEntry::make('payment_method')
                        ->label('Phương thức')
                        ->badge()
                        ->formatStateUsing(fn($state) => match ($state) {
                            1 => 'Tiền mặt',
                            2 => 'Chuyển khoản',
                            3 => 'Ngân hàng',
                            default => '-',
                        }),
                ]),

            // ── SECTION 4: Ghi chú ─────────────────────────────
            Section::make('Ghi chú')
                ->icon('heroicon-o-document')
                ->collapsible()
                ->schema([

                    TextEntry::make('bank_info')
                        ->label('Thông tin ngân hàng')
                        ->default('-')
                        ->columnSpanFull(),

                    TextEntry::make('notes')
                        ->label('Ghi chú')
                        ->default('-')
                        ->columnSpanFull(),
                ]),
        ]);
    }
}