@extends('layouts.app')

@section('title', 'Member')

@push('style')
    <!-- CSS Libraries -->
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.8/sc-2.3.0/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('main')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Member</h1>
        </div>

        <h2 class="section-title">View All Existing Member Data!</h2>
            <p class="section-lead">
                You can view all Member here.
            </p>

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
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table" id="list-member">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                #
                                            </th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Foto Profile</th>
                                            <th>Kota</th>
                                            <th>Nomor Whatsapp</th>
                                            <th>Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $id = 1; @endphp
                                        @foreach ($datas as $data)
                                            <tr>
                                                <td class="text-center">{{ $id++ }}</td>
                                                <td>{{ $data->name }}</td>
                                                <td>{{ $data->email }}</td>
                                                <td>{{ $data->foto_profile }}</td>
                                                <td>{{ $data->kota }}</td>
                                                <td>{{ $data->nomor_whatsapp }}</td>
                                                <td>{{ $data->created_at }}</td>
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

@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.8/sc-2.3.0/datatables.min.js"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>

    <!-- JSZip -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <!-- DataTables Buttons HTML5 -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

    <!-- DataTables Buttons Print -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#list-member').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        className: 'btn btn-primary',
                        /* exportOptions: {
                            columns: ':not(:last-child)',
                        } */
                    }, {
                        extend: 'csv',
                        className: 'btn btn-primary',
                    }, {
                        extend: 'excel',
                        className: 'btn btn-primary',
                    }
                ],
                initComplete: function () {
                    $('.btn-primary').removeClass('dt-button');
                }
            });
        });
    </script>

@endpush
