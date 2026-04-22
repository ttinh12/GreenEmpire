@extends('client.layouts.master')
@section('title')Dịch vụ của tôi@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Dịch vụ của tôi</h4>
            <p class="text-muted mb-0">Danh sách hợp đồng và hóa đơn dịch vụ bạn đã đăng ký</p>
        </div>
        <a href="{{ route('services.index') }}" class="btn btn-primary btn-sm">
            <i class="bx bx-plus me-1"></i> Đăng ký thêm
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            <i class="bx bx-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($contracts->isEmpty())
        <div class="card border-0 shadow-sm text-center py-5">
            <div class="card-body">
                <i class="bx bx-package" style="font-size:64px;color:#d3d1c7;"></i>
                <h5 class="mt-3 text-muted fw-semibold">Bạn chưa đăng ký dịch vụ nào</h5>
                <p class="text-muted small">Khám phá các dịch vụ CNTT và bắt đầu ngay hôm nay.</p>
                <a href="{{ route('services.index') }}" class="btn btn-primary mt-2">Xem danh sách dịch vụ</a>
            </div>
        </div>
    @else
        @foreach($contracts as $contract)
        @php
            $statusMap  = [1=>'Nháp', 2=>'Đang hiệu lực', 3=>'Hoàn thành', 4=>'Quá hạn', 5=>'Đã hủy'];
            $colorMap   = [1=>'secondary', 2=>'success', 3=>'info', 4=>'danger', 5=>'dark'];
            $iconMap    = [1=>'bx-edit', 2=>'bx-check-shield', 3=>'bx-badge-check', 4=>'bx-error', 5=>'bx-x-circle'];
        @endphp

        <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">

            {{-- Header hợp đồng --}}
            <div class="card-header border-0 p-4 pb-3" style="background:#f9f9f7;border-radius:12px 12px 0 0;">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-2 rounded-3" style="background:#ede9fe;">
                                <i class="bx bx-file-blank" style="font-size:22px;color:#7F77DD;"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold mb-0">{{ $contract->title }}</h6>
                                <div class="d-flex align-items-center gap-2 mt-1">
                                    <code class="text-muted" style="font-size:12px;">{{ $contract->code }}</code>
                                    <span class="badge bg-{{ $colorMap[$contract->status] ?? 'secondary' }}">
                                        <i class="bx {{ $iconMap[$contract->status] ?? 'bx-circle' }} me-1"></i>
                                        {{ $statusMap[$contract->status] ?? '—' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mt-2 mt-md-0">
                        <div class="small text-muted mb-0">Giá trị hợp đồng</div>
                        <div class="fw-bold text-success">{{ number_format($contract->total_value, 0, ',', '.') }} ₫</div>
                        <div class="small text-muted">
                            {{ $contract->start_date?->format('d/m/Y') }} — {{ $contract->end_date?->format('d/m/Y') }}
                        </div>
                    </div>
                    <div class="col-md-3 mt-2 mt-md-0 text-md-end d-flex flex-wrap justify-content-md-end gap-2">
                        {{-- Nút ký nếu còn nháp --}}
                        @if($contract->status === 1)
                            <a href="{{ route('client.contracts.show', $contract->id) }}"
                               class="btn btn-warning btn-sm fw-semibold">
                                <i class="bx bx-pen me-1"></i> Ký hợp đồng
                            </a>
                        @endif

                        {{-- Xem hợp đồng --}}
                        <a href="{{ route('client.contracts.show', $contract->id) }}"
                           class="btn btn-outline-secondary btn-sm">
                            <i class="bx bx-show me-1"></i> Xem
                        </a>

                        {{-- Tải PDF hợp đồng --}}
                        @if($contract->status !== 1)
                            <a href="{{ route('contracts.pdf', $contract->id) }}"
                               target="_blank"
                               class="btn btn-outline-primary btn-sm">
                                <i class="bx bxs-file-pdf me-1"></i> PDF
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Hóa đơn thuộc hợp đồng --}}
            @if($contract->invoices->count() > 0)
            <div class="card-body p-0">
                <div class="px-4 pt-3 pb-1">
                    <small class="text-muted fw-semibold text-uppercase" style="letter-spacing:.05em;">
                        <i class="bx bx-receipt me-1"></i> Hóa đơn
                    </small>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0" style="font-size:13px;">
                        <thead style="background:#f9f9f7;">
                            <tr>
                                <th class="ps-4 fw-semibold text-muted border-0">Mã hóa đơn</th>
                                <th class="fw-semibold text-muted border-0">Ngày lập</th>
                                <th class="fw-semibold text-muted border-0">Hạn TT</th>
                                <th class="fw-semibold text-muted border-0">Tổng tiền</th>
                                <th class="fw-semibold text-muted border-0">Tiến độ</th>
                                <th class="fw-semibold text-muted border-0">Trạng thái</th>
                                <th class="pe-4 fw-semibold text-muted border-0 text-end">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contract->invoices as $invoice)
                            @php
                                $sv = $invoice->status instanceof \App\Enums\InvoiceStatus
                                    ? $invoice->status->value : $invoice->status;
                                $iStatusMap = [1=>'Đã thanh toán', 2=>'Chờ thanh toán', 3=>'Chưa thanh toán'];
                                $iColorMap  = [1=>'success', 2=>'warning', 3=>'danger'];
                                $remaining  = max(0, $invoice->total_amount - $invoice->paid_amount);
                                $pct = $invoice->total_amount > 0
                                    ? min(100, round($invoice->paid_amount / $invoice->total_amount * 100))
                                    : 0;
                                $overdue = $sv != 1 && $invoice->due_date < now();
                            @endphp
                            <tr>
                                <td class="ps-4">
                                    <code class="text-primary fw-semibold">{{ $invoice->code }}</code>
                                </td>
                                <td>{{ $invoice->issue_date->format('d/m/Y') }}</td>
                                <td class="{{ $overdue ? 'text-danger fw-semibold' : '' }}">
                                    {{ $invoice->due_date->format('d/m/Y') }}
                                    @if($overdue) <span class="badge bg-danger ms-1">Quá hạn</span> @endif
                                </td>
                                <td class="fw-semibold">{{ number_format($invoice->total_amount, 0, ',', '.') }} ₫</td>
                                <td style="min-width:100px;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="progress flex-grow-1" style="height:5px;">
                                            <div class="progress-bar bg-success" style="width:{{ $pct }}%"></div>
                                        </div>
                                        <small class="text-muted">{{ $pct }}%</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $iColorMap[$sv] ?? 'secondary' }}">
                                        {{ $iStatusMap[$sv] ?? '—' }}
                                    </span>
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="d-flex justify-content-end gap-1">
                                        {{-- Thanh toán nếu chưa xong --}}
                                        @if($sv != 1)
                                            <a href="{{ route('client.invoices.show', $invoice->id) }}"
                                               class="btn btn-sm btn-primary">
                                                <i class="bx bx-credit-card me-1"></i> Thanh toán
                                            </a>
                                        @endif

                                        {{-- Xem hóa đơn --}}
                                        <a href="{{ route('client.invoices.show', $invoice->id) }}"
                                           class="btn btn-sm btn-outline-secondary">
                                            <i class="bx bx-show"></i>
                                        </a>

                                        {{-- PDF hóa đơn --}}
                                        <a href="{{ route('invoices.pdf', $invoice->id) }}"
                                           target="_blank"
                                           class="btn btn-sm btn-outline-danger"
                                           title="Tải PDF hóa đơn">
                                            <i class="bx bxs-file-pdf"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @else
            <div class="card-body text-center py-3 text-muted small" style="background:#fafaf8;border-radius:0 0 12px 12px;">
                <i class="bx bx-info-circle me-1"></i>
                @if($contract->status === 1)
                    Hóa đơn sẽ được tạo tự động sau khi bạn <a href="{{ route('client.contracts.show', $contract->id) }}">ký hợp đồng</a>.
                @else
                    Chưa có hóa đơn cho hợp đồng này.
                @endif
            </div>
            @endif

        </div>
        @endforeach

        <div class="mt-3">{{ $contracts->links() }}</div>
    @endif

</div>
@endsection