<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="#" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bolder ms-2">SM Uniforms</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <li class="menu-item">
            <a href="{{ url('/dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Bills</span>
        </li>
        <li class="menu-item {{ Request::is('bill*', 'bill/*') ? 'active' : '' }}">
            <a href="{{ url('/bill') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Basic">Bills</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Menu</span>
        </li>
        <li class="menu-item {{ Request::is('product*', 'product/*') ? 'active' : '' }}">
            <a href="{{ url('/product') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Basic">Products</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('customer-details', 'customer-details/*') ? 'active' : '' }}">
            <a href="{{ url('/customer-details') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Basic">Customer Details</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Settings</span>
        </li>

        <li class="menu-item {{ Request::is('system-settings/*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">System Settings</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::is('system-settings/company-details', 'system-settings/company-details/*') ? 'active' : '' }}">
                    <a href="{{ url('/system-settings/company-details') }}" class="menu-link">
                        <div data-i18n="Account">Company Details</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
