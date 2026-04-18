<?php

namespace App\Filament\Resources\Invoices\RelationManagers;

use App\Models\Service;
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
        return $schema->components([

            // ── Chọn dịch vụ → tự động điền giá + đơn vị + mô tả ──
            Select::make('service_id')
                ->label('Dịch vụ')
                ->options(
                    Service::where('status', Service::STATUS_ACTIVE)
                        ->orderBy('name')
                        ->pluck('name', 'id')
                )
                ->searchable()
                ->nullable()
                ->live()
                ->afterStateUpdated(function ($state, $set) {
                    if (!$state)
                        return;

                    $service = Service::find($state);
                    if (!$service)
                        return;

                    // Auto-fill từ thông tin service
                    $set('description', $service->name);
                    $set('unit', $service->unit);
                    $set('unit_price', $service->base_price);
                })
                ->columnSpanFull(),

            // ── Mô tả dòng hàng (tự điền từ service, có thể sửa) ──
            TextInput::make('description')
                ->label('Mô tả')
                ->required()
                ->maxLength(500)
                ->columnSpanFull(),

            // ── Số lượng & đơn giá ──
            TextInput::make('quantity')
                ->label('Số lượng')
                ->numeric()
                ->default(1)
                ->minValue(0.01)
                ->required(),

            TextInput::make('unit_price')
                ->label('Đơn giá (₫)')
                ->numeric()
                ->prefix('₫')
                ->default(0)
                ->required(),

            // ── Đơn vị & VAT ──
            TextInput::make('unit')
                ->label('Đơn vị')
                ->placeholder('lượt, héc-ta, giờ...'),

            TextInput::make('vat_rate')
                ->label('VAT (%)')
                ->numeric()
                ->default(10)
                ->suffix('%'),

            // ── Thứ tự dòng ──
            TextInput::make('item_order')
                ->label('Thứ tự')
                ->numeric()
                ->default(1),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                TextColumn::make('item_order')
                    ->label('#')
                    ->sortable()
                    ->width(40),

                TextColumn::make('service.name')
                    ->label('Dịch vụ')
                    ->badge()
                    ->color('info')
                    ->default('—'),

                TextColumn::make('description')
                    ->label('Mô tả')
                    ->limit(40),

                TextColumn::make('quantity')
                    ->label('Số lượng')
                    ->alignEnd(),

                TextColumn::make('unit')
                    ->label('Đơn vị'),

                TextColumn::make('unit_price')
                    ->label('Đơn giá')
                    ->money('VND')
                    ->alignEnd(),

                TextColumn::make('amount')
                    ->label('Thành tiền')
                    ->money('VND')
                    ->alignEnd()
                    ->weight('bold')
                    ->color('success'),

                TextColumn::make('vat_rate')
                    ->label('VAT')
                    ->formatStateUsing(fn($state) => $state . '%')
                    ->alignEnd(),
            ])
            ->defaultSort('item_order')
            ->headerActions([
                CreateAction::make()
                    ->label('Thêm dòng hàng'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}