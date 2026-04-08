<?php

namespace App\Filament\Resources\Tasks\Schemas;

use App\Models\Task;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Illuminate\Support\Facades\Auth;

class TaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Thông tin Task')
                ->schema([
                    TextInput::make('title')
                        ->label('Tiêu đề')
                        ->required()
                        ->maxLength(300)
                        ->columnSpanFull(),

                    Textarea::make('description')
                        ->label('Mô tả')
                        ->rows(4)
                        ->columnSpanFull(),
                ]),

            Section::make('Phân công & Liên kết')
                ->columns(2)
                ->schema([
                    Select::make('assignee_id')
                        ->label('Người thực hiện')
                        ->relationship('assignee', 'name')
                        ->searchable()
                        ->nullable(),

                    Select::make('creator_id')
                        ->label('Người tạo')
                        ->relationship('creator', 'name')
                        ->default(Auth::id())
                        ->searchable()
                        ->nullable(),

                    Select::make('customer_id')
                        ->label('Khách hàng')
                        ->relationship('customer', 'name')
                        ->searchable()
                        ->nullable()
                        ->live()
                        ->afterStateUpdated(fn ($set) => $set('contract_id', null)),

                    Select::make('contract_id')
                        ->label('Hợp đồng')
                        ->relationship('contract', 'title')
                        ->searchable()
                        ->nullable(),
                ]),

            Section::make('Trạng thái & Ưu tiên')
                ->columns(2)
                ->schema([
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
                ]),

            Section::make('Track Time')
                ->columns(2)
                ->schema([
                    DateTimePicker::make('started_at')
                        ->label('Bắt đầu lúc')
                        ->nullable(),

                    DateTimePicker::make('completed_at')
                        ->label('Hoàn thành lúc')
                        ->nullable(),
                ]),
        ]);
    }
}