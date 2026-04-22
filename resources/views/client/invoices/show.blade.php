@extends('client.layouts.master')
@section('title')Hóa đơn: {{ $invoice->code }}@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.invoices.index') }}">Hóa đơn của tôi</a></li>
            <li class="breadcrumb-item active">{{ $invoice->code }}</li>
        </ol>
    </nav>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            <i class="bx bx-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">

        {{-- Chi tiết hóa đơn --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-4">

                    {{-- Header --}}
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h5 class="fw-bold mb-1">Hóa đơn</h5>
                            <code class="text-primary fs-6">{{ $invoice->code }}</code>
                        </div>
                        @php
                            $statusVal = $invoice->status instanceof \App\Enums\InvoiceStatus
                                ? $invoice->status->value
                                : $invoice->status;
                            $statusMap = [1=>'Đã thanh toán', 2=>'Chờ thanh toán', 3=>'Chưa thanh toán'];
                            $colorMap  = [1=>'success', 2=>'warning', 3=>'danger'];
                        @endphp
                        <span class="badge bg-{{ $colorMap[$statusVal] ?? 'secondary' }} fs-6 px-3 py-2">
                            {{ $statusMap[$statusVal] ?? '—' }}
                        </span>
                    </div>

                    {{-- Thông tin --}}
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="small text-muted mb-1">Hợp đồng</div>
                            <div class="fw-semibold">
                                <a href="{{ route('client.contracts.show', $invoice->contract_id) }}" class="text-decoration-none">
                                    {{ $invoice->contract?->code ?? '—' }}
                                </a>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="small text-muted mb-1">Ngày lập</div>
                            <div class="fw-semibold">{{ $invoice->issue_date->format('d/m/Y') }}</div>
                        </div>
                        <div class="col-6">
                            <div class="small text-muted mb-1">Hạn thanh toán</div>
                            <div class="fw-semibold @if($invoice->due_date < now() && $statusVal != 1) text-danger @endif">
                                {{ $invoice->due_date->format('d/m/Y') }}
                                @if($invoice->due_date < now() && $statusVal != 1)
                                    <span class="badge bg-danger ms-1">Quá hạn</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Bảng tổng tiền --}}
                    <div class="table-responsive mb-4">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <td class="text-muted ps-0">Tạm tính</td>
                                    <td class="text-end fw-semibold pe-0">{{ number_format($invoice->subtotal, 0, ',', '.') }} ₫</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-0">VAT ({{ $invoice->vat_rate }}%)</td>
                                    <td class="text-end fw-semibold pe-0">{{ number_format($invoice->vat_amount, 0, ',', '.') }} ₫</td>
                                </tr>
                                <tr class="border-top">
                                    <td class="fw-bold ps-0 pt-3">Tổng tiền</td>
                                    <td class="text-end fw-bold text-success fs-5 pe-0 pt-3">{{ number_format($invoice->total_amount, 0, ',', '.') }} ₫</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-0">Đã thanh toán</td>
                                    <td class="text-end fw-semibold text-success pe-0">{{ number_format($invoice->paid_amount, 0, ',', '.') }} ₫</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold ps-0">Còn lại</td>
                                    <td class="text-end fw-bold text-danger fs-6 pe-0">
                                        {{ number_format($invoice->total_amount - $invoice->paid_amount, 0, ',', '.') }} ₫
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Lịch sử thanh toán --}}
                    @if($invoice->payments->count() > 0)
                    <h6 class="fw-semibold mb-3">Lịch sử thanh toán</h6>
                    @foreach($invoice->payments as $payment)
                    @php
                        $methods = [1=>'Chuyển khoản', 2=>'Tiền mặt', 3=>'Séc', 4=>'Khác'];
                    @endphp
                    <div class="d-flex justify-content-between align-items-center p-3 rounded-3 mb-2"
                         style="background:#e1f5ee;">
                        <div>
                            <div class="fw-semibold text-success">{{ number_format($payment->amount, 0, ',', '.') }} ₫</div>
                            <div class="small text-muted">
                                {{ $payment->payment_date->format('d/m/Y') }} •
                                {{ $methods[$payment->method] ?? 'Khác' }}
                                @if($payment->reference) • <code>{{ $payment->reference }}</code> @endif
                            </div>
                        </div>
                        <i class="bx bx-check-circle text-success fs-4"></i>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>

        {{-- Form thanh toán --}}
        <div class="col-lg-5">
            @if($statusVal != 1)
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <h6 class="fw-semibold mb-3">
                        <i class="bx bx-credit-card text-primary me-2"></i>Ghi nhận thanh toán
                    </h6>

                    @if($errors->any())
                        <div class="alert alert-danger small">
                            @foreach($errors->all() as $err)<div>{{ $err }}</div>@endforeach
                        </div>
                    @endif

                    <form action="{{ route('client.invoices.pay', $invoice->id) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Số tiền thanh toán (₫) <span class="text-danger">*</span></label>
                            <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror"
                                   value="{{ old('amount', $invoice->total_amount - $invoice->paid_amount) }}"
                                   min="1000"
                                   max="{{ $invoice->total_amount - $invoice->paid_amount }}"
                                   step="1000">
                            <div class="small text-muted mt-1">
                                Tối đa: {{ number_format($invoice->total_amount - $invoice->paid_amount, 0, ',', '.') }} ₫
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Phương thức <span class="text-danger">*</span></label>
                            <select name="method" class="form-select">
                                <option value="1" {{ old('method') == 1 ? 'selected' : '' }}>Chuyển khoản ngân hàng</option>
                                <option value="2" {{ old('method') == 2 ? 'selected' : '' }}>Tiền mặt</option>
                                <option value="3" {{ old('method') == 3 ? 'selected' : '' }}>Séc</option>
                                <option value="4" {{ old('method') == 4 ? 'selected' : '' }}>Khác</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Số tham chiếu</label>
                            <input type="text" name="reference" class="form-control"
                                   value="{{ old('reference') }}"
                                   placeholder="Mã giao dịch ngân hàng...">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Ghi chú</label>
                            <textarea name="notes" rows="2" class="form-control"
                                      placeholder="Ghi chú thêm...">{{ old('notes') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-success w-100 fw-semibold"
                                onclick="return confirm('Xác nhận ghi nhận thanh toán?')">
                            <i class="bx bx-check me-1"></i> Xác nhận thanh toán
                        </button>
                    </form>

                    <div class="alert alert-warning small mt-3 mb-0">
                        <i class="bx bx-info-circle me-1"></i>
                        Sau khi ghi nhận, đội ngũ sẽ xác minh và cập nhật trạng thái hóa đơn.
                    </div>
                </div>
            </div>
            @else
            <div class="card border-0 shadow-sm text-center py-5" style="border-radius: 12px;">
                <div class="card-body">
                    <i class="bx bx-check-circle text-success" style="font-size:56px;"></i>
                    <h5 class="mt-3 fw-semibold text-success">Đã thanh toán đầy đủ</h5>
                    <p class="text-muted small">Hóa đơn này đã được thanh toán hoàn tất.</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection