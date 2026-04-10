<?php

namespace App\Filament\Resources\Invoices\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InvoicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Mã hóa đơn')
                    ->searchable(),

                TextColumn::make('contract_id')
                    ->label('Mã hợp đồng')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('customer_id')
                    ->label('Mã khách hàng')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('department_id')
                    ->label('Phòng ban')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('issue_date')
                    ->label('Ngày lập')
                    ->date()
                    ->sortable(),

                TextColumn::make('due_date')
                    ->label('Hạn thanh toán')
                    ->date()
                    ->sortable(),

                TextColumn::make('subtotal')
                    ->label('Tạm tính')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('vat_rate')
                    ->label('Thuế VAT (%)')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('vat_amount')
                    ->label('Tiền VAT')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('total_amount')
                    ->label('Tổng tiền')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('paid_amount')
                    ->label('Đã thanh toán')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('remaining')
                    ->label('Còn lại')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->colors([
                        'success' => 'paid',
                        'warning' => 'pending',
                        'danger' => 'unpaid',
                    ]),

                TextColumn::make('payment_method')
                    ->label('Phương thức thanh toán')
                    ->badge(),

                TextColumn::make('created_by')
                    ->label('Người tạo')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Cập nhật lần cuối')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Xem'),

                EditAction::make()
                    ->label('Sửa'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Xóa đã chọn'),
                ]),
            ]);
    }
}
