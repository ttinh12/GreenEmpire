<?php
namespace App\Filament\Resources\Services\Schemas;

use App\Models\Service;
use Illuminate\Support\Str;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Tên dịch vụ')
                    ->placeholder('VD: Thuê máy cày công suất lớn')
                    ->required()
                    ->maxLength(200)
                    ->afterStateUpdated(fn ($set, $state) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->label('Slug (đường dẫn)')
                    ->placeholder('Tự động sinh từ tên dịch vụ')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->disabled(),

                RichEditor::make('description')
                    ->label('Mô tả dịch vụ')
                    ->columnSpanFull(),

                FileUpload::make('image_url')
                    ->label('Ảnh minh họa')
                    ->image()
                    ->directory('services-photos')
                    ->imagePreviewHeight(120),

                TextInput::make('base_price')
                    ->label('Giá niêm yết')
                    ->numeric()
                    ->prefix('₫')
                    ->default(0),

                TextInput::make('unit')
                    ->label('Đơn vị tính')
                    ->placeholder('Héc-ta, mẫu, giờ...')
                    ->default('lượt'),

                Select::make('status')
                    ->label('Trạng thái dịch vụ')
                    ->options(Service::statusLabels())
                    ->default(Service::STATUS_ACTIVE)
                    ->required()
                    ->native(false),
            ]);
    }
}