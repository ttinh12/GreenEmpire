<?php

namespace App\Filament\Resources\Invoices\Pages;

use App\Filament\Resources\Invoices\InvoiceResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;

class CreateInvoice extends CreateRecord
{
    protected static string $resource = InvoiceResource::class;

    // Sau khi tạo → redirect sang trang Edit để thêm dòng hàng ngay
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }

    protected function afterCreate(): void
    {
        if ($this->record->customer && $this->record->customer->email) {
            Mail::to($this->record->customer->email)
                ->send(new InvoiceMail($this->record));
        }
    }
}