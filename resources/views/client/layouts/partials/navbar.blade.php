<!-- Navbar -->

<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="{{ Auth::user()->avatar_url ? asset('storage/' . Auth::user()->avatar_url) : asset('assets/img/avatars/1.png') }}"
                            alt class="w-px-40 h-auto rounded-circle" style="object-fit: cover; aspect-ratio: 1/1;" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('filament.admin.pages.dashboard') }}">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="{{ Auth::user()->avatar_url ? asset('storage/' . Auth::user()->avatar_url) : asset('assets/img/avatars/1.png') }}"
                                            class="w-px-40 h-auto rounded-circle"
                                            style="object-fit: cover; aspect-ratio: 1/1;" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block">{{ Auth::user()->name }}</span>
                                    <small class="text-muted">
                                        {{-- Hiển thị Role đầu tiên của User --}}
                                        {{ Auth::user()->getRoleNames()->first() ?? 'Thành viên' }}
                                    </small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        {{-- Link dẫn tới trang sửa Profile của Filament hoặc Route cá nhân --}}
                        <a class="dropdown-item" href="/admin/profile">
                            <i class="bx bx-user me-2"></i>
                            <span class="align-middle">Hồ sơ của tôi</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a class="dropdown-item" href="javascript:void(0);"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle">Đăng xuất</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<!-- / Navbar -->