<?php

namespace App\Filament\Resources\Customers\Tables;

use App\Enums\CustomerStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('code')
                    ->label('Mã khách hàng')
                    ->searchable(),

                TextColumn::make('name')
                    ->label('Tên khách hàng')
                    ->searchable(),

                TextColumn::make('type')
                    ->label('Loại khách hàng')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ((int) $state) {
                        1 => 'Công ty',
                        2 => 'Trường học',
                        3 => 'Cơ quan nhà nước',
                        4 => 'Cá nhân',
                        default => 'Không xác định',
                    }),

                TextColumn::make('province')
                    ->label('Tỉnh / Thành phố')
                    ->searchable(),

                TextColumn::make('tax_code')
                    ->label('Mã số thuế')
                    ->searchable(),

                TextColumn::make('website')
                    ->label('Website')
                    ->searchable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                TextColumn::make('phone')
                    ->label('Số điện thoại')
                    ->searchable(),

                TextColumn::make('fax')
                    ->label('Số fax')
                    ->formatStateUsing(fn ($state) => $state ?? '---')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('department.name')
                    ->label('Phòng ban')
                    ->searchable(),

                TextColumn::make('accountManager.name')
                    ->label('Nhân viên phụ trách')
                    ->searchable(),

                TextColumn::make('source')
                    ->label('Nguồn khách hàng')
                    ->searchable(),

                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->formatStateUsing(fn ($state) =>
                        CustomerStatus::tryFrom($state)?->label() ?? 'Không xác định'
                    ),

                TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Cập nhật')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()->label('Sửa'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('Xóa'),
                ]),
            ]);
    }
}
