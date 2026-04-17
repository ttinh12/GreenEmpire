<?php

namespace App\Filament\Resources\CustomerNotes\Pages;

use App\Filament\Resources\CustomerNotes\CustomerNoteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCustomerNotes extends ListRecords
{
    protected static string $resource = CustomerNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Thêm ghi chú mới'),
        ];
    }
}
