<?php

use App\Enums\TicketPriority;
use App\Models\Ticket;
use Dom\Text;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use SebastianBergmann\CodeCoverage\Filter;

class TicketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('title')
                    ->searchable(),

                TextColumn::make('name')
                    ->searchable(),

                TextColumn::make('created_by')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('assign_to')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('priority')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state ? TicketPriority::from($state)->getLabel() : null)
                    ->color(fn (string $state): string => TicketPriority::from($state)->getColor())
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->sortable(),

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
