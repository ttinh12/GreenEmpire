<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quên mật khẩu - GreenEmpire</title>
    @include('client.layouts.partials.head')
</head>
<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner" style="max-width: 400px; margin: 0 auto;">
                <div class="card">
                    <div class="card-body">
                        <div class="app-brand justify-content-center">
                            <a href="/" class="app-brand-link gap-2">
                                <span class="app-brand-text demo text-body fw-bolder text-uppercase">Forgot password</span>
                            </a>
                        </div>
                        @if (session('status'))
                            <div class="alert alert-success small mb-4" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form id="formAuthentication" class="mb-3" action="{{ route('password.email') }}" method="POST">
                            @csrf
                            <div class="mb-3 text-start">
                                <label for="email" class="form-label">Email</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    placeholder="Nhập email đã đăng ký"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                />
                                @error('email')
                                    <p class="text-danger small mt-1 text-start">{{ $message }}</p>
                                @enderror
                            </div>
                            <button class="btn btn-primary d-grid w-100" type="submit">Gửi link đặt lại mật khẩu</button>
                        </form>

                        <div class="text-center">
                            <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
                                <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                                Quay lại đăng nhập
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('client.layouts.partials.scripts')
</body>
</html>