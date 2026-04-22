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
                TextEntry::make('code')
                    ->label("Mã hợp đồng"),
                TextEntry::make('customer.name')
                    ->label('Khách hàng'),
                TextEntry::make('department.name')
                    ->label('Phòng ban')
                    ->placeholder('-'),
                TextEntry::make('title')
                    ->label("Tiêu đề"),
                TextEntry::make('description')
                    ->label("Mô tả")
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('value')
                    ->label("Giá trị hợp đồng")
                    ->numeric(),
                TextEntry::make('vat_rate')
                    ->label("Thuế VAT (%)")
                    ->numeric(),
                TextEntry::make('vat_amount')
                    ->label("Tiền thuế VAT")
                    ->numeric(),
                TextEntry::make('total_value')
                    ->label("Tổng giá trị")
                    ->numeric(),
                TextEntry::make('start_date')
                    ->label("Ngày bắt đầu")
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('end_date')
                    ->label("Ngày kết thúc")
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('signed_date')
                    ->label("Ngày ký kết")
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->label("Trạng thái")
                    ->numeric(),
                TextEntry::make('payment_terms')
                    ->label("Điều khoản thanh toán")
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('warranty_months')
                    ->label("Thời gian bảo hành (tháng)")
                    ->numeric(),
                TextEntry::make('file_url')
                    ->label("URL tệp hợp đồng")

                    ->placeholder('-'),
                TextEntry::make('created_by')
                    ->label("Người tạo")
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('updated_by')
                    ->label("Người cập nhật")
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->label("Ngày tạo")
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label("Ngày cập nhật")
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
