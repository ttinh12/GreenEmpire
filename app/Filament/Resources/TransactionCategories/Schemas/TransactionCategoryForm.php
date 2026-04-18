<?php

namespace App\Filament\Resources\TransactionCategories\Schemas;

use App\Models\TransactionCategory;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TransactionCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Thông tin danh mục')
                ->icon('heroicon-o-tag')
                ->columns(2)
                ->schema([
                    TextInput::make('code')
                        ->label('Mã danh mục')
                        ->placeholder('VD: INC_WEB, EXP_SALA')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(20)
                        ->helperText('Viết HOA, dùng dấu gạch dưới'),

                    TextInput::make('name')
                        ->label('Tên danh mục')
                        ->placeholder('VD: Doanh thu thiết kế web')
                        ->required()
                        ->maxLength(100),

                    Select::make('type')
                        ->label('Loại')
                        ->options([
                            1 => 'Thu nhập',
                            2 => 'Chi phí',
                        ])
                        ->required()
                        ->native(false),

                    Select::make('parent_id')
                        ->label('Danh mục cha')
                        ->options(
                            TransactionCategory::whereNull('parent_id')
                                ->orderBy('name')
                                ->pluck('name', 'id')
                        )
                        ->nullable()
                        ->native(false)
                        ->helperText('Để trống nếu đây là danh mục gốc'),

                    Toggle::make('is_active')
                        ->label('Đang hoạt động')
                        ->default(true)
                        ->columnSpanFull(),
                ]),
        ]);
    }
}