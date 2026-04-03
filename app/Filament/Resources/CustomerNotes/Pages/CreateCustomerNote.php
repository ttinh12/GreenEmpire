<?php

namespace App\Filament\Resources\CustomerNotes\Pages;

use App\Filament\Resources\CustomerNotes\CustomerNoteResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomerNote extends CreateRecord
{
    protected static string $resource = CustomerNoteResource::class;
}
