<?php

namespace App\Filament\Resources\Contracts\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ContractForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required(),
                Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->required(),
                Select::make('department_id')
                    ->relationship('department', 'name'),
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('value')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('vat_rate')
                    ->required()
                    ->numeric()
                    ->default(10.0),
                TextInput::make('vat_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('total_value')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                DatePicker::make('start_date'),
                DatePicker::make('end_date'),
                DatePicker::make('signed_date'),
                TextInput::make('status')
                    ->required()
                    ->numeric()
                    ->default(1),
                Textarea::make('payment_terms')
                    ->columnSpanFull(),
                TextInput::make('warranty_months')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('file_url')
                    ->url(),
                TextInput::make('created_by')
                    ->numeric(),
                TextInput::make('updated_by')
                    ->numeric(),
            ]);
    }
}
