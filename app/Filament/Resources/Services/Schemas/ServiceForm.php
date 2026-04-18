<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Models\Service;
use Illuminate\Support\Str;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            // ── SECTION 1: Thông tin cơ bản ──────────────────────────────
            Section::make('Thông tin cơ bản')
                ->description('Tên, slug và mô tả chi tiết dịch vụ')
                ->icon('heroicon-o-information-circle')
                ->schema([
                    TextInput::make('name')
                        ->label('Tên dịch vụ')
                        ->placeholder('VD: Thuê máy cày công suất lớn')
                        ->required()
                        ->maxLength(200)
                        ->live(onBlur: true)
                        ->afterStateUpdated(
                            fn ($set, $state) => $set('slug', Str::slug($state))
                        )
                        ->columnSpanFull(),

                    TextInput::make('slug')
                        ->label('Slug (URL)')
                        ->placeholder('tu-dong-sinh-tu-ten')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->disabled()
                        ->helperText('Tự động tạo từ tên dịch vụ')
                        ->columnSpanFull(),

                    RichEditor::make('description')
                        ->label('Mô tả chi tiết')
                        ->placeholder('Mô tả đầy đủ về dịch vụ, phạm vi áp dụng, lưu ý...')
                        ->toolbarButtons([
                            'bold', 'italic', 'underline',
                            'bulletList', 'orderedList',
                            'h2', 'h3',
                            'link', 'undo', 'redo',
                        ])
                        ->columnSpanFull(),
                ]),

            // ── SECTION 2: Định giá & Trạng thái (2 cột) ─────────────────
            Section::make('Định giá & Trạng thái')
                ->description('Giá niêm yết, đơn vị tính và trạng thái hoạt động')
                ->icon('heroicon-o-currency-dollar')
                ->columns(2)
                ->schema([
                    TextInput::make('base_price')
                        ->label('Giá niêm yết (₫)')
                        ->numeric()
                        ->prefix('₫')
                        ->default(0)
                        ->minValue(0)
                        ->helperText('Nhập 0 nếu giá thỏa thuận'),

                    TextInput::make('unit')
                        ->label('Đơn vị tính')
                        ->placeholder('Héc-ta, mẫu, giờ, lượt...')
                        ->default('lượt'),

                    Select::make('status')
                        ->label('Trạng thái')
                        ->options(Service::statusLabels())
                        ->default(Service::STATUS_ACTIVE)
                        ->required()
                        ->native(false),

                    FileUpload::make('image_url')
                        ->label('Ảnh minh họa')
                        ->image()
                        ->directory('services-photos')
                        ->imagePreviewHeight(150)
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->maxSize(2048)
                        ->helperText('JPG, PNG, WEBP – tối đa 2MB'),
                ]),

        ]);
    }
}