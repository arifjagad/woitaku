<div class="navbar-bg"></div>
@if (auth()->user()->usertype == 'admin')
    <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
            <ul class="navbar-nav mr-3">
                <li>
                    <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>
        </form>
        <ul class="navbar-nav navbar-right">
            <li class="dropdown">
                <a
                    href="#"
                    data-toggle="dropdown"
                    class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                    <img
                        alt="image"
                        src="{{ asset('img/avatar/avatar-1.png') }}"
                        class="rounded-circle mr-1">
                        <div class="d-sm-none d-lg-inline-block">Hi,
                            {{auth()->user()->name}}</div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{ route('profile-admin')}}" class="dropdown-item has-icon">
                        <i class="far fa-user"></i>
                        Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a
                        href="{{route('logout')}}"
                        class="dropdown-item has-icon text-danger"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                    <form
                        id="logout-form"
                        action="{{ route('logout') }}"
                        method="POST"
                        class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </nav>
@elseif (auth()->user()->usertype == 'event organizer')
@php
    $headerController = app('App\Http\Controllers\HeaderController');
    $data = $headerController->headerEventOrganizer();
@endphp
    <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
            <ul class="navbar-nav mr-3">
                <li>
                    <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>
        </form>
        <ul class="navbar-nav navbar-right">
            <li class="dropdown">
                <a
                    href="#"
                    data-toggle="dropdown"
                    class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                    @if(auth()->check() && $data && $data->foto_profile)
                    <img
                        alt="image"
                        src="{{ asset('storage/' . $data->foto_profile) }}"
                        class="rounded-circle mr-1">
                @else
                    <img
                        alt="image"
                        src="{{ asset('img/avatar/avatar-1.png') }}"
                        class="rounded-circle mr-1">
                @endif
                <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->name }}</div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{ route('profile-eo')}}" class="dropdown-item has-icon">
                        <i class="far fa-user"></i>
                        Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a
                        href="{{route('logout')}}"
                        class="dropdown-item has-icon text-danger"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                    <form
                        id="logout-form"
                        action="{{ route('logout') }}"
                        method="POST"
                        class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </nav>
@endif