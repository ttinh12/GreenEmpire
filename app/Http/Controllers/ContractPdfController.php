<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ContractPdfController extends Controller
{
    public function download($id)
    {
        // Lấy dữ liệu hợp đồng và load quan hệ customer, department nếu cần
        $contract = Contract::with(['customer', 'department'])->findOrFail($id);

        $pdf = Pdf::loadView('admin.contracts.pdf', compact('contract'));
        
        return $pdf->stream("hop-dong-{$contract->code}.pdf");
    }
}
