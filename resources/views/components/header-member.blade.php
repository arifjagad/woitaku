@php
    $headerController = app('App\Http\Controllers\HeaderController');
    $data = $headerController->headerMember();
@endphp

<nav class="navbar navbar-expand-lg bg-primary px-md-5 position-fixed" style="left: 0px; right: 0px;">
    <div class="navbar-toggle" id="navbarToggle" style="margin-left: 8px;">
        <i class="fa-solid fa-bars"></i>
    </div>
    <div class="navbar-brand">
        <a href="{{ route('home') }}" class="text-white" style="text-decoration:none;">
            WOITAKU
        </a>
    </div>
    <div class="navbar-links" id="navbarLinks">
        <a href="{{ route('home') }}" class="nav-link my-2 {{ Request::is('/') || Request::is('home') ? 'active' : '' }}">Beranda</a>
        <a href="{{ route('list-event') }}" class="nav-link my-2 {{ Request::is('list-event') ? 'active' : '' }}">Event</a>
        @auth

        @else
            <a href="{{ route('login') }}" class="nav-link my-2 nav-right mr-5"><u>Login</u></a>
        @endauth
    </div>
    @auth
        <nav>
            <ul class="navbar-nav nav-right2 mt-1 px-md-5">
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
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-right-lg">
                        @if(auth()->user()->usertype == 'admin')
                            <a href="{{ route('dashboard') }}" class="dropdown-item has-icon">
                                <i class="fas fa-home"></i>
                                Dashboard
                            </a>
                        @elseif(auth()->user()->usertype == 'event organizer')
                            <a href="{{ route('dashboard-eo') }}" class="dropdown-item has-icon">
                                <i class="fas fa-home"></i>
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('profile')}}" class="dropdown-item has-icon">
                                <i class="far fa-user"></i>
                                Profile
                            </a>
                        @endif
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
    @endauth
</nav>