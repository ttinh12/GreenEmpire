<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    // ── Danh sách dịch vụ ─────────────────────────────────────────
    public function index()
    {
        $services = Service::where('status', Service::STATUS_ACTIVE)
            ->orderBy('name')
            ->paginate(9);

        return view('client.services.index', compact('services'));
    }

    // ── Chi tiết dịch vụ ──────────────────────────────────────────
    public function show($id)
    {
        $service = Service::where('status', Service::STATUS_ACTIVE)
            ->findOrFail($id);

        return view('client.services.show', compact('service'));
    }

    // ── Form đăng ký dịch vụ → tạo hợp đồng nháp ─────────────────
    public function register($id)
    {
        $service = Service::where('status', Service::STATUS_ACTIVE)
            ->findOrFail($id);

        return view('client.services.register', compact('service'));
    }

    // ── Xử lý đăng ký: tạo Customer (nếu chưa có) + Contract nháp ─
    public function store(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $request->validate([
            'quantity'      => 'required|numeric|min:0.1',
            'start_date'    => 'required|date|after_or_equal:today',
            'end_date'      => 'required|date|after:start_date',
            'notes'         => 'nullable|string|max:1000',
            // Thông tin khách hàng nếu chưa có trong hệ thống
            'company_name'  => 'nullable|string|max:200',
            'phone'         => 'nullable|string|max:20',
            'address'       => 'nullable|string|max:500',
        ]);

        $user = Auth::user();

        // Tìm hoặc tạo Customer gắn với tài khoản này
        $customer = Customer::where('email', $user->email)->first();
        if (!$customer) {
            $customer = Customer::create([
                'code'    => 'KH-' . str_pad(Customer::count() + 1, 4, '0', STR_PAD_LEFT),
                'name'    => $request->company_name ?: $user->name,
                'email'   => $user->email,
                'phone'   => $request->phone ?? '',
                'address' => $request->address ?? '',
                'type'    => 2, // Cá nhân
                'status'  => 1,
            ]);
        }

        // Tính giá trị hợp đồng
        $qty      = (float) $request->quantity;
        $value    = $service->base_price * $qty;
        $vatRate  = 10.00;
        $vatAmt   = $value * $vatRate / 100;
        $total    = $value + $vatAmt;

        $contract = Contract::create([
            'code'             => 'HD-' . now()->format('Ymd') . '-' . str_pad(Contract::count() + 1, 3, '0', STR_PAD_LEFT),
            'customer_id'      => $customer->id,
            'title'            => 'Hợp đồng dịch vụ: ' . $service->name,
            'description'      => "Dịch vụ: {$service->name}\nSố lượng: {$qty} {$service->unit}\n" . ($request->notes ?? ''),
            'value'            => $value,
            'vat_rate'         => $vatRate,
            'vat_amount'       => $vatAmt,
            'total_value'      => $total,
            'start_date'       => $request->start_date,
            'end_date'         => $request->end_date,
            'status'           => Contract::STATUS_DRAFT,
            'created_by'       => $user->id,
        ]);

        return redirect()->route('client.contracts.show', $contract->id)
            ->with('success', 'Đăng ký thành công! Vui lòng xem và ký hợp đồng bên dưới.');
    }

    // ── Xem hợp đồng của tôi ──────────────────────────────────────
    public function myContracts()
    {
        $customer = Customer::where('email', Auth::user()->email)->first();

        $contracts = $customer
            ? Contract::where('customer_id', $customer->id)
                ->with('invoices')
                ->latest()
                ->paginate(10)
            : collect();

        return view('client.contracts.index', compact('contracts'));
    }

    // ── Chi tiết hợp đồng + nút ký ───────────────────────────────
    public function showContract($id)
    {
        $customer = Customer::where('email', Auth::user()->email)->first();
        abort_unless($customer, 403);

        $contract = Contract::where('customer_id', $customer->id)
            ->with(['invoices.payments'])
            ->findOrFail($id);

        return view('client.contracts.show', compact('contract'));
    }

    // ── Ký hợp đồng → chuyển status sang Active + tạo Invoice ────
    public function signContract(Request $request, $id)
    {
        $customer = Customer::where('email', Auth::user()->email)->first();
        abort_unless($customer, 403);

        $contract = Contract::where('customer_id', $customer->id)
            ->where('status', Contract::STATUS_DRAFT)
            ->findOrFail($id);

        DB::transaction(function () use ($contract, $customer) {
            // 1. Ký hợp đồng
            $contract->update([
                'status'      => Contract::STATUS_ACTIVE,
                'signed_date' => now(),
            ]);

            // 2. Tạo hóa đơn tự động
            $invoice = Invoice::create([
                'code'          => 'INV-' . now()->format('Ymd') . '-' . str_pad(Invoice::count() + 1, 3, '0', STR_PAD_LEFT),
                'contract_id'   => $contract->id,
                'customer_id'   => $customer->id,
                'issue_date'    => now(),
                'due_date'      => now()->addDays(30),
                'subtotal'      => $contract->value,
                'vat_rate'      => $contract->vat_rate,
                'vat_amount'    => $contract->vat_amount,
                'total_amount'  => $contract->total_value,
                'paid_amount'   => 0,
                'status'        => 3, // Chưa thanh toán
                'created_by'    => $contract->created_by,
            ]);
        });

        return redirect()->route('client.contracts.show', $contract->id)
            ->with('success', 'Hợp đồng đã được ký! Hóa đơn đã được tạo — vui lòng thanh toán.');
    }

    // ── Dịch vụ của tôi: tổng hợp hợp đồng + hóa đơn ────────────────
    public function myServices()
    {
        $customer = Customer::where('email', Auth::user()->email)->first();

        $contracts = $customer
            ? Contract::where('customer_id', $customer->id)
                ->with(['invoices.payments'])
                ->latest()
                ->paginate(10)
            : collect();

        return view('client.my-services', compact('contracts'));
    }

    // ── Danh sách hóa đơn của tôi ─────────────────────────────────
    public function myInvoices()
    {
        $customer = Customer::where('email', Auth::user()->email)->first();

        $invoices = $customer
            ? Invoice::where('customer_id', $customer->id)
                ->with(['contract', 'payments'])
                ->latest()
                ->paginate(10)
            : collect();

        return view('client.invoices.index', compact('invoices'));
    }

    // ── Chi tiết hóa đơn ─────────────────────────────────────────
    public function showInvoice($id)
    {
        $customer = Customer::where('email', Auth::user()->email)->first();
        abort_unless($customer, 403);

        $invoice = Invoice::where('customer_id', $customer->id)
            ->with(['contract', 'payments', 'invoiceItems.service'])
            ->findOrFail($id);

        return view('client.invoices.show', compact('invoice'));
    }

    // ── Thanh toán hóa đơn ────────────────────────────────────────
    public function payInvoice(Request $request, $id)
    {
        $customer = Customer::where('email', Auth::user()->email)->first();
        abort_unless($customer, 403);

        $invoice = Invoice::where('customer_id', $customer->id)
            ->whereIn('status', [3, 2]) // Chưa TT hoặc Chờ TT
            ->findOrFail($id);

        $request->validate([
            'amount'       => 'required|numeric|min:1000|max:' . ($invoice->total_amount - $invoice->paid_amount),
            'method'       => 'required|in:1,2,3,4',
            'reference'    => 'nullable|string|max:100',
        ]);

        DB::transaction(function () use ($request, $invoice) {
            // Ghi nhận thanh toán
            Payment::create([
                'invoice_id'   => $invoice->id,
                'amount'       => $request->amount,
                'payment_date' => now(),
                'method'       => $request->method,
                'reference'    => $request->reference,
                'notes'        => $request->notes,
                'recorded_by'  => Auth::id(),
            ]);

            // Cập nhật paid_amount và status hóa đơn
            $totalPaid = $invoice->payments()->sum('amount') + $request->amount;
            $invoice->paid_amount = $totalPaid;
            $invoice->status = $totalPaid >= $invoice->total_amount ? 1 : 2; // 1=Đã TT, 2=Chờ TT
            $invoice->save();
        });

        return redirect()->route('client.invoices.show', $invoice->id)
            ->with('success', 'Ghi nhận thanh toán thành công!');
    }
}