@extends('layouts.app')

@section('title', 'Event Organizer')

@push('style')
    <!-- CSS Libraries -->
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.8/sc-2.3.0/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('main')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Event Organizer</h1>
        </div>

        <h2 class="section-title">View All Existing Event Organizer Data!</h2>
            <p class="section-lead">
                You can view all Event Organizer here.
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
                                <table class="table-striped table" id="list-event-organizer">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                #
                                            </th>
                                            <th>Event Organizer Name</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>City</th>
                                            <th>WhatsApp Number</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $id = 1; @endphp
                                        @foreach ($data as $data)
                                            <tr>
                                                <td class="text-center">{{ $id++ }}</td>
                                                <td>{{ $data->name }}</td>
                                                <td>{{ $data->email }}</td>
                                                <td>{{ $data->alamat }}</td>
                                                <td>{{ $data->kota }}</td>
                                                <td>{{ $data->nomor_whatsapp }}</td>
                                                <td>{{ $data->created_at }}</td>
                                                <td>
                                                    <a href="{{route('event-organizer', $data->id)}}" class="btn btn-primary">Detail</a>
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
            $('#list-event-organizer').DataTable({
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
