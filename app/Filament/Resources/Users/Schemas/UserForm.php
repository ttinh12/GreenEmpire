<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;


class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->required(fn($context) => $context === 'create')
                    ->dehydrateStateUsing(fn($state) => bcrypt($state)),
                FileUpload::make('avatar_url')
                    ->image()
                    ->label('Avatar')
                    ->directory('avatars')
                    ->disk('public')
                    ->imagePreviewHeight(100)
                    ->columnSpanFull(),
                Toggle::make('is_active')

                    ->default(true)
                    ->dehydrateStateUsing(fn($state) => $state ? 1 : 0),
                DateTimePicker::make('last_login_at'),
                Select::make('department_id')
                    ->relationship('department', 'name')
                    ->searchable()
                    ->preload(),
            ]);
    }
}
