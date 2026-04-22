<style>
    .app-brand-link {
        display: flex;
        align-items: center;
        justify-content: center;
        /* căn giữa ngang */
        width: 100%;
    }
</style>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <svg width="25" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g transform="translate(-27.000000, -15.000000)">
                            <g transform="translate(27.000000, 15.000000)">
                                <g transform="translate(0.000000, 8.000000)">
                                    <mask id="mask-2" fill="white">
                                        <use xlink:href="#path-1"></use>
                                    </mask>
                                    <use fill="#696cff" xlink:href="#path-1"></use>
                                </g>
                            </g>
                        </g>
                    </g>
                </svg>
            </span>
            <span class="app-brand-text fw-bold ms-2 text-uppercase" style="letter-spacing: 1px; font-size: 1.25rem;">
                FPT <span class="text-primary">Polytechnic</span>
            </span> </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        {{-- ── Tổng quan ── --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Tổng quan</span>
        </li>

        <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Bảng điều khiển</div>
            </a>
        </li>

        {{-- ── Hồ sơ ── --}}
        <li class="menu-item {{ request()->routeIs('profile.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user-circle"></i>
                <div>Hồ sơ của tôi</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('profile.show') ? 'active' : '' }}">
                    <a href="{{ route('profile.show') }}" class="menu-link">
                        <div>Thông tin cá nhân</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                    <a href="{{ route('profile.edit') }}" class="menu-link">
                        <div>Cập nhật thông tin</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- ── Dịch vụ ── --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Dịch vụ</span>
        </li>

        <li class="menu-item {{ request()->routeIs('services.index') ? 'active' : '' }}">
            <a href="{{ route('services.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-grid-alt"></i>
                <div>Danh sách dịch vụ</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('client.my-services') ? 'active' : '' }}">
            <a href="{{ route('client.my-services') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-package"></i>
                <div>Dịch vụ của tôi</div>
            </a>
        </li>

        {{-- ── Hợp đồng & Hóa đơn ── --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Tài chính</span>
        </li>

        <li class="menu-item {{ request()->routeIs('client.contracts.*') ? 'active' : '' }}">
            <a href="{{ route('client.contracts.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file-blank"></i>
                <div>Hợp đồng của tôi</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('client.invoices.*') ? 'active' : '' }}">
            <a href="{{ route('client.invoices.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-receipt"></i>
                <div>Hóa đơn của tôi</div>
            </a>
        </li>

        {{-- ── Hỗ trợ ── --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Hỗ trợ</span>
        </li>

        <li
            class="menu-item {{ request()->routeIs('dashboard') || request()->routeIs('tickets.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-support"></i>
                <div>Ticket hỗ trợ</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="menu-link">
                        <div>Tất cả phiếu</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('ticket.create') ? 'active' : '' }}">
                    <a href="{{ route('ticket.create') }}" class="menu-link">
                        <div>Tạo phiếu mới</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- ── Admin (chỉ hiện với admin) ── --}}
        @if(Auth::user()->hasAnyRole(['admin', 'super_admin', 'manager']))
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Quản trị</span>
            </li>
            <li class="menu-item">
                <a href="/admin" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-cog"></i>
                    <div>Trang quản trị</div>
                </a>
            </li>
        @endif

    </ul>
</aside>