<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Woitaku</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('dashboard') }}"><i class="fa-solid fa-cube"></i> <span>Dashboard</span></a>
            </li>
            <li class="menu-header">Starter</li>
            <li class="nav-item dropdown {{ $type_menu === 'layout' ? 'active' : '' }}">
                <a href="#"
                    class="nav-link has-dropdown"
                    data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Layout</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('layout-default-layout') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('layout-default-layout') }}">Default Layout</a>
                    </li>
                </ul>
            </li>
            <li class="menu-header">Settings</li>
            <li class="{{ Request::is('add-admin') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('create-admin') }}"><i class="fa-solid fa-user-plus"></i> <span>Create Admin</span></a>
            </li>
        </ul>
    </aside>
</div>
