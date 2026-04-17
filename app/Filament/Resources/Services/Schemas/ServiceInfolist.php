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
            // Section 1: Chỉ chứa thông tin chữ, chia 2 cột để tiết kiệm diện tích
            Section::make('Thông tin dịch vụ')
                ->columns(2) 
                ->schema([
                    TextEntry::make('name')
                        ->label('Tên dịch vụ')
                        ->weight('bold')
                        ->color('primary')
                        ->columnSpan(2), // Tên cho nằm riêng 1 hàng

                    TextEntry::make('base_price')
                        ->label('Giá niêm yết')
                        ->money('VND')
                        ->color('success'),

                    TextEntry::make('unit')
                        ->label('Đơn vị tính')
                        ->badge(),

                    TextEntry::make('description')
                        ->label('Mô tả chi tiết')
                        ->html()
                        ->columnSpan(2), // Mô tả chiếm hết hàng
                ]),

            // Section 2: Chứa ảnh, khống chế chiều cao cực gắt
            Section::make('Hình ảnh & Trạng thái')
                ->columns(2)
                ->schema([
                    ImageEntry::make('image_url')
                        ->label('Ảnh minh họa')
                        ->height(200) // Ép ảnh nhỏ lại ngay lập tức
                        ->extraImgAttributes([
                            'class' => 'rounded-lg shadow-sm object-cover',
                            'style' => 'max-width: 300px;' // Không cho phép nó to quá 300px
                        ]),

                    TextEntry::make('status')
                        ->label('Trạng thái')
                        ->badge()
                        ->color(fn ($state) => $state === Service::STATUS_ACTIVE ? 'success' : 'danger')
                        ->formatStateUsing(fn ($state) => Service::statusLabels()[$state] ?? $state),
                ]),
        ]);
    }
}