Welcome Member

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