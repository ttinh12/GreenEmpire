<?php

namespace App\Filament\Resources\Payments\Tables;

use App\Models\Payment;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('payment_date')
                    ->label('Ngày TT')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('invoice.code')
                    ->label('Hóa đơn')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('invoice.customer.name')
                    ->label('Khách hàng')
                    ->searchable()
                    ->limit(30),

                TextColumn::make('amount')
                    ->label('Số tiền')
                    ->money('VND')
                    ->sortable()
                    ->alignEnd()
                    ->weight('bold')
                    ->color('success'),

                TextColumn::make('method')
                    ->label('Phương thức')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn ($state) => match ((int) $state) {
                        Payment::METHOD_BANK_TRANSFER => 'Chuyển khoản',
                        Payment::METHOD_CASH          => 'Tiền mặt',
                        Payment::METHOD_CHECK         => 'Séc',
                        default                       => 'Khác',
                    })
                    ->sortable(),

                TextColumn::make('reference')
                    ->label('Số tham chiếu')
                    ->default('—')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('recorder.name')
                    ->label('Người ghi nhận')
                    ->default('—')
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Ghi nhận lúc')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('method')
                    ->label('Phương thức')
                    ->options([
                        Payment::METHOD_BANK_TRANSFER => 'Chuyển khoản',
                        Payment::METHOD_CASH          => 'Tiền mặt',
                        Payment::METHOD_CHECK         => 'Séc',
                        Payment::METHOD_OTHER         => 'Khác',
                    ])
                    ->placeholder('— Tất cả —'),

                Filter::make('this_month')
                    ->label('Tháng này')
                    ->query(fn (Builder $q) => $q
                        ->whereMonth('payment_date', now()->month)
                        ->whereYear('payment_date', now()->year)),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ])
            ->defaultSort('payment_date', 'desc')
            ->striped()
            ->paginated([15, 30, 50]);
    }
}