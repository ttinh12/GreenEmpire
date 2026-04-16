<!-- Navbar -->

<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">

    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <div class="navbar-nav align-items-center">
            <div class="nav-item d-flex align-items-center">
                    <!-- <i class="bx bx-search fs-4 lh-0"></i> -->
                <!-- <input type="text" class="form-control border-0 shadow-none" placeholder="Tìm kiếm..."
                    aria-label="Search..." /> -->
            </div>
        </div>
        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        {{-- Hiển thị ảnh đại diện ngoài Navbar --}}
                        <img src="{{ Auth::user()->avatar_url ? asset('storage/' . Auth::user()->avatar_url) : asset('assets/img/avatars/1.png') }}"
                            alt="Avatar" class="w-px-40 h-px-40 rounded-circle"
                            style="object-fit: cover; aspect-ratio: 1/1;" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        {{-- Hiển thị ảnh đại diện trong Dropdown --}}
                                        <img src="{{ Auth::user()->avatar_url ? asset('storage/' . Auth::user()->avatar_url) : asset('assets/img/avatars/1.png') }}"
                                            alt="Avatar" class="w-px-40 h-px-40 rounded-circle"
                                            style="object-fit: cover; aspect-ratio: 1/1;" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block">{{ Auth::user()->name }}</span>
                                    {{-- Lấy Role từ Spatie hoặc cột role trong DB --}}
                                    <small class="text-muted">
                                        {{ Auth::user()->getRoleNames()->first() ?? ucfirst(Auth::user()->role) }}
                                    </small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="bx bx-user me-2"></i>
                            <span class="align-middle">Hồ sơ của tôi</span>
                        </a>
                    </li>

                    {{-- Nếu là Admin thì hiện thêm link vào trang Quản trị --}}
                    @if(Auth::user()->hasAnyRole(['admin', 'super_admin']))
                        <li>
                            <a class="dropdown-item" href="/admin">
                                <i class="bx bx-cog me-2"></i>
                                <span class="align-middle">Trang Quản Trị</span>
                            </a>
                        </li>
                    @endif

                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        {{-- Form đăng xuất --}}
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
</nav><!-- / Navbar -->