@extends('client.layouts.master')
@section('title')Hóa đơn của tôi@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="fw-bold mb-4">Hóa đơn của tôi</h4>

    @forelse($invoices as $invoice)
    @php
        $statusVal = $invoice->status instanceof \App\Enums\InvoiceStatus
            ? $invoice->status->value : $invoice->status;
        $statusMap = [1=>'Đã thanh toán', 2=>'Chờ thanh toán', 3=>'Chưa thanh toán'];
        $colorMap  = [1=>'success', 2=>'warning', 3=>'danger'];
        $remaining = $invoice->total_amount - $invoice->paid_amount;
        $pct = $invoice->total_amount > 0
            ? min(100, round($invoice->paid_amount / $invoice->total_amount * 100))
            : 0;
    @endphp
    <div class="card border-0 shadow-sm mb-3" style="border-radius:12px;">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-3" style="background:#e1f5ee;">
                            <i class="bx bx-receipt" style="font-size:24px;color:#1D9E75;"></i>
                        </div>
                        <div>
                            <code class="text-primary fw-semibold">{{ $invoice->code }}</code>
                            <div class="small text-muted mt-1">{{ $invoice->contract?->title ?? '—' }}</div>
                            <span class="badge bg-{{ $colorMap[$statusVal] ?? 'secondary' }} mt-1">
                                {{ $statusMap[$statusVal] ?? '—' }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-3 mt-md-0">
                    <div class="d-flex justify-content-between small mb-1">
                        <span class="text-muted">Tiến độ TT</span>
                        <span class="fw-semibold">{{ $pct }}%</span>
                    </div>
                    <div class="progress" style="height:6px;">
                        <div class="progress-bar bg-success" style="width:{{ $pct }}%"></div>
                    </div>
                    <div class="d-flex justify-content-between small mt-1">
                        <span class="text-success">{{ number_format($invoice->paid_amount, 0, ',', '.') }} ₫</span>
                        <span class="text-muted">/ {{ number_format($invoice->total_amount, 0, ',', '.') }} ₫</span>
                    </div>
                </div>
                <div class="col-md-3 mt-3 mt-md-0 text-md-end">
                    <div class="small text-muted mb-1">
                        Hạn: <span class="@if($invoice->due_date < now() && $statusVal != 1) text-danger fw-semibold @endif">
                            {{ $invoice->due_date->format('d/m/Y') }}
                        </span>
                    </div>
                    <a href="{{ route('client.invoices.show', $invoice->id) }}"
                       class="btn btn-sm {{ $statusVal == 1 ? 'btn-outline-success' : 'btn-primary' }}">
                        {{ $statusVal == 1 ? 'Xem hóa đơn' : 'Thanh toán ngay' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="card border-0 shadow-sm text-center py-5">
        <div class="card-body">
            <i class="bx bx-receipt" style="font-size:64px;color:#d3d1c7;"></i>
            <h5 class="mt-3 text-muted">Chưa có hóa đơn nào</h5>
            <a href="{{ route('services.index') }}" class="btn btn-primary mt-2">Đăng ký dịch vụ</a>
        </div>
    </div>
    @endforelse

    <div class="mt-3">{{ $invoices->links() }}</div>
</div>
@endsection