@extends('client.layouts.master')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- 1. THÔNG BÁO TOAST --}}
        @if(session('success'))
            <div class="bs-toast toast show fade bg-success position-fixed top-0 end-0 m-3" style="z-index:9999;" role="alert">
                <div class="toast-header">
                    <i class="bx bx-check me-2"></i>
                    <div class="me-auto fw-semibold">Thông báo</div>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted">Cài đặt /</span> Tài khoản
        </h4>

        {{-- BẮT ĐẦU FORM CẬP NHẬT HỒ SƠ (BAO QUANH CẢ 2 CỘT) --}}
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="formAccountSettings">
            @csrf
            @method('PATCH')

            <div class="row">
                {{-- CỘT TRÁI: ẢNH ĐẠI DIỆN --}}
                <div class="col-lg-4">
                    <div class="card mb-4 text-center">
                        <div class="card-body">
                            <img src="{{ auth()->user()->avatar_url ? asset('storage/' . auth()->user()->avatar_url) : asset('assets/img/avatars/1.png') }}"
                                class="rounded-circle mb-3" width="120" height="120"
                                style="object-fit: cover; aspect-ratio: 1/1; border:1px solid #ddd;" id="uploadedAvatar">

                            <div>
                                <label for="upload" class="btn btn-primary btn-sm mb-2">
                                    <span>Tải ảnh mới</span>
                                    <input type="file" id="upload" name="avatar" hidden accept="image/png, image/jpeg">
                                </label>
                                <p class="text-muted small">JPG hoặc PNG tối đa 2MB</p>
                            </div>

                            @error('avatar')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror

                            <hr>

                            <h6 class="mb-1">{{ auth()->user()->name }}</h6>
                            <small class="text-muted d-block mb-2">{{ auth()->user()->email }}</small>

                            <span class="badge bg-label-primary">
                                {{ auth()->user()->getRoleNames()->first() ?? ucfirst(auth()->user()->role) }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- CỘT PHẢI: THÔNG TIN CHI TIẾT --}}
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <h5 class="card-header">Thông tin cá nhân</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Họ và tên</label>
                                    <input class="form-control @error('name') is-invalid @enderror" type="text" id="name"
                                        name="name" value="{{ old('name', auth()->user()->name) }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Địa chỉ Email</label>
                                    <input class="form-control" value="{{ auth()->user()->email }}" disabled
                                        style="background-color: #f5f5f5;">
                                </div>
                            </div>

                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary" id="btnSubmit">
                                    <span id="btnText">Lưu thay đổi</span>
                                    <span id="btnLoading" class="spinner-border spinner-border-sm d-none"
                                        role="status"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-lg-4 d-none d-lg-block"></div>
            <div class="col-lg-8">
                <div class="card">
                    <h5 class="card-header">Đổi mật khẩu</h5>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.password.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Mật khẩu hiện tại</label>
                                    <input class="form-control @error('current_password') is-invalid @enderror"
                                        type="password" name="current_password" placeholder="****">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Mật khẩu mới</label>
                                    <input class="form-control @error('password') is-invalid @enderror" type="password"
                                        name="password" placeholder="****">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Xác nhận mật khẩu</label>
                                    <input class="form-control" type="password" name="password_confirmation"
                                        placeholder="****">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-warning">Cập nhật mật khẩu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT TỔNG HỢP --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Preview ảnh ngay khi chọn file
            const uploadInput = document.getElementById('upload');
            const avatarImg = document.getElementById('uploadedAvatar');

            if (uploadInput) {
                uploadInput.onchange = () => {
                    const [file] = uploadInput.files;
                    if (file) {
                        avatarImg.src = URL.createObjectURL(file);
                    }
                };
            }

            // 2. Tự động đóng Toast thông báo sau 3 giây
            const toastElement = document.querySelector('.bs-toast');
            if (toastElement) {
                setTimeout(() => {
                    toastElement.classList.remove('show');
                }, 3000);
            }

            // 3. Hiệu ứng loading cho nút Submit Profile
            const profileForm = document.getElementById('formAccountSettings');
            if (profileForm) {
                profileForm.onsubmit = function () {
                    document.getElementById('btnText').innerText = 'Đang xử lý...';
                    document.getElementById('btnLoading').classList.remove('d-none');
                    document.getElementById('btnSubmit').classList.add('disabled');
                };
            }
        });
    </script>
@endsection