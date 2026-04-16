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

        {{-- DÙNG 1 FORM DUY NHẤT CHO CẢ AVATAR VÀ TÊN --}}
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
                                    <span>Chọn ảnh mới</span>
                                    <input type="file" id="upload" name="avatar" hidden accept="image/png, image/jpeg">
                                </label>
                                <p class="text-muted small">JPG hoặc PNG tối đa 2MB</p>
                            </div>

                            <hr>
                            <h6 class="mb-1">{{ auth()->user()->name }}</h6>
                            <small class="text-muted d-block mb-2">{{ auth()->user()->email }}</small>
                            <span class="badge bg-label-primary">
                                {{ auth()->user()->getRoleNames()->first() ?? ucfirst(auth()->user()->role) }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- CỘT PHẢI: THÔNG TIN VÀ MẬT KHẨU --}}
                <div class="col-lg-8">
                    {{-- CARD 1: THÔNG TIN CÁ NHÂN --}}
                    <div class="card mb-4">
                        <h5 class="card-header border-bottom">Thông tin cá nhân</h5>
                        <div class="card-body pt-4">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Họ và tên</label>
                                    <input class="form-control" type="text" id="name" name="name"
                                        value="{{ old('name', auth()->user()->name) }}">
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
        </form> {{-- ĐÓNG FORM CHÍNH Ở ĐÂY --}}

        {{-- CARD 2: ĐỔI MẬT KHẨU (FORM RIÊNG BIỆT) --}}
        <div class="card">
            <h5 class="card-header border-bottom">Đổi mật khẩu</h5>
            <div class="card-body pt-4">
                <form method="POST" action="{{ route('profile.password.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Mật khẩu hiện tại</label>
                            <input class="form-control" type="password" name="current_password" placeholder="****">
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Mật khẩu mới</label>
                            <input class="form-control" type="password" name="password" placeholder="****">
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Xác nhận mật khẩu</label>
                            <input class="form-control" type="password" name="password_confirmation" placeholder="****">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning">Cập nhật mật khẩu</button>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. CHỈ PREVIEW ẢNH (KHÔNG SUBMIT)
            const uploadInput = document.getElementById('upload');
            const avatarImg = document.getElementById('uploadedAvatar');

            if (uploadInput) {
                uploadInput.onchange = () => {
                    const [file] = uploadInput.files;
                    if (file) {
                        // Hiện ảnh lên cho người dùng xem trước ngay lập tức
                        avatarImg.src = URL.createObjectURL(file);
                    }
                };
            }

            // 2. Hiệu ứng loading khi nhấn nút "Lưu thay đổi"
            const profileForm = document.getElementById('formAccountSettings');
            if (profileForm) {
                profileForm.onsubmit = function () {
                    document.getElementById('btnText').innerText = 'Đang lưu...';
                    document.getElementById('btnLoading').classList.remove('d-none');
                    document.getElementById('btnSubmit').classList.add('disabled');
                };
            }

            // 3. Tự đóng Toast
            const toastElement = document.querySelector('.bs-toast');
            if (toastElement) {
                setTimeout(() => { toastElement.classList.remove('show'); }, 3000);
            }
        });
    </script>
@endsection