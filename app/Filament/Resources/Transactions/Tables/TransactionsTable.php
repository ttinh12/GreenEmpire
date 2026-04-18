<?php

namespace App\Filament\Resources\Transactions\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference_code')
                    ->label('Mã GD')
                    ->badge()
                    ->color('gray')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('transaction_date')
                    ->label('Ngày')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('type')
                    ->label('Loại')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state == 1 ? 'Thu' : 'Chi')
                    ->color(fn ($state) => $state == 1 ? 'success' : 'danger')
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Danh mục')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                TextColumn::make('amount')
                    ->label('Số tiền')
                    ->money('VND')
                    ->sortable()
                    ->alignEnd()
                    ->color(fn ($record) => $record->type == 1 ? 'success' : 'danger')
                    ->weight('bold'),

                TextColumn::make('department.name')
                    ->label('Phòng ban')
                    ->default('—')
                    ->toggleable(),

                TextColumn::make('description')
                    ->label('Mô tả')
                    ->limit(40)
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('approver.name')
                    ->label('Phê duyệt')
                    ->default('Chưa duyệt')
                    ->badge()
                    ->color(fn ($record) => $record->approved_by ? 'success' : 'warning')
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Loại')
                    ->options([1 => 'Thu nhập', 2 => 'Chi phí'])
                    ->placeholder('— Tất cả —'),

                SelectFilter::make('category_id')
                    ->label('Danh mục')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('department_id')
                    ->label('Phòng ban')
                    ->relationship('department', 'name')
                    ->searchable(),

                Filter::make('unapproved')
                    ->label('Chưa phê duyệt')
                    ->query(fn (Builder $q) => $q->whereNull('approved_by')),

                Filter::make('this_month')
                    ->label('Tháng này')
                    ->query(fn (Builder $q) => $q->whereMonth('transaction_date', now()->month)
                        ->whereYear('transaction_date', now()->year)),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),

                Action::make('approve')
                    ->label('Duyệt')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => !$record->approved_by)
                    ->requiresConfirmation()
                    ->modalHeading('Phê duyệt giao dịch?')
                    ->modalDescription('Xác nhận giao dịch này đã được kiểm tra và hợp lệ.')
                    ->action(fn ($record) => $record->update([
                        'approved_by' => auth()->id(),
                        'approved_at' => now(),
                    ])),

                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ])
            ->defaultSort('transaction_date', 'desc')
            ->striped()
            ->paginated([15, 30, 50]);
    }
}