<?php

namespace App\Filament\Resources\Contracts\RelationManagers;

use App\Models\Task;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class TasksRelationManager extends RelationManager
{
    protected static string $relationship = 'tasks';
    protected static ?string $title = 'Danh sách Tasks';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')
                ->label('Tiêu đề')
                ->required()
                ->maxLength(300)
                ->columnSpanFull(),

            Textarea::make('description')
                ->label('Mô tả')
                ->rows(3)
                ->columnSpanFull(),

            // ✅ FIX: dùng relationship thay vì User::all()
            Select::make('assignee_id')
                ->label('Người thực hiện')
                ->relationship('assignee', 'name')
                ->searchable()
                ->preload()
                ->nullable(),

            Select::make('status')
                ->label('Trạng thái')
                ->options(Task::statusLabels())
                ->default(Task::STATUS_TODO)
                ->required(),

            Select::make('priority')
                ->label('Độ ưu tiên')
                ->options(Task::priorityLabels())
                ->default(Task::PRIORITY_MEDIUM)
                ->required(),

            DatePicker::make('due_date')
                ->label('Hạn hoàn thành')
                ->nullable(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table

            // ✅ FIX: thêm nút tạo task
            ->headerActions([
                CreateAction::make()
                    ->label('Thêm Task')
                    ->mutateFormDataUsing(function ($data) {
                        // tự gán customer theo contract
                        $data['customer_id'] = $this->ownerRecord->customer_id;
                        return $data;
                    }),
            ])

            ->columns([
                TextColumn::make('title')
                    ->label('Tiêu đề')
                    ->searchable()
                    ->limit(40)
                    ->weight('bold'),

                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->formatStateUsing(fn($state) => Task::statusLabels()[$state] ?? $state)
                    ->color(fn($state) => match ((int)$state) {
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
                    ->color(fn($state) => match ((int)$state) {
                        Task::PRIORITY_LOW    => 'gray',
                        Task::PRIORITY_MEDIUM => 'info',
                        Task::PRIORITY_HIGH   => 'warning',
                        Task::PRIORITY_URGENT => 'danger',
                        default               => 'gray',
                    }),

                TextColumn::make('assignee.name')
                    ->label('Người thực hiện')
                    ->default('Chưa assign'),

                TextColumn::make('due_date')
                    ->label('Hạn xong')
                    ->date('d/m/Y')
                    ->badge()
                    ->color(
                        fn($record) =>
                        $record->due_date &&
                            $record->due_date < now() &&
                            $record->status != Task::STATUS_DONE
                            ? 'danger'
                            : 'gray'
                    )
                    ->formatStateUsing(
                        fn($state, $record) =>
                        $state
                            ? $state->format('d/m/Y') . (
                                $record->due_date < now() && $record->status != Task::STATUS_DONE
                                ? ' (Quá hạn)'
                                : ''
                            )
                            : '—'
                    ),

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
            ])
            ->recordActions([
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

            // ✅ FIX nhẹ (an toàn hơn)
            ->defaultSort('sort', 'asc');
    }
}
