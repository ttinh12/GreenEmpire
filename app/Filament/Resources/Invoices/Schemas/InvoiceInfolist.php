<?php

namespace App\Filament\Resources\Invoices\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class InvoiceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('code')
                    ->label('Mã hóa đơn'),

                TextEntry::make('contract_id')
                    ->label('Mã hợp đồng'),

                TextEntry::make('customer_id')
                    ->label('Khách hàng'),

                TextEntry::make('department_id')
                    ->label('Phòng ban')
                    ->placeholder('-'),

                TextEntry::make('issue_date')
                    ->label('Ngày lập')
                    ->date(),

                TextEntry::make('due_date')
                    ->label('Hạn thanh toán')
                    ->date(),

                TextEntry::make('subtotal')
                    ->label('Tạm tính'),

                TextEntry::make('vat_rate')
                    ->label('Thuế VAT (%)'),

                TextEntry::make('vat_amount')
                    ->label('Tiền thuế VAT'),

                TextEntry::make('total_amount')
                    ->label('Tổng tiền'),

                TextEntry::make('paid_amount')
                    ->label('Đã thanh toán'),

                TextEntry::make('remaining')
                    ->label('Còn lại')
                    ->placeholder('-'),

                TextEntry::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'draft' => 'Nháp',
                        'sent' => 'Đã gửi',
                        'paid' => 'Đã thanh toán',
                        'partial' => 'Thanh toán một phần',
                        'overdue' => 'Quá hạn',
                        'cancelled' => 'Đã hủy',
                        default => $state,
                    }),

                TextEntry::make('payment_method')
                    ->label('Phương thức thanh toán')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'bank_transfer' => 'Chuyển khoản',
                        'cash' => 'Tiền mặt',
                        'check' => 'Séc',
                        'other' => 'Khác',
                        default => $state,
                    })
                    ->placeholder('-'),

                TextEntry::make('bank_info')
                    ->label('Thông tin ngân hàng')
                    ->placeholder('-')
                    ->columnSpanFull(),

                TextEntry::make('notes')
                    ->label('Ghi chú')
                    ->placeholder('-')
                    ->columnSpanFull(),

                TextEntry::make('created_by')
                    ->label('Người tạo')
                    ->placeholder('-'),

                TextEntry::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime()
                    ->placeholder('-'),

                TextEntry::make('updated_at')
                    ->label('Cập nhật lần cuối')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
