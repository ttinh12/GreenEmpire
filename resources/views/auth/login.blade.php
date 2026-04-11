<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - GreenEmpire</title>
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
                                <span class="app-brand-text demo text-body fw-bolder text-uppercase">Login</span>
                            </a>
                        </div>  
                        <form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3 text-start"> <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email') }}" placeholder="Nhập email của bạn" autofocus required />
                                @error('email')
                                    <p class="text-danger small mt-1 text-start">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 form-password-toggle text-start">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Mật khẩu</label>
                                    <a href="{{ route('password.request') }}">
                                        <small>Quên mật khẩu?</small>
                                    </a>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="****"
                                        required />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>

                            <div class="mb-3 text-start">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember_me" name="remember" />
                                    <label class="form-check-label" for="remember_me"> Ghi nhớ đăng nhập </label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Đăng nhập</button>
                            </div>
                        </form>

                        <p class="text-center">
                            <span>Bạn mới tham gia?</span>
                            <a href="{{ route('register') }}">
                                <span>Tạo tài khoản mới</span>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('client.layouts.partials.scripts')
</body>

</html>