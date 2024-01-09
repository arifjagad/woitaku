<div class="col-12 col-md-6 col-lg-3">
    <div class="card">
        <div class="card-header">
            <h4>Pengaturan</h4>
        </div>
        <div class="card-body">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('profile') ? 'active' : '' }}" href="{{ url('profile') }}">Akun</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('history-transaction') ? 'active' : '' }}" href="{{ url('history-transaction') }}">Histori Transaksi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('download-ticket') ? 'active' : '' }}" href="{{ url('download-ticket') }}">Download Tiket</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('setting-booth') ? 'active' : '' }}" href="{{ url('setting-booth') }}">Pengaturan Booth</a>
                </li>
            </ul>
            
        </div>
        
    </div>
</div>