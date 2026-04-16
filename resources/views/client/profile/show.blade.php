@extends('client.layouts.master')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted">Tài khoản /</span> Thông tin cá nhân
        </h4>

        <div class="row">
            {{-- CỘT TRÁI: ẢNH ĐẠI DIỆN --}}
            <div class="col-lg-4">
                <div class="card mb-4 text-center">
                    <div class="card-body">
                        <img src="{{ auth()->user()->avatar_url ? asset('storage/' . auth()->user()->avatar_url) : asset('assets/img/avatars/1.png') }}"
                            class="rounded-circle mb-3" width="120" height="120"
                            style="object-fit: cover; aspect-ratio: 1/1; border:1px solid #ddd;">

                        <h6 class="mb-1">{{ auth()->user()->name }}</h6>
                        <small class="text-muted d-block mb-3">{{ auth()->user()->email }}</small>

                        <span class="badge bg-label-primary mb-3">
                            {{ auth()->user()->getRoleNames()->first() ?? ucfirst(auth()->user()->role) }}
                        </span>
                        
                        <hr>
                        
                        <div class="d-grid gap-2">
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm">
                                <i class="bx bx-edit-alt me-1"></i> Chỉnh sửa hồ sơ
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CỘT PHẢI: CHI TIẾT THÔNG TIN --}}
            <div class="col-lg-8">
                <div class="card mb-4">
                    <h5 class="card-header">Chi tiết hồ sơ</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label text-uppercase small fw-bold">Họ và tên</label>
                                <p class="form-control-plaintext border-bottom pb-2">
                                    {{ auth()->user()->name }}
                                </p>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label text-uppercase small fw-bold">Địa chỉ Email</label>
                                <p class="form-control-plaintext border-bottom pb-2">
                                    {{ auth()->user()->email }}
                                </p>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label text-uppercase small fw-bold">Ngày tham gia</label>
                                <p class="form-control-plaintext border-bottom pb-2">
                                    {{ auth()->user()->created_at->format('d/m/Y') }}
                                </p>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label text-uppercase small fw-bold">Trạng thái tài khoản</label>
                                <p class="form-control-plaintext border-bottom pb-2 text-success">
                                    <span class="badge badge-dot bg-success me-1"></span> Hoạt động
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- PHẦN PHỤ: BẢO MẬT (Tùy chọn) --}}
                <div class="card">
                    <h5 class="card-header">Bảo mật & Hoạt động</h5>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <i class="bx bx-lock-alt me-2"></i>
                                    <span>Mật khẩu</span>
                                </div>
                                <a href="{{ route('profile.edit') }}" class="text-primary small">Thay đổi</a>
                            </li>
                            <!-- <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <i class="bx bx-shield-quarter me-2"></i>
                                    <span>Xác thực 2 lớp</span>
                                </div>
                                <span class="badge bg-label-secondary">Chưa kích hoạt</span>
                            </li> -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection