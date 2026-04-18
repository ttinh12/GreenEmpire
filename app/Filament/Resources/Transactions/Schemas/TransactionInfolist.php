<?php

namespace App\Filament\Resources\Transactions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TransactionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Thông tin giao dịch')
                ->icon('heroicon-o-arrows-right-left')
                ->columns(2)
                ->schema([
                    TextEntry::make('reference_code')
                        ->label('Mã giao dịch')
                        ->badge()
                        ->color('gray')
                        ->copyable()
                        ->columnSpanFull(),

                    TextEntry::make('type')
                        ->label('Loại')
                        ->badge()
                        ->formatStateUsing(fn ($state) => $state == 1 ? 'Thu nhập' : 'Chi phí')
                        ->color(fn ($state) => $state == 1 ? 'success' : 'danger'),

                    TextEntry::make('category.name')
                        ->label('Danh mục')
                        ->badge()
                        ->color('info'),

                    TextEntry::make('amount')
                        ->label('Số tiền')
                        ->money('VND')
                        ->size('xl')
                        ->weight('bold')
                        ->color(fn ($record) => $record->type == 1 ? 'success' : 'danger'),

                    TextEntry::make('transaction_date')
                        ->label('Ngày giao dịch')
                        ->date('d/m/Y')
                        ->icon('heroicon-o-calendar'),

                    TextEntry::make('department.name')
                        ->label('Phòng ban')
                        ->default('—')
                        ->icon('heroicon-o-building-office'),

                    TextEntry::make('description')
                        ->label('Mô tả')
                        ->columnSpanFull(),
                ]),

            Section::make('Liên kết nghiệp vụ')
                ->icon('heroicon-o-link')
                ->columns(2)
                ->schema([
                    TextEntry::make('contract.title')
                        ->label('Hợp đồng')
                        ->default('—')
                        ->icon('heroicon-o-document-text'),

                    TextEntry::make('invoice.code')
                        ->label('Hóa đơn')
                        ->default('—')
                        ->icon('heroicon-o-receipt-percent'),

                    TextEntry::make('reference_doc')
                        ->label('Số chứng từ')
                        ->default('—'),

                    TextEntry::make('attachment')
                        ->label('Đính kèm')
                        ->default('—'),
                ]),

            Section::make('Phê duyệt & Ghi nhận')
                ->icon('heroicon-o-check-badge')
                ->columns(2)
                ->schema([
                    TextEntry::make('creator.name')
                        ->label('Người tạo')
                        ->default('—')
                        ->icon('heroicon-o-user'),

                    TextEntry::make('approver.name')
                        ->label('Người phê duyệt')
                        ->default('Chưa phê duyệt')
                        ->icon('heroicon-o-check-circle'),

                    TextEntry::make('approved_at')
                        ->label('Ngày phê duyệt')
                        ->dateTime('d/m/Y H:i')
                        ->default('—'),

                    TextEntry::make('created_at')
                        ->label('Ngày tạo')
                        ->dateTime('d/m/Y H:i')
                        ->color('gray'),
                ]),
        ]);
    }
}