<?php

namespace App\Filament\Resources\Tasks\Schemas;

use App\Models\Task;
use App\Models\Contract;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use App\Services\SimpleAISuggester;

class TaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            // ================= THÔNG TIN =================
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

            // ================= PHÂN CÔNG =================
            Section::make('Phân công & Liên kết')
                ->columns(2)
                ->schema([

                    Select::make('assignee_id')
                        ->label('Người thực hiện')
                        ->relationship('assignee', 'name')
                        ->searchable()
                        ->helperText('🤖 AI sẽ tự gợi ý khi chọn hợp đồng')
                        ->nullable(),

                    Select::make('contract_id')
                        ->label('Hợp đồng')
                        ->relationship('contract', 'title')
                        ->searchable()
                        ->live() // 🔥 dùng live thay vì reactive (Filament mới)
                        ->afterStateUpdated(function ($state, callable $set) {

                            if (!$state) {
                                $set('customer_id', null);
                                $set('assignee_id', null);
                                return;
                            }

                            $contract = Contract::find($state);

                            if (!$contract) return;

                            // ✅ AUTO CUSTOMER
                            $set('customer_id', $contract->customer_id);

                            // 🤖 AI ASSIGN
                            $user = SimpleAISuggester::suggest($contract->customer_id);

                            if ($user) {
                                $set('assignee_id', $user->id);

                                // 🤖 AI DEADLINE
                                $deadline = SimpleAISuggester::suggestDeadline($user->id);

                                // ⚠️ đảm bảo không set ngày quá khứ
                                if ($deadline && $deadline->isFuture()) {
                                    $set('due_date', $deadline->format('Y-m-d'));
                                }
                            }
                        }),

                    Select::make('customer_id')
                        ->label('Khách hàng')
                        ->relationship('customer', 'name')
                        ->disabled()
                        ->dehydrated(), // vẫn lưu DB
                ]),

            // ================= TRẠNG THÁI =================
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
                        ->helperText('🤖 AI sẽ tự đề xuất')
                        ->minDate(now())
                        ->nullable(),
                ]),
        ]);
    }
}