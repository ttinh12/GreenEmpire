<?php

namespace App\Filament\Resources\Tickets\Schemas;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use App\Enums\TicketPriority;
use App\Enums\TicketStatus;

class TicketInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin vé')
                    ->schema([
                        TextEntry::make('ticket_code')
                            ->label('Mã vé')
                            ->copyable()
                            ->copyMessage('Đã sao chép mã vé')
                            ->copyMessageDuration(1500),
                        TextEntry::make('title')
                            ->label('Tiêu đề'),
                        TextEntry::make('content')
                            ->label('Nội dung')
                            ->columnSpanFull()
                            ->prose(),
                        TextEntry::make('priority')
                            ->label('Độ ưu tiên')
                            ->badge()
                            ->color(fn ($state): string => is_object($state)
                                ? $state->getColor()
                                : TicketPriority::from($state)->getColor())
                            ->formatStateUsing(fn ($state): string => is_object($state)
                                ? $state->getLabel()
                                : TicketPriority::from($state)->getLabel()),
                        TextEntry::make('status')
                            ->label('Trạng thái')
                            ->badge()
                            ->color(fn ($state): string => is_object($state)
                                ? $state->getColor()
                                : TicketStatus::from($state)->getColor())
                            ->formatStateUsing(fn ($state): string => is_object($state)
                                ? $state->getLabel()
                                : TicketStatus::from($state)->getLabel()),
                    ])
                    ->columns(2),

                Section::make('Thông tin người liên quan')
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Khách hàng')
                            ->placeholder('N/A'),
                        TextEntry::make('user.email')
                            ->label('Email khách hàng')
                            ->placeholder('N/A'),
                        TextEntry::make('assignee.name')
                            ->label('Nhân viên xử lý')
                            ->placeholder('Chưa được giao'),
                        TextEntry::make('assignee.email')
                            ->label('Email nhân viên')
                            ->placeholder('N/A'),
                    ])
                    ->columns(2),

                Section::make('Dòng thời gian')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Ngày tạo')
                            ->dateTime('d/m/Y H:i:s'),
                        TextEntry::make('updated_at')
                            ->label('Ngày cập nhật cuối')
                            ->dateTime('d/m/Y H:i:s'),
                        TextEntry::make('completed_at')
                            ->label('Ngày hoàn thành')
                            ->dateTime('d/m/Y H:i:s')
                            ->placeholder('Chưa hoàn thành')
                            ->visible(fn ($record) => $record->status === TicketStatus::BANNED),
                    ])
                    ->columns(1),
            ]);
    }
}