<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Models\Service;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ServiceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ImageEntry::make('image_url')
                    ->label('Ảnh dịch vụ')
                    ->circular()
                    ->height(48),

                TextEntry::make('name')
                    ->label('Tên dịch vụ'),

                TextEntry::make('slug')
                    ->label('Slug'),

                TextEntry::make('description')
                    ->label('Mô tả')
                    ->placeholder('-')
                    ->columnSpanFull(),

                TextEntry::make('base_price')
                    ->label('Giá niêm yết')
                    ->formatStateUsing(fn ($state) => $state !== null ? number_format((float) $state, 0, ',', '.') . ' VNĐ' : '-'),

                TextEntry::make('unit')
                    ->label('Đơn vị'),

                TextEntry::make('status')
                    ->label('Trạng thái')
                    ->formatStateUsing(fn ($state) => Service::statusLabels()[$state] ?? $state),

                TextEntry::make('creator.name')
                    ->label('Người tạo')
                    ->placeholder('-'),

                TextEntry::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
