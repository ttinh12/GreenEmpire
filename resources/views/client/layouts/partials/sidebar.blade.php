<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('ticket.home') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <svg width="25" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                            <g id="Icon" transform="translate(27.000000, 15.000000)">
                                <g id="Mask" transform="translate(0.000000, 8.000000)">
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
            <span class="app-brand-text demo menu-text fw-bolder ms-2">GreenEmpire</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Hệ thống & Cá nhân</span>
        </li>

        <li class="menu-item {{ request()->routeIs('ticket.home') ? 'active' : '' }}">
            <a href="{{ route('ticket.home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Bảng điều khiển</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user-circle"></i>
                <div>Hồ sơ của tôi</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div>Thông tin cá nhân</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div>Công việc được giao</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Kinh doanh</span></li>

        <li class="menu-item {{ request()->is('customers*') || request()->is('contacts*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user-voice"></i>
                <div>Quản lý Khách hàng</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('customers') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div>Danh sách khách hàng</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('contacts') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div>Người liên hệ</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div>Nhật ký chăm sóc</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-phone-call"></i>
                <div>Người liên hệ</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-note"></i>
                <div>Nhật ký chăm sóc</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Dịch vụ & Hợp đồng</span>
        </li>

        <li class="menu-item">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div>Danh sách Hợp đồng</div>
            </a>
        </li>

        <li
            class="menu-item {{ request()->routeIs('ticket.*') && !request()->routeIs('ticket.home') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-support"></i>
                <div>Hỗ trợ (Tickets)</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('ticket.home') ? 'active' : '' }}">
                    <a href="{{ route('ticket.home') }}" class="menu-link">
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

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Tài chính & Kế toán</span>
        </li>

        <li class="menu-item">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-receipt"></i>
                <div>Hóa đơn (Invoices)</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-wallet"></i>
                <div>Thu chi nội bộ</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Quản trị Nhân sự</span>
        </li>

        <li class="menu-item">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-id-card"></i>
                <div>Danh sách Nhân viên</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-calendar-check"></i>
                <div>Chấm công & Lương</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div>Bảng chấm công</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div>Phiếu lương tháng</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-header small text-uppercase"><span class="menu-header-text">Khác</span></li>
        <li class="menu-item">
            <a href="https://github.com/your-repo" target="_blank" class="menu-link">
                <i class="menu-icon tf-icons bx bx-help-circle"></i>
                <div>Hướng dẫn sử dụng</div>
            </a>
        </li>
    </ul>
</aside>