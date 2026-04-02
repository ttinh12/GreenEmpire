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
                    ->required(),
                TextInput::make('name')
                    ->required(),
                Select::make('type')
                    ->options([
            'company' => 'Company',
            'school' => 'School',
            'government' => 'Government',
            'individual' => 'Individual',
        ])
                    ->default('company')
                    ->required(),
                Textarea::make('address')
                    ->columnSpanFull(),
                TextInput::make('province'),
                TextInput::make('tax_code'),
                TextInput::make('website')
                    ->url(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('fax'),
                Select::make('department_id')
                    ->relationship('department', 'name'),
                Select::make('account_manager_id')
                    ->relationship('accountManager', 'name'),
                TextInput::make('source'),
                Select::make('status')
                    ->options(['active' => 'Active', 'potential' => 'Potential', 'inactive' => 'Inactive'])
                    ->default('potential')
                    ->required(),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
