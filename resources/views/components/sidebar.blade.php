<div class="main-sidebar sidebar-style-2">
    @if (auth()->user()->usertype == 'admin')
        <aside id="sidebar-wrapper">
            <div class="sidebar-brand">
                <a href="{{ url('dashboard') }}">Woitaku</a>
            </div>
            <ul class="sidebar-menu">
                <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                    <a class="nav-link"
                        href="{{ url('dashboard') }}"><i class="fa-solid fa-cube"></i> <span>Dashboard</span></a>
                </li>
                <li class="menu-header">Fitur Utama</li>
                <li class="nav-item dropdown {{ Request::is('member') || Request::is('event-organizer') ? 'active' : '' }}">
                    <a href="#"
                        class="nav-link has-dropdown"
                        data-toggle="dropdown"><i class="fa-solid fa-users-gear"></i> <span>Members</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ Request::is('member') ? 'active' : '' }}">
                            <a href="{{ route('member') }}">List Users</a>
                        </li>
                        <li class="{{ Request::is('event-organizer') ? 'active' : '' }}">
                            <a class="nav-link"
                                href="{{ url('event-organizer') }}">List Event Organizers</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown {{ Request::is('event') || Request::is('competition') || Request::is('booth') ? 'active' : '' }}">
                    <a href="#"
                        class="nav-link has-dropdown"
                        data-toggle="dropdown"><i class="fa-solid fa-calendar-days"></i> <span>Activities</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ Request::is('event') ? 'active' : '' }}">
                            <a href="{{ route('event') }}">List Events</a>
                        </li>
                        <li class="{{ Request::is('competition') ? 'active' : '' }}">
                            <a class="nav-link"
                                href="{{ url('competition') }}">List Competitions</a>
                        </li>
                        <li class="{{ Request::is('booth') ? 'active' : '' }}">
                            <a class="nav-link"
                                href="{{ url('booth') }}">List Booth</a>
                        </li>
                    </ul>
                </li>
                <li class="{{ Request::is('transaction') ? 'active' : '' }}">
                    <a class="nav-link"
                        href="{{ url('transaction') }}"><i class="fa-solid fa-file-invoice-dollar"></i> <span>Transaction</span></a>
                </li>
                <li class="menu-header">Settings</li>
                <li class="{{ Request::is('list-admin') ? 'active' : '' }}">
                    <a class="nav-link"
                        href="{{ url('list-admin') }}"><i class="fa-solid fa-user"></i> <span>List Admin</span></a>
                </li>
            </ul>
        </aside>
    @elseif (auth()->user()->usertype == 'event organizer')
        <aside id="sidebar-wrapper">
            <div class="sidebar-brand">
                <a href="{{ url('dashboard-eo') }}">Woitaku</a>
            </div>
            <ul class="sidebar-menu">
                <li class="{{ Request::is('dashboard-eo') ? 'active' : '' }}">
                    <a class="nav-link"
                        href="{{ url('dashboard-eo') }}"><i class="fa-solid fa-cube"></i> <span>Dashboard</span></a>
                </li>
                <li class="menu-header">Fitur Utama</li>
                <li class="nav-item dropdown {{ Request::is('event-eo') || Request::is('payment-method') || Request::is('competition-eo') || Request::is('booth-eo') ? 'active' : '' }}">
                    <a href="#"
                        class="nav-link has-dropdown"
                        data-toggle="dropdown"><i class="fa-solid fa-sliders"></i> <span>Kelola Event</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ Request::is('event-eo') ? 'active' : '' }}">
                            <a href="{{ route('event-eo') }}">Event</a>
                        </li>
                        <li class="{{ Request::is('competition-eo') ? 'active' : '' }}">
                            <a class="nav-link"
                                href="{{ url('competition-eo') }}">Perlombaan</a>
                        </li>
                        <li class="{{ Request::is('booth-eo') ? 'active' : '' }}">
                            <a class="nav-link"
                                href="{{ url('booth-eo') }}">Booth</a>
                        </li>
                        <li class="{{ Request::is('payment-method') ? 'active' : '' }}">
                            <a class="nav-link"
                                href="{{ route('payment-method') }}">Metode Pembayaran</a>
                        </li>
                    </ul>
                    <li class="{{ Request::is('participant-list') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('participant-list') }}"><i class="fa-solid fa-users-viewfinder"></i> <span>Peserta Event</span></a>
                    </li>
                    <li class="menu-header">Fitur Tamabahan</li>
                    <li class="{{ Request::is('ticket-check') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('ticket-check') }}"><i class="fa-solid fa-ticket"></i> <span>Cek Tiket Peserta</span></a>
                    </li>
                </li>
            </ul>
        </aside>
    @endif
</div>
