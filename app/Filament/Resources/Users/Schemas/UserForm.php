<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Spatie\Permission\Models\Role;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Họ tên')
                    ->required(),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required(),

                TextInput::make('password')
                    ->label('Mật khẩu')
                    ->password()
                    ->required(fn($context) => $context === 'create')
                    ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : $state)
                    ->dehydrated(fn($state) => filled($state)),

                Select::make('department_id')
                    ->label('Phòng ban')
                    ->relationship('department', 'name')
                    ->searchable()
                    ->preload(),

                // ← THÊM FIELD CHỌN ROLE
                Select::make('roles')
                    ->label('Vai trò')
                    ->options([
                        'admin'   => '👑 Admin',
                        'manager' => '📋 Manager',
                        'staff'   => '👤 Staff',
                    ])
                    ->native(false)
                    ->required()
                    // Khi load form edit → lấy role hiện tại
                    ->afterStateHydrated(function ($component, $record) {
                        if ($record) {
                            $component->state($record->roles->first()?->name);
                        }
                    })
                    // Khi save → gán role cho user
                    ->saveRelationshipsUsing(function ($record, $state) {
                        if ($state) {
                            $record->syncRoles([$state]);
                        }
                    }),

                FileUpload::make('avatar_url')
                    ->image()
                    ->label('Avatar')
                    ->directory('avatars')
                    ->disk('public')
                    ->imagePreviewHeight(100)
                    ->columnSpanFull(),

                Toggle::make('is_active')
                    ->label('Hoạt động')
                    ->default(true)
                    ->dehydrateStateUsing(fn($state) => $state ? 1 : 0),

                DateTimePicker::make('last_login_at')
                    ->label('Đăng nhập lần cuối')
                    ->nullable(),

                DateTimePicker::make('email_verified_at')
                    ->label('Xác thực email')
                    ->nullable(),
            ]);
    }
}