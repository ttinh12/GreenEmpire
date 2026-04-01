<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                ImageColumn::make('avatar_url')
                    ->label('Avatar')
                    ->disk('public') // 🔥 BẮT BUỘC
                    ->circular(),

                TextColumn::make('name')
                    ->searchable(),

                TextColumn::make('email')
                    ->searchable(),

                IconColumn::make('is_active') // 🔥 FIX
                    ->boolean(),

                TextColumn::make('department.name')
                    ->label('Department')
                    ->badge()
                    ->sortable()
                    ->searchable(),

                TextColumn::make('last_login_at')
                    ->dateTime(),

            ])

            ->filters([


                SelectFilter::make('department_id')
                    ->relationship('department', 'name'),

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
