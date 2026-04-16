<?php

namespace App\Filament\Resources\Departments\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;

class DepartmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                ->label('Mã phòng ban')
                    ->required(),
                TextInput::make('name')
                    ->label('Tên phòng ban')
                    ->required(),
                Textarea::make('description')
                    ->label('Mô tả')
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->label('Trạng thái')

                    ->required()
                    ->default(true),
            ]);
    }
}
