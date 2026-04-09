<?php

namespace App\Filament\Resources\Tickets\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use App\Enums\TicketPriority;
use App\Enums\TicketStatus;



class TicketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('ticket_code')
                    ->label('Mã vé')
                    ->placeholder('Hệ thống tự tạo...')
                    ->default(function ($context) {
                        if ($context === 'create') {
                            $year = date('Y');
                            $lastTicket = \App\Models\Ticket::where('ticket_code', 'like', "TK-{$year}-%")
                                ->orderBy('id', 'desc')
                                ->first();

                            if ($lastTicket) {
                                $lastNumber = (int) Str::afterLast($lastTicket->ticket_code, '-');
                                $newNumber = $lastNumber + 1;
                            } else {
                                $newNumber = 1;
                            }
                            return sprintf('TK-%s-%03d', $year, $newNumber);
                        }
                        return null;
                    })
                    ->required(fn($context) => $context === 'create')
                    ->disabled(fn($context) => $context === 'edit')
                    ->dehydrated()
                    ->maxLength(50),

                TextInput::make('title')
                    ->label('Tiêu đề')
                    ->required()
                    ->maxLength(255)
                    // Dùng logic context để khóa khi edit
                    ->disabled(fn($context) => $context === 'edit'),

                Textarea::make('content')
                    ->label('Nội dung')
                    ->required()
                    ->columnSpanFull()
                    ->rows(4)
                    ->disabled(fn($context) => $context === 'edit'),

                Select::make('user_id')
                    ->label('Khách hàng')
                    ->relationship('user', 'name') // Phải có hàm user() trong Model Ticket
                    ->searchable()
                    ->preload()
                    ->required()
                    // Chỉ set mặc định khi tạo mới, Edit thì giữ nguyên của record
                    ->default(fn($context) => $context === 'create' ? auth()->id() : null),

                // CHỈNH NHÂN VIÊN: Dùng relationship thay vì options để hiện tên
                Select::make('assign_id')
                    ->label('Nhân viên xử lý')
                    ->relationship('assignee', 'name', function ($query) {
                        // Chỉ hiện những người là admin hoặc staff
                        return $query->whereIn('role', ['admin', 'staff']);
                    })
                    ->searchable()
                    ->preload()
                    ->placeholder('Chọn nhân viên xử lý'),

                Select::make('priority')
                    ->label('Độ ưu tiên')
                    // Cách gọi Enum này gọn hơn nè
                    ->options(TicketPriority::class)
                    ->default(TicketPriority::ACTIVE->value)
                    ->native(false) // Cho giao diện hiện đại hơn
                    ->required(),

                Select::make('status')
                    ->label('Trạng thái')
                    ->options(TicketStatus::class)
                    ->default(TicketStatus::ACTIVE->value)
                    ->native(false)
                    ->required(),
            ]);
    }
}