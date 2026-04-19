<?php

namespace App\Filament\Resources\CustomerNotes;

use App\Filament\Resources\CustomerNotes\Pages\CreateCustomerNote;
use App\Filament\Resources\CustomerNotes\Pages\EditCustomerNote;
use App\Filament\Resources\CustomerNotes\Pages\ListCustomerNotes;
use App\Filament\Resources\CustomerNotes\Schemas\CustomerNoteForm;
use App\Filament\Resources\CustomerNotes\Tables\CustomerNotesTable;
use App\Models\CustomerNote;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CustomerNoteResource extends Resource
{
    protected static ?string $model = CustomerNote::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;
    protected static string|UnitEnum|null $navigationGroup = 'Chăm sóc & Hỗ trợ';

    protected static ?string $recordTitleAttribute = 'title';

    public static function getNavigationLabel(): string
    {
        return 'Ghi chú khách hàng';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Ghi chú khách hàng';
    }

    public static function getModelLabel(): string
    {
        return 'Ghi chú khách hàng';
    }

    public static function form(Schema $schema): Schema
    {
        return CustomerNoteForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CustomerNotesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCustomerNotes::route('/'),
            'create' => CreateCustomerNote::route('/create'),
            'edit' => EditCustomerNote::route('/{record}/edit'),
        ];
    }
}
