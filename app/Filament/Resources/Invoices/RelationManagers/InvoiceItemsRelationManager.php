<?php

namespace App\Filament\Resources\Invoices\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InvoiceItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'invoiceItems';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('service_id')
                    ->label('Dịch vụ')
                    ->relationship('service', 'name')
                    ->searchable()
                    ->required(),

                TextInput::make('description')
                    ->label('Mô tả'),

                TextInput::make('unit')
                    ->label('Đơn vị'),

                TextInput::make('quantity')
                    ->numeric()
                    ->default(1)
                    ->required(),

                TextInput::make('unit_price')
                    ->numeric()
                    ->required(),

                TextInput::make('vat_rate')
                    ->numeric()
                    ->default(0),

                TextInput::make('item_order')
                    ->numeric()
                    ->default(1),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([

                TextColumn::make('service.name')
                    ->label('Dịch vụ')
                    ->searchable(),

                TextColumn::make('description'),

                TextColumn::make('quantity'),

                TextColumn::make('unit_price')
                    ->money('VND'),

                TextColumn::make('vat_rate'),

            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
