<?php

namespace App\Filament\Resources\Tickets\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Schema;
use App\Models\User;
use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use Illuminate\Support\Str;

class TicketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('ticket_code')
                    ->label('Mã vé')
                    ->default(function () {
                        // Auto-generate ticket code: TK-2026-001, TK-2026-002, etc.
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
                    })
                    ->readonly()
                    ->unique(ignoreRecord: true)
                    ->required(),

                TextInput::make('title')
                    ->label('Tiêu đề')
                    ->required()
                    ->maxLength(255)
                    ->disabled(fn (string $context): bool => $context === 'edit'),

                Textarea::make('content')
                    ->label('Nội dung')
                    ->required()
                    ->columnSpanFull()
                    ->rows(4)
                    ->disabled(fn (string $context): bool => $context === 'edit'),

                Select::make('user_id')
                    ->label('Khách hàng')
                    ->options(User::where('role', 'customer')->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->default(auth()->id()), // Auto-set to current user if client

                Select::make('assign_id')
                    ->label('Nhân viên xử lý')
                    ->options(User::where('role', 'admin')->orWhere('role', 'staff')->pluck('name', 'id'))
                    ->searchable()
                    ->placeholder('Chọn nhân viên xử lý'),

                Select::make('priority')
                    ->label('Độ ưu tiên')
                    ->options([
                        TicketPriority::ACTIVE->value => TicketPriority::ACTIVE->getLabel(),
                        TicketPriority::INACTIVE->value => TicketPriority::INACTIVE->getLabel(),
                        TicketPriority::BANED->value => TicketPriority::BANED->getLabel(),
                    ])
                    ->default(TicketPriority::ACTIVE->value)
                    ->required(),

                Select::make('status')
                    ->label('Trạng thái')
                    ->options([
                        TicketStatus::ACTIVE->value => TicketStatus::ACTIVE->getLabel(),
                        TicketStatus::INACTIVE->value => TicketStatus::INACTIVE->getLabel(),
                        TicketStatus::BANNED->value => TicketStatus::BANNED->getLabel(),
                    ])
                    ->default(TicketStatus::ACTIVE->value)
                    ->required(),

                Hidden::make('created_by')
                    ->default(auth()->id()),
            ]);
    }
}
