<?php

namespace App\Filament\Resources\Tickets\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\User;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;

class TicketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('content')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),
                TextColumn::make('user.name')
                    ->label('Khách hàng')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('assignee.name')
                    ->label('Nhân viên xử lý')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Chưa được giao'),
                TextColumn::make('priority')
                    ->label('Độ ưu tiên')
                    ->badge()
                    ->color(fn($state): string => is_object($state)
                        ? $state->getColor()
                        : TicketPriority::from($state)->getColor())
                    ->formatStateUsing(fn($state): string => is_object($state)
                        ? $state->getLabel()
                        : TicketPriority::from($state)->getLabel())
                    ->sortable(),
                SelectColumn::make('status')
                    ->label('Trạng thái')
                    ->options(TicketStatus::class) // Tự động lấy từ Enum
                    ->selectablePlaceholder(false)
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Ngày cập nhật')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('assign_id')
                    ->label('Nhân viên xử lý')
                    ->options(User::all()->pluck('name', 'id'))
                    ->placeholder('Tất cả nhân viên'),
                SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options([
                        TicketStatus::ACTIVE->value => TicketStatus::ACTIVE->getLabel(),
                        TicketStatus::INACTIVE->value => TicketStatus::INACTIVE->getLabel(),
                        TicketStatus::BANNED->value => TicketStatus::BANNED->getLabel(),
                    ]),
                SelectFilter::make('priority')
                    ->label('Độ ưu tiên')
                    ->options([
                        TicketPriority::ACTIVE->value => TicketPriority::ACTIVE->getLabel(),
                        TicketPriority::INACTIVE->value => TicketPriority::INACTIVE->getLabel(),
                        TicketPriority::BANED->value => TicketPriority::BANED->getLabel(),
                    ]),
            ])
            ->actions([
                Action::make('take_assignment')
                    ->label('Nhận xử lý')
                    ->icon('heroicon-o-hand-raised')
                    ->color('success')
                    ->visible(fn($record) => $record->assign_id === null)
                    ->action(function ($record) {
                        $record->update([
                            'assign_id' => auth()->id(),
                            'status' => TicketStatus::INACTIVE->value,
                        ]);
                    }),
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
