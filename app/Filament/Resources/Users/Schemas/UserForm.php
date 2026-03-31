<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

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
                    ->required(),
                TextInput::make('avatar_url')
                    ->url(),
                TextInput::make('is_active')
                    ->required()
                    ->numeric()
                    ->default(1),
                DateTimePicker::make('last_login_at'),
                TextInput::make('department_id')
                    ->numeric(),
            ]);
    }
}
