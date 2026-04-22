@extends('client.layouts.master')
@section('title')Hợp đồng của tôi@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Hợp đồng của tôi</h4>
        <a href="{{ route('services.index') }}" class="btn btn-primary btn-sm">
            <i class="bx bx-plus me-1"></i> Đăng ký dịch vụ mới
        </a>
    </div>

    @forelse($contracts as $contract)
    @php
        $statusMap = [1=>'Nháp', 2=>'Đang hiệu lực', 3=>'Hoàn thành', 4=>'Quá hạn', 5=>'Đã hủy'];
        $colorMap  = [1=>'secondary', 2=>'success', 3=>'info', 4=>'danger', 5=>'dark'];
    @endphp
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-start gap-3">
                        <div class="p-2 rounded-3" style="background:#f0effe;">
                            <i class="bx bx-file-blank" style="font-size:24px;color:#7F77DD;"></i>
                        </div>
                        <div>
                            <h6 class="fw-semibold mb-1">{{ $contract->title }}</h6>
                            <code class="text-muted small">{{ $contract->code }}</code>
                            <div class="mt-1">
                                <span class="badge bg-{{ $colorMap[$contract->status] ?? 'secondary' }}">
                                    {{ $statusMap[$contract->status] ?? '—' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mt-3 mt-md-0">
                    <div class="small text-muted mb-1">Giá trị hợp đồng</div>
                    <div class="fw-bold text-success">{{ number_format($contract->total_value, 0, ',', '.') }} ₫</div>
                    <div class="small text-muted mt-1">
                        {{ $contract->invoices->count() }} hóa đơn
                    </div>
                </div>
                <div class="col-md-3 mt-3 mt-md-0 text-md-end">
                    <div class="small text-muted mb-2">
                        {{ $contract->start_date?->format('d/m/Y') }} — {{ $contract->end_date?->format('d/m/Y') }}
                    </div>
                    <a href="{{ route('client.contracts.show', $contract->id) }}"
                       class="btn btn-sm btn-outline-primary">
                        Xem chi tiết
                    </a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="card border-0 shadow-sm text-center py-5">
        <div class="card-body">
            <i class="bx bx-file-blank" style="font-size:64px;color:#d3d1c7;"></i>
            <h5 class="mt-3 text-muted">Bạn chưa có hợp đồng nào</h5>
            <a href="{{ route('services.index') }}" class="btn btn-primary mt-2">Đăng ký dịch vụ ngay</a>
        </div>
    </div>
    @endforelse

    <div class="mt-3">{{ $contracts->links() }}</div>
</div>
@endsection