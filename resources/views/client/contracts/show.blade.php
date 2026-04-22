@extends('client.layouts.master')
@section('title')Hợp đồng: {{ $contract->code }}@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.contracts.index') }}">Hợp đồng của tôi</a></li>
            <li class="breadcrumb-item active">{{ $contract->code }}</li>
        </ol>
    </nav>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            <i class="bx bx-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">

        {{-- Thông tin hợp đồng --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-4">

                    {{-- Header --}}
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h5 class="fw-bold mb-1">{{ $contract->title }}</h5>
                            <code class="text-muted">{{ $contract->code }}</code>
                        </div>
                        @php
                            $statusMap = [1=>'Nháp', 2=>'Đang hiệu lực', 3=>'Hoàn thành', 4=>'Quá hạn', 5=>'Đã hủy'];
                            $colorMap  = [1=>'secondary', 2=>'success', 3=>'info', 4=>'danger', 5=>'dark'];
                        @endphp
                        <span class="badge bg-{{ $colorMap[$contract->status] ?? 'secondary' }} fs-6 px-3 py-2">
                            {{ $statusMap[$contract->status] ?? 'Không xác định' }}
                        </span>
                    </div>

                    {{-- Mô tả --}}
                    @if($contract->description)
                    <div class="p-3 rounded-3 mb-4" style="background:#f9f9f7; white-space: pre-line;">
                        {{ $contract->description }}
                    </div>
                    @endif

                    {{-- Thông tin chi tiết --}}
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="small text-muted mb-1">Ngày bắt đầu</div>
                            <div class="fw-semibold">{{ $contract->start_date?->format('d/m/Y') ?? '—' }}</div>
                        </div>
                        <div class="col-6">
                            <div class="small text-muted mb-1">Ngày kết thúc</div>
                            <div class="fw-semibold">{{ $contract->end_date?->format('d/m/Y') ?? '—' }}</div>
                        </div>
                        <div class="col-6">
                            <div class="small text-muted mb-1">Ngày ký</div>
                            <div class="fw-semibold">{{ $contract->signed_date?->format('d/m/Y') ?? 'Chưa ký' }}</div>
                        </div>
                        <div class="col-6">
                            <div class="small text-muted mb-1">Ngày tạo</div>
                            <div class="fw-semibold">{{ $contract->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>

                    {{-- Giá trị --}}
                    <div class="p-3 rounded-3" style="background:#f0effe;">
                        <div class="row g-2 text-center">
                            <div class="col-4">
                                <div class="small text-muted">Tạm tính</div>
                                <div class="fw-semibold">{{ number_format($contract->value, 0, ',', '.') }} ₫</div>
                            </div>
                            <div class="col-4">
                                <div class="small text-muted">VAT ({{ $contract->vat_rate }}%)</div>
                                <div class="fw-semibold">{{ number_format($contract->vat_amount, 0, ',', '.') }} ₫</div>
                            </div>
                            <div class="col-4">
                                <div class="small text-muted">Tổng giá trị</div>
                                <div class="fw-bold text-success fs-5">{{ number_format($contract->total_value, 0, ',', '.') }} ₫</div>
                            </div>
                        </div>
                    </div>

                    {{-- Nút ký hợp đồng --}}
                    @if($contract->status === 1)
                    <div class="mt-4 p-3 rounded-3 border border-warning" style="background:#fffbf0;">
                        <h6 class="fw-semibold mb-2"><i class="bx bx-edit me-1 text-warning"></i>Ký hợp đồng</h6>
                        <p class="small text-muted mb-3">
                            Khi bạn ký, hợp đồng sẽ có hiệu lực và hóa đơn sẽ được tạo tự động.
                            Vui lòng đọc kỹ nội dung trước khi xác nhận.
                        </p>
                        <form action="{{ route('client.contracts.sign', $contract->id) }}" method="POST"
                              onsubmit="return confirm('Bạn xác nhận ký hợp đồng này?')">
                            @csrf
                            <button type="submit" class="btn btn-warning fw-semibold px-4">
                                <i class="bx bx-pen me-1"></i> Xác nhận ký hợp đồng
                            </button>
                        </form>
                    </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- Hóa đơn liên quan --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <h6 class="fw-semibold mb-3">
                        <i class="bx bx-receipt text-primary me-2"></i>Hóa đơn
                    </h6>

                    @forelse($contract->invoices as $invoice)
                    <div class="p-3 rounded-3 mb-3 border" style="background:#f9f9f7;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <code class="text-primary">{{ $invoice->code }}</code>
                            @php
                                $iStatus = [1=>'Đã thanh toán', 2=>'Chờ thanh toán', 3=>'Chưa thanh toán'];
                                $iColor  = [1=>'success', 2=>'warning', 3=>'danger'];
                            @endphp
                            <span class="badge bg-{{ $iColor[$invoice->status->value ?? $invoice->status] ?? 'secondary' }}">
                                {{ $iStatus[$invoice->status->value ?? $invoice->status] ?? '—' }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between small text-muted mb-1">
                            <span>Tổng tiền</span>
                            <span class="fw-semibold text-dark">{{ number_format($invoice->total_amount, 0, ',', '.') }} ₫</span>
                        </div>
                        <div class="d-flex justify-content-between small text-muted mb-2">
                            <span>Đã thanh toán</span>
                            <span class="fw-semibold text-success">{{ number_format($invoice->paid_amount, 0, ',', '.') }} ₫</span>
                        </div>
                        <div class="d-flex justify-content-between small text-muted mb-3">
                            <span>Hạn thanh toán</span>
                            <span class="fw-semibold @if($invoice->due_date < now() && ($invoice->status->value ?? $invoice->status) != 1) text-danger @endif">
                                {{ $invoice->due_date->format('d/m/Y') }}
                            </span>
                        </div>
                        <a href="{{ route('client.invoices.show', $invoice->id) }}"
                           class="btn btn-sm btn-outline-primary w-100">
                            Xem & Thanh toán
                        </a>
                    </div>
                    @empty
                    <div class="text-center py-4 text-muted">
                        <i class="bx bx-receipt" style="font-size:36px;opacity:.4;"></i>
                        <p class="small mt-2 mb-0">Hóa đơn sẽ được tạo sau khi bạn ký hợp đồng</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection