@extends('layouts.app') @section('title', 'List Admin') @push('style')
<!-- CSS Libraries -->
<link
    rel="stylesheet"
    href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
    <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet"/>
@endpush @section('main')


<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>List Admin</h1>
        </div>

        @if (session('success'))
            <div id="success-alert" class="alert alert-success alert-dismissible show fade m">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="section-body">
            <div class="card">
                {{-- <div class="card-header">
                        <h4>Example Card</h4>
                    </div> --}}
                <div class="card-body">
                    <form class="needs-validation" novalidate="" method="POST">
                        @csrf
                        <div>
                            <div class="card-header">
                                <h4>Explore the List of Admins.</h4>
                            </div>
                            <div class="card-footer text-right">
                                <a href="{{route('create-admin')}}" class="btn btn-primary">Create Admin</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                #
                                            </th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Created At</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                        <tr>
                                            <td class="text-center">
                                                {{ $user->id }}
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                {{ $user->created_at->format('d-m-Y H:i:s') }}
                                            </td>
                                            <td>
                                                <div class="badge {{ $user->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $user->status }}
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
                {{-- <div class="card-footer bg-whitesmoke">
                    This is card footer
                </div> --}}
            </div>
        </div>
    </section>
</div>
@endsection @push('scripts')
<!-- JS Libraies -->
{{-- <script src="assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script> --}}
<script
    src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
{{-- <script src="{{ asset() }}"></script> --}}
{{-- <script src="{{ asset() }}"></script> --}}
<script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/modules-datatables.js') }}"></script>
<script>
    // Setelah 3 detik, sembunyikan atau hapus elemen alert
    setTimeout(function() {
        $('#success-alert').alert('close'); // Menggunakan metode 'close' dari Bootstrap
        // atau
        // $('#success-alert').remove(); // Untuk menghapus elemen dari DOM
    }, 1500);
</script>
@endpush