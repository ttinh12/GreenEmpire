<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->label('Mã khách hàng')
                    ->required(),

                TextInput::make('name')
                    ->label('Tên khách hàng')
                    ->required(),

                Select::make('type')
                    ->label('Loại khách hàng')
                    ->options([
                        '1' => 'Công ty',
                        '2' => 'Trường học',
                        '3' => 'Cơ quan nhà nước',
                        '4' => 'Cá nhân',
                    ])
                    ->default('1')
                    ->required(),

                Textarea::make('address')
                    ->label('Địa chỉ')
                    ->columnSpanFull(),

                TextInput::make('province')
                    ->label('Tỉnh / Thành phố'),

                TextInput::make('tax_code')
                    ->label('Mã số thuế'),

                TextInput::make('website')
                    ->label('Website')
                    ->url(),

                TextInput::make('email')
                    ->label('Email')
                    ->email(),

                TextInput::make('phone')
                    ->label('Số điện thoại')
                    ->tel(),

                TextInput::make('fax')
                    ->label('Số fax'),



                Select::make('department_id')
                    ->label('Phòng ban')
                    ->relationship('department', 'name'),

                Select::make('account_manager_id')
                    ->label('Nhân viên phụ trách')
                    ->relationship('accountManager', 'name'),

                TextInput::make('source')
                    ->label('Nguồn khách hàng'),

                Select::make('status')
                    ->options([
                        1 => 'Đang hoạt động',
                        2 => 'Tiềm năng',
                        3 => 'Ngưng hoạt động',
                    ])
                    ->default(2)

                    ->required(),

                Textarea::make('notes')
                    ->label('Ghi chú')
                    ->columnSpanFull(),
            ]);
    }
}
