@extends('client.layouts.master')
@section('title')Danh mục Dịch vụ@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">Dịch vụ của xưởng CNTT</h4>
                <p class="text-muted mb-0">Chọn dịch vụ phù hợp và đăng ký ngay</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bx bx-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            @forelse($services as $service)
                <div class="col-sm-6 col-xl-4">
                    <div class="card h-100 shadow-sm border-0" style="transition: transform .2s;"
                        onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">

                        {{-- Ảnh dịch vụ --}}
                        <div style="height: 200px; overflow: hidden; border-radius: 8px 8px 0 0; background: #f1f0e8;">
                            @if($service->image_url)
                                <img src="{{ Storage::url($service->image_url) }}" alt="{{ $service->name }}" class="w-100 h-100"
                            style="object-fit: cover;"> 
                            @else
                                    <div class="d-flex align-items-center justify-content-center h-100">
                                        <i class="bx bx-code-alt" style="font-size: 56px; color: #c4b5fd;"></i>
                                    </div>
                                @endif
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-semibold mb-2">{{ $service->name }}</h5>

                            <p class="card-text text-muted small mb-3" style="line-height: 1.6; flex: 1;">
                                {{ Str::limit(strip_tags($service->description), 100) }}
                            </p>

                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <div>
                                    @if($service->base_price > 0)
                                        <span class="fw-bold text-success fs-6">
                                            {{ number_format($service->base_price, 0, ',', '.') }} ₫
                                        </span>
                                        <span class="text-muted small">/ {{ $service->unit }}</span>
                                    @else
                                        <span class="badge bg-label-secondary">Giá thỏa thuận</span>
                                    @endif
                                </div>
                                <a href="{{ route('services.show', $service->id) }}" class="btn btn-sm btn-primary">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bx bx-package" style="font-size: 64px; color: #d3d1c7;"></i>
                    <p class="text-muted mt-3">Chưa có dịch vụ nào.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $services->links() }}
        </div>
    </div>
@endsection