<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Models\Service;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;

class ServiceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            // ── SECTION 1: Thông tin chính ────────────────────────────────
            Section::make('Thông tin dịch vụ')
                ->icon('heroicon-o-information-circle')
                ->columns(2)
                ->schema([
                    TextEntry::make('name')
                        ->label('Tên dịch vụ')
                        ->size('xl')
                        ->weight('bold')
                        ->color('primary')
                        ->columnSpanFull(),

                    TextEntry::make('slug')
                        ->label('Slug (URL)')
                        ->icon('heroicon-o-link')
                        ->copyable()
                        ->copyMessage('Đã sao chép!')
                        ->color('gray')
                        ->columnSpanFull(),

                    TextEntry::make('base_price')
                        ->label('Giá niêm yết')
                        ->money('VND')
                        ->color('success')
                        ->icon('heroicon-o-currency-dollar'),

                    TextEntry::make('unit')
                        ->label('Đơn vị tính')
                        ->badge()
                        ->color('info')
                        ->icon('heroicon-o-scale'),

                    TextEntry::make('creator.name')
                        ->label('Người tạo')
                        ->icon('heroicon-o-user')
                        ->default('—'),

                    TextEntry::make('created_at')
                        ->label('Ngày tạo')
                        ->dateTime('d/m/Y H:i')
                        ->icon('heroicon-o-calendar')
                        ->color('gray'),
                ]),

            // ── SECTION 2: Hình ảnh & Trạng thái ─────────────────────────
            Section::make('Hình ảnh & Trạng thái')
                ->icon('heroicon-o-photo')
                ->columns(2)
                ->schema([
                    TextEntry::make('status')
                        ->label('Trạng thái')
                        ->badge()
                        ->color(fn ($state) => (int) $state === Service::STATUS_ACTIVE ? 'success' : 'danger')
                        ->formatStateUsing(fn ($state) => Service::statusLabels()[$state] ?? $state),

                    ImageEntry::make('image_url')
                        ->label('Ảnh minh họa')
                        ->height(200)
                        ->extraImgAttributes([
                            'class' => 'rounded-xl shadow-md object-cover',
                            'style' => 'max-width: 300px;',
                        ])
                        ->defaultImageUrl(
                            'https://ui-avatars.com/api/?name=No+Image&background=e5e7eb&color=6b7280&size=200'
                        ),
                ]),

            // ── SECTION 3: Mô tả chi tiết (full width, collapsible) ───────
            Section::make('Mô tả chi tiết')
                ->icon('heroicon-o-document-text')
                ->collapsible()
                ->schema([
                    TextEntry::make('description')
                        ->label('')
                        ->html()
                        ->columnSpanFull()
                        ->default('<em style="color:#9ca3af">Chưa có mô tả</em>'),
                ]),

        ]);
    }
}