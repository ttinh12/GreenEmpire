@extends('client.layouts.master')

@section('title')
    Chi tiết: {{ $service->name }}
@endsection

@section('content')
    <div class="container mt-5 mb-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('services.index') }}">Danh mục</a></li>
                <li class="breadcrumb-item active text-success" aria-current="page">{{ $service->name }}</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    @if(isset($service->image_url))
                        <img src="{{ asset('storage/' . $service->image_url) }}" class="img-fluid" alt="{{ $service->name }}">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                            <i class="fas fa-seedling fa-5x text-success"></i>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <h1 class="display-5 fw-bold text-dark">{{ $service->name }}</h1>
                <p class="badge bg-success fs-6 mb-3">Dịch vụ Nông nghiệp</p>

                <div class="price-box mb-4 p-3 bg-light rounded border-start border-success border-4">
                    <span class="text-muted text-decoration-line-through">Giá tham khảo:
                        {{ number_format($service->base_price * 1.1) }} VNĐ</span>
                    <h3 class="text-danger fw-bold">
                        {{ number_format($service->base_price) }} VNĐ <small class="text-muted">/
                            {{ $service->unit }}</small>
                    </h3>
                </div>

                <div class="description mb-4">
                    <h5 class="fw-bold border-bottom pb-2">Mô tả chi tiết:</h5>
                    <p class="text-secondary" style="line-height: 1.8;">
                        {{ $service->description }}
                    </p>
                    <p class="text-secondary italic">
                        <i class="fas fa-info-circle"></i>
                        Lưu ý: Giá trên chưa bao gồm VAT (10%) và có thể thay đổi tùy theo quy mô diện tích canh tác.
                    </p>
                </div>

                <div class="action-buttons d-grid gap-2 d-md-flex">
                    <button type="button" class="btn btn-success btn-lg px-5 shadow">
                        <i class="fas fa-file-contract"></i> Đăng ký dịch vụ ngay
                    </button>

                    <a href="{{ route('services.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                        Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-4">Tại sao nên chọn dịch vụ tại GreenEmpire?</h4>
                        <div class="row text-center">
                            <div class="col-md-4 mb-3">
                                <i class="fas fa-check-circle text-success fa-2x mb-2"></i>
                                <h6>Chất lượng đảm bảo</h6>
                                <p class="small text-muted">Mọi giống cây và vật tư đều được kiểm định kỹ càng.</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <i class="fas fa-user-tie text-success fa-2x mb-2"></i>
                                <h6>Tư vấn chuyên gia</h6>
                                <p class="small text-muted">Đội ngũ kỹ sư hỗ trợ 24/7 qua hệ thống Ticket.</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <i class="fas fa-handshake text-success fa-2x mb-2"></i>
                                <h6>Hợp đồng minh bạch</h6>
                                <p class="small text-muted">Pháp lý rõ ràng, bảo vệ quyền lợi nông dân.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection