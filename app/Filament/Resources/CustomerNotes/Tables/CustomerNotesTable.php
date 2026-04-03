<?php

namespace App\Filament\Resources\CustomerNotes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CustomerNotesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('type')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('note_date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('follow_up_date')
                    ->date()
                    ->sortable(),
                IconColumn::make('is_pinned')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
