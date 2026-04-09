<?php

namespace App\Filament\Resources\Services\Tables;

use App\Models\Service;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_url')
                    ->label('Ảnh')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('name')
                    ->label('Tên dịch vụ')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(40),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->formatStateUsing(fn($state) => Service::statusLabels()[$state] ?? $state)
                    ->badge()
                    ->colors([
                        'danger' => Service::STATUS_INACTIVE,
                        'success' => Service::STATUS_ACTIVE,
                    ])
                    ->sortable(),

                TextColumn::make('base_price')
                    ->label('Giá niêm yết')
                    ->formatStateUsing(fn($state) => $state !== null ? number_format((float) $state, 0, ',', '.') . ' VNĐ' : '-')
                    ->sortable(),

                TextColumn::make('unit')
                    ->label('Đơn vị')
                    ->searchable(),

                TextColumn::make('creator.name')
                    ->label('Người tạo')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options(Service::statusLabels()),
            ])
            ->actions([
                ViewAction::make(),
                Action::make('activate')
                    ->label('Kích hoạt')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn($record) => (int) $record->status === Service::STATUS_INACTIVE)
                    ->action(fn($record) => $record->update(['status' => Service::STATUS_ACTIVE])),
                Action::make('deactivate')
                    ->label('Tạm ngưng')
                    ->icon('heroicon-o-x-circle')
                    ->color('warning')
                    ->visible(fn($record) => (int) $record->status === Service::STATUS_ACTIVE)
                    ->requiresConfirmation()
                    ->action(fn($record) => $record->update(['status' => Service::STATUS_INACTIVE])),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped();
    }
}
