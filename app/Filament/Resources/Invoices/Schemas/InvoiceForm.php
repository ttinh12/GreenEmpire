<?php

namespace App\Filament\Resources\Invoices\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->label('Mã hóa đơn')
                    ->required(),

                TextInput::make('contract_id')
                    ->label('Mã hợp đồng')
                    ->required()
                    ->numeric(),

                TextInput::make('customer_id')
                    ->label('Khách hàng')
                    ->required()
                    ->numeric(),

                TextInput::make('department_id')
                    ->label('Phòng ban')
                    ->numeric(),

                DatePicker::make('issue_date')
                    ->label('Ngày lập hóa đơn')
                    ->required(),

                DatePicker::make('due_date')
                    ->label('Hạn thanh toán')
                    ->required(),

                TextInput::make('subtotal')
                    ->label('Tạm tính')
                    ->required()
                    ->numeric()
                    ->default(0.0),

                TextInput::make('vat_rate')
                    ->label('Thuế VAT (%)')
                    ->required()
                    ->numeric()
                    ->default(10.0),

                TextInput::make('vat_amount')
                    ->label('Tiền thuế VAT')
                    ->required()
                    ->numeric()
                    ->default(0.0),

                TextInput::make('total_amount')
                    ->label('Tổng tiền')
                    ->required()
                    ->numeric()
                    ->default(0.0),

                TextInput::make('paid_amount')
                    ->label('Đã thanh toán')
                    ->required()
                    ->numeric()
                    ->default(0.0),

                TextInput::make('remaining')
                    ->label('Còn lại')
                    ->numeric(),

                Select::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'draft' => 'Nháp',
                        'sent' => 'Đã gửi',
                        'paid' => 'Đã thanh toán',
                        'partial' => 'Thanh toán một phần',
                        'overdue' => 'Quá hạn',
                        'cancelled' => 'Đã hủy',
                    ])
                    ->default('draft')
                    ->required(),

                Select::make('payment_method')
                    ->label('Phương thức thanh toán')
                    ->options([
                        'bank_transfer' => 'Chuyển khoản ngân hàng',
                        'cash' => 'Tiền mặt',
                        'check' => 'Séc',
                        'other' => 'Khác',
                    ]),

                Textarea::make('bank_info')
                    ->label('Thông tin ngân hàng')
                    ->columnSpanFull(),

                Textarea::make('notes')
                    ->label('Ghi chú')
                    ->columnSpanFull(),

                TextInput::make('created_by')
                    ->label('Người tạo')
                    ->numeric(),
            ]);
    }
}
