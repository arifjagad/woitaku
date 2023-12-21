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
            <li class="nav-item">
                <a class="nav-link"
                    href="#">Event</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"
                    href="#">Blog</a>
            </li>
        </ul>
        <span class="navbar-text">
            @auth
                <u>Hi, {{ auth()->user()->name }}</u>
            @else
                <a href="{{ route('login') }}" class="text-white"><u>Login</u></a>
            @endauth
        </span>
    </div>
</nav>