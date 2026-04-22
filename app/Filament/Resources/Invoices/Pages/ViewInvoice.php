<?php

namespace App\Filament\Resources\Invoices\Pages;

use App\Filament\Resources\Invoices\InvoiceResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewInvoice extends ViewRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label('Chỉnh sửa hóa đơn'),
                \Filament\Actions\Action::make("downloadPdf")
                ->label("Tải PDF")
                ->icon("heroicon-o-document-arrow-down")
                ->color("success")
                ->url(fn ($record) => route("invoices.pdf", ["id" => $record->id]))
                ->openUrlInNewTab(),
        ];
    }
}
