@extends('client.layouts.master')
@section('title')Đăng ký: {{ $service->name }}@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('services.index') }}">Dịch vụ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('services.show', $service->id) }}">{{ Str::limit($service->name, 30) }}</a></li>
            <li class="breadcrumb-item active">Đăng ký</li>
        </ol>
    </nav>

    <div class="row g-4">

        {{-- Form đăng ký --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-transparent border-0 p-4 pb-0">
                    <h5 class="fw-semibold mb-0">
                        <i class="bx bx-file-blank text-primary me-2"></i>Thông tin đăng ký dịch vụ
                    </h5>
                    <p class="text-muted small mt-1 mb-0">Điền thông tin để tạo hợp đồng. Hợp đồng sẽ ở trạng thái Nháp cho đến khi bạn ký.</p>
                </div>
                <div class="card-body p-4">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('client.services.store', $service->id) }}" method="POST">
                        @csrf

                        {{-- Số lượng --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Số lượng <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="number" name="quantity" step="0.1" min="0.1"
                                       value="{{ old('quantity', 1) }}"
                                       class="form-control @error('quantity') is-invalid @enderror"
                                       id="qty-input"
                                       oninput="calcTotal()">
                                <span class="input-group-text">{{ $service->unit }}</span>
                            </div>
                            @error('quantity')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        {{-- Thời gian --}}
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-semibold">Ngày bắt đầu <span class="text-danger">*</span></label>
                                <input type="date" name="start_date" value="{{ old('start_date', now()->addDay()->format('Y-m-d')) }}"
                                       min="{{ now()->format('Y-m-d') }}"
                                       class="form-control @error('start_date') is-invalid @enderror">
                                @error('start_date')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold">Ngày kết thúc <span class="text-danger">*</span></label>
                                <input type="date" name="end_date" value="{{ old('end_date', now()->addMonths(3)->format('Y-m-d')) }}"
                                       class="form-control @error('end_date') is-invalid @enderror">
                                @error('end_date')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Thông tin liên hệ (nếu chưa có customer) --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tên công ty / cá nhân</label>
                            <input type="text" name="company_name"
                                   value="{{ old('company_name', auth()->user()->name) }}"
                                   class="form-control" placeholder="Tên công ty hoặc tên cá nhân">
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-semibold">Số điện thoại</label>
                                <input type="text" name="phone" value="{{ old('phone') }}"
                                       class="form-control" placeholder="0909 xxx xxx">
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold">Địa chỉ</label>
                                <input type="text" name="address" value="{{ old('address') }}"
                                       class="form-control" placeholder="Địa chỉ liên hệ">
                            </div>
                        </div>

                        {{-- Ghi chú --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Yêu cầu thêm</label>
                            <textarea name="notes" rows="3" class="form-control"
                                      placeholder="Mô tả yêu cầu cụ thể, thời gian mong muốn...">{{ old('notes') }}</textarea>
                        </div>

                        <div class="d-grid gap-2 d-md-flex">
                            <button type="submit" class="btn btn-primary btn-lg flex-fill">
                                <i class="bx bx-send me-1"></i> Gửi đăng ký
                            </button>
                            <a href="{{ route('services.show', $service->id) }}" class="btn btn-outline-secondary btn-lg">
                                Hủy
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Tóm tắt dịch vụ --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm" style="border-radius: 12px; position: sticky; top: 80px;">
                <div class="card-body p-4">
                    <h6 class="fw-semibold mb-3">Tóm tắt đơn hàng</h6>

                    @if($service->image_url)
                        <img src="{{ Storage::url($service->image_url) }}" alt="{{ $service->name }}"
                             class="w-100 rounded-3 mb-3" style="max-height: 160px; object-fit: cover;">
                    @endif

                    <h5 class="fw-semibold mb-1">{{ $service->name }}</h5>
                    <span class="badge bg-label-primary mb-3">{{ $service->unit }}</span>

                    <hr>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Đơn giá</span>
                        <span class="fw-semibold" id="unit-price">
                            {{ number_format($service->base_price, 0, ',', '.') }} ₫
                        </span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Số lượng</span>
                        <span class="fw-semibold" id="qty-display">1 {{ $service->unit }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Tạm tính</span>
                        <span class="fw-semibold" id="subtotal-display">
                            {{ number_format($service->base_price, 0, ',', '.') }} ₫
                        </span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">VAT (10%)</span>
                        <span class="fw-semibold" id="vat-display">
                            {{ number_format($service->base_price * 0.1, 0, ',', '.') }} ₫
                        </span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">Tổng cộng</span>
                        <span class="fw-bold text-success fs-5" id="total-display">
                            {{ number_format($service->base_price * 1.1, 0, ',', '.') }} ₫
                        </span>
                    </div>

                    <div class="alert alert-info mt-3 mb-0 small">
                        <i class="bx bx-info-circle me-1"></i>
                        Đây là báo giá ước tính. Giá chính thức sẽ được xác nhận trong hợp đồng.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const basePrice = {{ $service->base_price }};
const unit = '{{ $service->unit }}';

function fmt(n) {
    return new Intl.NumberFormat('vi-VN').format(Math.round(n)) + ' ₫';
}

function calcTotal() {
    const qty = parseFloat(document.getElementById('qty-input').value) || 1;
    const sub  = basePrice * qty;
    const vat  = sub * 0.1;
    const total = sub + vat;

    document.getElementById('qty-display').textContent     = qty + ' ' + unit;
    document.getElementById('subtotal-display').textContent = fmt(sub);
    document.getElementById('vat-display').textContent      = fmt(vat);
    document.getElementById('total-display').textContent    = fmt(total);
}
</script>
@endpush