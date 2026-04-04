<?php

namespace App\Filament\Resources\Tickets\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TicketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('assign_id')
                    ->numeric(),
                Select::make('priority')
                    ->options(['1' => 'Low', '2' => 'Medium', '3' => 'High'])
                    ->default('1')
                    ->required(),
                Select::make('status')
                    ->options(['1' => 'Active', '2' => 'Inactive', '3' => 'Banned'])
                    ->default('1')
                    ->required(),
            ]);
    }
}
