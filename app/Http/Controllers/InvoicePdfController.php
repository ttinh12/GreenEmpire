<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class InvoicePdfController extends Controller
{
    /**
     * Xuất PDF hóa đơn — dùng cho cả admin và client.
     * Client chỉ xem được hóa đơn của chính mình.
     */
    public function download($id)
    {
        $invoice = Invoice::with([
            'customer',
            'contract',
            'department',
            'creator',
            'invoiceItems.service',
            'payments',
        ])->findOrFail($id);

        // Nếu không phải admin → kiểm tra invoice có thuộc về user này không
        $user = Auth::user();
        if (!$user->hasAnyRole(['admin', 'super_admin', 'manager'])) {
            $customer = Customer::where('email', $user->email)->first();
            abort_unless($customer && $invoice->customer_id === $customer->id, 403);
        }

        $pdf = Pdf::loadView('admin.invoices.pdf', compact('invoice'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream("hoa-don-{$invoice->code}.pdf");
    }
}