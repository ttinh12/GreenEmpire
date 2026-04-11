<?php

namespace App\Filament\Resources\Users\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Models\Service;

class CreatedServiceRelationManager extends RelationManager
{
    // Tên hàm quan hệ trong Model User (Bạn đã đặt đúng là createdService)
    protected static string $relationship = 'createdService';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Tên dịch vụ')
                    ->required()
                    ->maxLength(255),

                TextInput::make('base_price')
                    ->label('Giá gốc')
                    ->numeric()
                    ->prefix('VND')
                    ->required(),

                Select::make('status')
                    ->label('Trạng thái')
                    ->options(Service::statusLabels())
                    ->default(Service::STATUS_ACTIVE)
                    ->required(),
                
                TextInput::make('unit')
                    ->label('Đơn vị tính')
                    ->placeholder('VD: gói, giờ, lượt...'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name') // Đổi từ title sang name
            ->columns([
                TextColumn::make('name')
                    ->label('Tên dịch vụ')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('base_price')
                    ->label('Giá tiền')
                    ->money('vnd')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->color(fn (int $state): string => match ($state) {
                        Service::STATUS_ACTIVE => 'success',
                        Service::STATUS_INACTIVE => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (int $state): string => Service::statusLabels()[$state] ?? 'Không xác định'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([ // Filament dùng bulkActions cho các hành động hàng loạt
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}