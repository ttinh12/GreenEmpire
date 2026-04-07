<?php

namespace App\Filament\Resources\Tasks\Tables;

use App\Models\Task;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TasksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Tiêu đề')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(50),

                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->formatStateUsing(fn($state) => Task::statusLabels()[$state] ?? $state)
                    ->color(fn($state) => match((int)$state) {
                        Task::STATUS_TODO        => 'gray',
                        Task::STATUS_IN_PROGRESS => 'warning',
                        Task::STATUS_REVIEW      => 'info',
                        Task::STATUS_DONE        => 'success',
                        default                  => 'gray',
                    }),

                TextColumn::make('priority')
                    ->label('Ưu tiên')
                    ->badge()
                    ->formatStateUsing(fn($state) => Task::priorityLabels()[$state] ?? $state)
                    ->color(fn($state) => match((int)$state) {
                        Task::PRIORITY_LOW    => 'gray',
                        Task::PRIORITY_MEDIUM => 'info',
                        Task::PRIORITY_HIGH   => 'warning',
                        Task::PRIORITY_URGENT => 'danger',
                        default               => 'gray',
                    }),

                TextColumn::make('assignee.name')
                    ->label('Người thực hiện')
                    ->searchable()
                    ->default('—'),

                TextColumn::make('customer.name')
                    ->label('Khách hàng')
                    ->searchable()
                    ->default('—'),

                TextColumn::make('due_date')
                    ->label('Hạn xong')
                    ->date('d/m/Y')
                    ->sortable()
                    ->default('—'),

                TextColumn::make('started_at')
                    ->label('Bắt đầu')
                    ->dateTime('d/m/Y H:i')
                    ->default('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('completed_at')
                    ->label('Hoàn thành')
                    ->dateTime('d/m/Y H:i')
                    ->default('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options(Task::statusLabels()),

                SelectFilter::make('priority')
                    ->label('Độ ưu tiên')
                    ->options(Task::priorityLabels()),

                SelectFilter::make('assignee_id')
                    ->label('Người thực hiện')
                    ->relationship('assignee', 'name'),

                SelectFilter::make('customer_id')
                    ->label('Khách hàng')
                    ->relationship('customer', 'name'),

                Filter::make('overdue')
                    ->label('⚠️ Quá hạn')
                    ->query(fn(Builder $query) =>
                        $query->whereNotNull('due_date')
                              ->whereDate('due_date', '<', now())
                              ->where('status', '!=', Task::STATUS_DONE)
                    ),

                Filter::make('my_tasks')
                    ->label('📋 Task của tôi')
                    // ->query(fn(Builder $query) =>
                    //     $query->where('assignee_id', auth()->id())
                    // ),
            ])
            ->recordActions([
                Action::make('kanban')
                    ->label('Kanban')
                    ->icon('heroicon-o-view-columns')
                    ->url(fn() => \App\Filament\Resources\Tasks\TaskResource::getUrl('kanban'))
                    ->color('gray'),

                Action::make('start')
                    ->label('Bắt đầu')
                    ->icon('heroicon-o-play')
                    ->color('warning')
                    ->visible(fn($record) => $record->status == Task::STATUS_TODO)
                    ->action(fn($record) => $record->update([
                        'status'     => Task::STATUS_IN_PROGRESS,
                        'started_at' => now(),
                    ])),

                Action::make('complete')
                    ->label('Hoàn thành')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn($record) => in_array($record->status, [
                        Task::STATUS_IN_PROGRESS,
                        Task::STATUS_REVIEW,
                    ]))
                    ->action(fn($record) => $record->update([
                        'status'       => Task::STATUS_DONE,
                        'completed_at' => now(),
                    ])),

                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort')
            ->striped();
    }
}