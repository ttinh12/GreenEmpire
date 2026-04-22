@extends('client.layouts.master')
@section('title'){{ $service->name }}@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('services.index') }}">Dịch vụ</a></li>
            <li class="breadcrumb-item active">{{ Str::limit($service->name, 40) }}</li>
        </ol>
    </nav>

    <div class="row g-4">

        {{-- Ảnh --}}
        <div class="col-md-5">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 12px;">
                @if($service->image_url)
                    <img src="{{ Storage::url($service->image_url) }}"
                         alt="{{ $service->name }}"
                         class="w-100"
                         style="max-height: 380px; object-fit: cover;">
                @else
                    <div class="d-flex align-items-center justify-content-center bg-light" style="height: 380px;">
                        <i class="bx bx-code-alt" style="font-size: 80px; color: #c4b5fd;"></i>
                    </div>
                @endif
            </div>
        </div>

        {{-- Thông tin --}}
        <div class="col-md-7">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body p-4">

                    <h3 class="fw-bold mb-2">{{ $service->name }}</h3>
                    <span class="badge bg-label-primary mb-3">Dịch vụ CNTT</span>

                    {{-- Giá --}}
                    <div class="p-3 rounded-3 mb-4" style="background: #f9f9f7; border-left: 4px solid #7F77DD;">
                        @if($service->base_price > 0)
                            <div class="text-muted small mb-1">Giá niêm yết</div>
                            <h4 class="text-success fw-bold mb-0">
                                {{ number_format($service->base_price, 0, ',', '.') }} ₫
                                <small class="text-muted fs-6 fw-normal">/ {{ $service->unit }}</small>
                            </h4>
                            <small class="text-muted">(Chưa bao gồm VAT 10%)</small>
                        @else
                            <h5 class="text-muted mb-0">Giá thỏa thuận theo yêu cầu</h5>
                        @endif
                    </div>

                    {{-- Mô tả --}}
                    <div class="mb-4">
                        <h6 class="fw-semibold mb-2">Mô tả dịch vụ</h6>
                        <div class="text-muted" style="line-height: 1.8;">
                            {!! nl2br(strip_tags($service->description)) !!}
                        </div>
                    </div>

                    {{-- CTA --}}
                    <div class="d-grid gap-2 d-md-flex">
                        <a href="{{ route('client.services.register', $service->id) }}"
                           class="btn btn-primary btn-lg flex-fill">
                            <i class="bx bx-file-blank me-1"></i> Đăng ký dịch vụ
                        </a>
                        <a href="{{ route('services.index') }}" class="btn btn-outline-secondary btn-lg">
                            Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tại sao chọn chúng tôi --}}
    <div class="card border-0 shadow-sm mt-4" style="border-radius: 12px;">
        <div class="card-body p-4">
            <h5 class="fw-semibold mb-4">Tại sao chọn Xưởng CNTT?</h5>
            <div class="row text-center g-3">
                <div class="col-md-4">
                    <div class="p-3 rounded-3" style="background:#f0effe;">
                        <i class="bx bx-shield-check" style="font-size:32px;color:#7F77DD;"></i>
                        <h6 class="mt-2 fw-semibold">Chất lượng đảm bảo</h6>
                        <p class="small text-muted mb-0">Sản phẩm được kiểm tra nghiêm ngặt trước khi bàn giao</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 rounded-3" style="background:#e1f5ee;">
                        <i class="bx bx-support" style="font-size:32px;color:#1D9E75;"></i>
                        <h6 class="mt-2 fw-semibold">Hỗ trợ 24/7</h6>
                        <p class="small text-muted mb-0">Đội ngũ kỹ thuật hỗ trợ qua hệ thống Ticket</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 rounded-3" style="background:#faeeda;">
                        <i class="bx bx-receipt" style="font-size:32px;color:#BA7517;"></i>
                        <h6 class="mt-2 fw-semibold">Hợp đồng minh bạch</h6>
                        <p class="small text-muted mb-0">Pháp lý rõ ràng, có hóa đơn điện tử đầy đủ</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection