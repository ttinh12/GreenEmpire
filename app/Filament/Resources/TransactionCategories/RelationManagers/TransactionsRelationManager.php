<?php

namespace App\Filament\Resources\TransactionCategories\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TransactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'transactions';
    protected static ?string $title = 'Giao dịch trong danh mục';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('reference_code')
                ->label('Mã giao dịch')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(50)
                ->default(fn() => 'TXN-' . now()->format('Y') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT))
                ->columnSpanFull(),

            TextInput::make('amount')
                ->label('Số tiền (₫)')
                ->numeric()
                ->prefix('₫')
                ->required()
                ->minValue(1),

            DatePicker::make('transaction_date')
                ->label('Ngày giao dịch')
                ->required()
                ->default(now()),

            Textarea::make('description')
                ->label('Mô tả')
                ->required()
                ->rows(2)
                ->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('reference_code')
            ->columns([
                TextColumn::make('reference_code')
                    ->label('Mã GD')
                    ->badge()
                    ->color('gray')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('transaction_date')
                    ->label('Ngày')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('amount')
                    ->label('Số tiền')
                    ->money('VND')
                    ->alignEnd()
                    ->weight('bold')
                    ->color(fn($record) => $record->type == 1 ? 'success' : 'danger')
                    ->sortable(),

                TextColumn::make('type')
                    ->label('Loại')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state == 1 ? 'Thu' : 'Chi')
                    ->color(fn($state) => $state == 1 ? 'success' : 'danger'),

                TextColumn::make('description')
                    ->label('Mô tả')
                    ->limit(40)
                    ->searchable(),

                TextColumn::make('approver.name')
                    ->label('Phê duyệt')
                    ->default('Chưa duyệt')
                    ->badge()
                    ->color(fn($record) => $record->approved_by ? 'success' : 'warning'),
            ])
            ->filters([
                Filter::make('this_month')
                    ->label('Tháng này')
                    ->query(fn(Builder $q) => $q
                        ->whereMonth('transaction_date', now()->month)
                        ->whereYear('transaction_date', now()->year)),

                Filter::make('unapproved')
                    ->label('Chưa phê duyệt')
                    ->query(fn(Builder $q) => $q->whereNull('approved_by')),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Thêm giao dịch')
                    ->mutateFormDataUsing(function (array $data): array {
                        // Tự lấy type từ danh mục cha
                        $data['type'] = $this->getOwnerRecord()->type;
                        $data['created_by'] = Auth::id();
                        return $data;
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->defaultSort('transaction_date', 'desc')
            ->striped();
    }
}