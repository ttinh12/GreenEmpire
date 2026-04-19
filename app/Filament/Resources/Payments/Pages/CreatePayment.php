<?php
namespace App\Filament\Resources\Payments\Pages;
use App\Filament\Resources\Payments\PaymentResource;
use App\Models\Invoice;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['recorded_by'] = Auth::id();
        return $data;
    }

    // Sau khi tạo thanh toán → cập nhật paid_amount trên hóa đơn
    protected function afterCreate(): void
    {
        $payment = $this->getRecord();
        $invoice = Invoice::find($payment->invoice_id);

        if ($invoice) {
            $totalPaid = $invoice->payments()->sum('amount');
            $invoice->paid_amount = $totalPaid;

            // Tự động cập nhật trạng thái hóa đơn
            if ($totalPaid >= $invoice->total_amount) {
                $invoice->status = \App\Enums\InvoiceStatus::PAID;
            } elseif ($totalPaid > 0) {
                $invoice->status = \App\Enums\InvoiceStatus::PENDING;
            }

            $invoice->save();
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}