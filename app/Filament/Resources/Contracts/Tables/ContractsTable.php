<?php

namespace App\Filament\Resources\Contracts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Table;

class ContractsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                ->label("Mã hợp đồng")
                    ->searchable(),
                TextColumn::make('customer.name')
                    ->label("Khách hàng")
                    ->searchable(),
                TextColumn::make('department.name')
                    ->label("Phòng ban")
                    ->searchable(),
                TextColumn::make('title')
                    ->label("Tiêu đề")
                    ->searchable(),
                TextColumn::make('value')
                    ->label("Giá trị hợp đồng")
                    ->numeric()
                    ->sortable(),
                TextColumn::make('vat_rate')
                    ->label("Thuế VAT (%)")
                    ->numeric()
                    ->sortable(),
                TextColumn::make('vat_amount')
                    ->label("Tiền thuế VAT")
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_value')
                    ->label("Tổng giá trị")
                    ->numeric()
                    ->sortable(),
                TextColumn::make('start_date')
                    ->label("Ngày bắt đầu")
                    ->date()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label("Ngày kết thúc")
                    ->date()
                    ->sortable(),
                TextColumn::make('signed_date')
                    ->label("Ngày ký kết")
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->label("Trạng thái")
                    ->numeric()
                    ->sortable(),
                TextColumn::make('warranty_months')
                    ->label("Thời gian bảo hành (tháng)")
                    ->numeric()
                    ->sortable(),
                TextColumn::make('file_url')
                    ->label("URL tệp hợp đồng")
                    ->searchable(),
                TextColumn::make('created_by')
                    ->label("Người tạo")
                    ->numeric()
                    ->sortable(),
                TextColumn::make('updated_by')
                    ->label("Người cập nhật")
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label("Ngày tạo")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label("Ngày cập nhật")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ], position: RecordActionsPosition::BeforeCells)
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
