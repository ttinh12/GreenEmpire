<?php

namespace App\Filament\Resources\Invoices\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Grouping\Group;
use App\Enums\InvoiceStatus;
use App\Enums\PaymentMethod;


class InvoicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Mã hóa đơn')
                    ->searchable(),

                TextColumn::make('contract.code')
                    ->label('Mã hợp đồng')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('customer.name')
                    ->label('Mã khách hàng')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('department.name')
                    ->label('Phòng ban')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('issue_date')
                    ->label('Ngày lập')
                    ->formatStateUsing(fn($state) => $state ? date('d/m/Y', strtotime($state)) : null)
                    ->sortable(),

                TextColumn::make('due_date')
                    ->label('Hạn thanh toán')
                    ->formatStateUsing(fn($state) => $state ? date('d/m/Y', strtotime($state)) : null)
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
                    ->summarize(Sum::make()->prefix('Total volume: '))


                    ->sortable(),

                TextColumn::make('remaining')
                    ->label('Còn lại')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('status')
    ->label('Trạng thái')
    ->badge()
    ->formatStateUsing(fn (InvoiceStatus $state) => $state->label())
    ->color(fn (InvoiceStatus $state) => $state->color()),


                TextColumn::make('payment_method')
    ->label('Phương thức thanh toán')
    ->badge()
    ->formatStateUsing(fn (PaymentMethod $state) => $state->label()),


                TextColumn::make('creator.name')
    ->label('Người tạo')
    ->searchable()
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
            ->groups([
                Group::make('department.name')
                    ->collapsible(),
                Group::make('customer.name')
                    ->collapsible(),
            ])
            // ->defaultGroup('department.name')

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
