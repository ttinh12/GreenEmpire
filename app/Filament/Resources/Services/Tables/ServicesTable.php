<?php

namespace App\Filament\Resources\Services\Tables;

use App\Models\Service;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                // Ảnh minh họa
                ImageColumn::make('image_url')
                    ->label('Ảnh')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(
                        'https://ui-avatars.com/api/?name=S&background=e5e7eb&color=6b7280&size=40'
                    ),

                // Tên + slug hiển thị phụ bên dưới
                TextColumn::make('name')
                    ->label('Tên dịch vụ')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record) => $record->slug)
                    ->limit(45),

                // Giá niêm yết
                TextColumn::make('base_price')
                    ->label('Giá niêm yết')
                    ->formatStateUsing(
                        fn ($state) => $state > 0
                            ? number_format((float) $state, 0, ',', '.') . ' ₫'
                            : 'Thỏa thuận'
                    )
                    ->color(fn ($state) => $state > 0 ? 'success' : 'gray')
                    ->sortable()
                    ->alignEnd(),

                // Đơn vị tính
                TextColumn::make('unit')
                    ->label('Đơn vị')
                    ->badge()
                    ->color('info')
                    ->searchable(),

                // Trạng thái
                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->formatStateUsing(fn ($state) => Service::statusLabels()[$state] ?? $state)
                    ->badge()
                    ->color(fn ($state) => (int) $state === Service::STATUS_ACTIVE ? 'success' : 'danger')
                    ->sortable(),

                // Người tạo
                TextColumn::make('creator.name')
                    ->label('Người tạo')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                // Ngày tạo (ẩn mặc định)
                TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options(Service::statusLabels())
                    ->placeholder('— Tất cả —'),
            ])

            ->recordActions([
                ViewAction::make()
                    ->label('Xem'),

                EditAction::make()
                    ->label('Sửa'),

                Action::make('activate')
                    ->label('Kích hoạt')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => (int) $record->status === Service::STATUS_INACTIVE)
                    ->requiresConfirmation()
                    ->modalHeading('Kích hoạt dịch vụ?')
                    ->modalDescription('Dịch vụ sẽ được hiển thị và sử dụng trở lại.')
                    ->modalSubmitActionLabel('Kích hoạt')
                    ->action(fn ($record) => $record->update(['status' => Service::STATUS_ACTIVE])),

                Action::make('deactivate')
                    ->label('Tạm ngưng')
                    ->icon('heroicon-o-x-circle')
                    ->color('warning')
                    ->visible(fn ($record) => (int) $record->status === Service::STATUS_ACTIVE)
                    ->requiresConfirmation()
                    ->modalHeading('Tạm ngưng dịch vụ?')
                    ->modalDescription('Dịch vụ sẽ không thể sử dụng cho đến khi được kích hoạt lại.')
                    ->modalSubmitActionLabel('Tạm ngưng')
                    ->action(fn ($record) => $record->update(['status' => Service::STATUS_INACTIVE])),

                DeleteAction::make()
                    ->label('Xóa'),
            ], position: RecordActionsPosition::BeforeCells)

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Xóa đã chọn'),
                ]),
            ])

            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50]);
    }
}