@php
    $headerController = app('App\Http\Controllers\HeaderController');
    $data = $headerController->headerMember();
@endphp
<nav class="navbar navbar-expand-lg bg-primary" style="left: 0px; right: 0px; padding: 0px 60px">
    <a class="navbar-brand"
        href="#">WOITAKU</a>
    <button class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarText"
        aria-controls="navbarText"
        aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse"
        id="navbarText">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item {{ Request::is('/') || Request::is('home') ? 'active' : '' }}">
                <a href="{{ route('home') }}" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"
                    href="#">About</a>
            </li>
            <li class="nav-item {{ Request::is('list-event') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ route('list-event') }}">Event</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"
                    href="#">Blog</a>
            </li>
        </ul>
        <span class="navbar-text">
            @auth
                <nav >
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
                                <a href="{{ route('profile')}}" class="dropdown-item has-icon">
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
            @else
                <a href="{{ route('login') }}" class="text-white"><u>Login</u></a>
            @endauth
        </span>
    </div>
</nav>