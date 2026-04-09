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
                // 🔥 THÊM CỘT ROLES (đồng bộ với Shield)
                TextColumn::make('roles.name')
                    ->label('Vai trò')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'admin' => 'danger',
                        'manager' => 'warning',
                        'staff' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn($state) => match ($state) {
                        'admin' => '👑 Admin',
                        'manager' => '📋 Manager',
                        'staff' => '👤 Staff',
                        default => $state,
                    })
                    ->sortable()
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
