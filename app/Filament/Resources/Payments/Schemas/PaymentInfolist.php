<?php

namespace App\Filament\Resources\Payments\Schemas;

use App\Models\Payment;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PaymentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Chi tiết thanh toán')
                ->icon('heroicon-o-banknotes')
                ->columns(2)
                ->schema([
                    TextEntry::make('invoice.code')
                        ->label('Hóa đơn')
                        ->badge()
                        ->color('info')
                        ->icon('heroicon-o-receipt-percent')
                        ->columnSpanFull(),

                    TextEntry::make('amount')
                        ->label('Số tiền')
                        ->money('VND')
                        ->size('xl')
                        ->weight('bold')
                        ->color('success'),

                    TextEntry::make('payment_date')
                        ->label('Ngày thanh toán')
                        ->date('d/m/Y')
                        ->icon('heroicon-o-calendar'),

                    TextEntry::make('method')
                        ->label('Phương thức')
                        ->badge()
                        ->color('gray')
                        ->formatStateUsing(fn ($state) => match ((int) $state) {
                            Payment::METHOD_BANK_TRANSFER => 'Chuyển khoản',
                            Payment::METHOD_CASH          => 'Tiền mặt',
                            Payment::METHOD_CHECK         => 'Séc',
                            default                       => 'Khác',
                        }),

                    TextEntry::make('reference')
                        ->label('Số tham chiếu')
                        ->default('—')
                        ->copyable()
                        ->icon('heroicon-o-hashtag'),

                    TextEntry::make('notes')
                        ->label('Ghi chú')
                        ->default('—')
                        ->columnSpanFull(),

                    TextEntry::make('attachment')
                        ->label('Chứng từ đính kèm')
                        ->default('Không có'),

                    TextEntry::make('recorder.name')
                        ->label('Người ghi nhận')
                        ->default('—')
                        ->icon('heroicon-o-user'),

                    TextEntry::make('created_at')
                        ->label('Thời gian ghi nhận')
                        ->dateTime('d/m/Y H:i')
                        ->color('gray'),
                ]),

            Section::make('Thông tin hóa đơn liên quan')
                ->icon('heroicon-o-document-text')
                ->columns(2)
                ->schema([
                    TextEntry::make('invoice.customer.name')
                        ->label('Khách hàng')
                        ->default('—')
                        ->icon('heroicon-o-building-office'),

                    TextEntry::make('invoice.total_amount')
                        ->label('Tổng hóa đơn')
                        ->money('VND'),

                    TextEntry::make('invoice.paid_amount')
                        ->label('Đã thanh toán')
                        ->money('VND')
                        ->color('success'),

                    TextEntry::make('invoice.status')
                        ->label('Trạng thái hóa đơn')
                        ->badge(),
                ]),
        ]);
    }
}