<?php

namespace App\Filament\Resources\CustomerNotes\Pages;

use App\Filament\Resources\CustomerNotes\CustomerNoteResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCustomerNote extends EditRecord
{
    protected static string $resource = CustomerNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
