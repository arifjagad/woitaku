@extends('layouts.app-member') 
@section('title', 'Profile')

@push('style')

        <link href="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.css" rel="stylesheet">
@endpush

@section('main')

<div class="main-content " style="padding: 80px 0px;">
    <div class="container">
        <section class="section">
            <h2 class="section-title">Hi, {{auth()->user()->name}}!</h2>
            <p class="section-lead">
                You can adjust all general settings here.
            </p>
            <div class="section-body">
                <div class="row">
                    <!-- Panggil Components Sidebar-Profile.blade.php -->
                    @include('components.sidebar-profile')
                    <div class="col-sm-12 col-md-12 col-lg-9">
                        <div class="card">
                            <div class="card-header">
                                <h4>Download Tiket Event</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-striped table display nowrap" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    #
                                                </th>
                                                <th>Id Tiket</th>
                                                <th>Nama Event</th>
                                                <th>Jenis Tiket</th>
                                                <th>Tanggal Aktif Tiket</th>
                                                <th>Status</th>
                                                <th>Download Tiket</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dataTicketEvent as $data)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>{{ $data->ticket_identifier }}</td>
                                                <td>{{ $data->event_name }}</td>
                                                <td>{{ $data->category_name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($data->preferred_date)->format('d F Y') }}</td>
                                                <td>
                                                    @if ($data->transaction_amout == 0 && $data->id_category == 1)
                                                        <div class="badge badge-success">GRATIS</div>
                                                    @elseif ($data->status == 'unused')
                                                        <div class="badge badge-danger">Belum dipakai</div>
                                                    @else
                                                        <div class="badge badge-success">Sudah dipakai</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($data->transaction_amout == 0 && $data->id_category == 1)
                                                        <a href="#" id="btnDownloadTicketFree" class="btn btn-success">Download</a>
                                                    @else
                                                        @if ($data->id_category == 1)
                                                            <a href="{{ route('download-ticket-event', ['id' => $data->id]) }}" class="btn btn-success">Download</a>
                                                        @elseif ($data->id_category == 2)
                                                            <a href="{{ route('download-ticket-competition', ['id' => $data->id]) }}" class="btn btn-success">Download</a>
                                                        @elseif ($data->id_category == 3)
                                                            <a href="{{ route('download-ticket-booth', ['id' => $data->id]) }}" class="btn btn-success">Download</a>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h4>Download Tiket Perlombaan</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-striped table display nowrap" id="table-2">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    #
                                                </th>
                                                <th>Id Tiket</th>
                                                <th>Nama Event</th>
                                                <th>Jenis Tiket</th>
                                                <th>Nama Perlombaan</th>
                                                <th>Tanggal Aktif Tiket</th>
                                                <th>Status</th>
                                                <th>Download Tiket</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dataTicketCompetition as $data)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>{{ $data->ticket_identifier }}</td>
                                                <td>{{ $data->event_name }}</td>
                                                <td>{{ $data->category_name }}</td>
                                                <td>{{ $data->competition_name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($data->preferred_date)->format('d F Y') }}</td>
                                                <td>
                                                    @if ($data->transaction_amout == 0 && $data->id_category == 1)
                                                        <div class="badge badge-success">GRATIS</div>
                                                    @elseif ($data->status == 'unused')
                                                        <div class="badge badge-danger">Belum dipakai</div>
                                                    @else
                                                        <div class="badge badge-success">Sudah dipakai</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($data->transaction_amout == 0 && $data->id_category == 1)
                                                        <a href="#" id="btnDownloadTicketFree" class="btn btn-success">Download</a>
                                                    @else
                                                        @if ($data->id_category == 1)
                                                            <a href="{{ route('download-ticket-event', ['id' => $data->id]) }}" class="btn btn-success">Download</a>
                                                        @elseif ($data->id_category == 2)
                                                            <a href="{{ route('download-ticket-competition', ['id' => $data->id]) }}" class="btn btn-success">Download</a>
                                                        @elseif ($data->id_category == 3)
                                                            <a href="{{ route('download-ticket-booth', ['id' => $data->id]) }}" class="btn btn-success">Download</a>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h4>Download Tiket Booth</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-striped table display nowrap" id="table-3">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    #
                                                </th>
                                                <th>Id Tiket</th>
                                                <th>Nama Event</th>
                                                <th>Jenis Tiket</th>
                                                <th>Kode Booth</th>
                                                <th>Tanggal Aktif Tiket</th>
                                                <th>Status</th>
                                                <th>Download Tiket</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dataTicketBooth as $data)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>{{ $data->ticket_identifier }}</td>
                                                <td>{{ $data->event_name }}</td>
                                                <td>{{ $data->category_name }}</td>
                                                <td>{{ $data->booth_code }}</td>
                                                <td>{{ \Carbon\Carbon::parse($data->preferred_date)->format('d F Y') }}</td>
                                                <td>
                                                    @if ($data->transaction_amout == 0 && $data->id_category == 1)
                                                        <div class="badge badge-success">GRATIS</div>
                                                    @elseif ($data->status == 'unused')
                                                        <div class="badge badge-danger">Belum dipakai</div>
                                                    @else
                                                        <div class="badge badge-success">Sudah dipakai</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($data->transaction_amout == 0 && $data->id_category == 1)
                                                        <a href="#" id="btnDownloadTicketFree" class="btn btn-success">Download</a>
                                                    @else
                                                        @if ($data->id_category == 1)
                                                            <a href="{{ route('download-ticket-event', ['id' => $data->id]) }}" class="btn btn-success">Download</a>
                                                        @elseif ($data->id_category == 2)
                                                            <a href="{{ route('download-ticket-competition', ['id' => $data->id]) }}" class="btn btn-success">Download</a>
                                                        @elseif ($data->id_category == 3)
                                                            <a href="{{ route('download-ticket-booth', ['id' => $data->id]) }}" class="btn btn-success">Download</a>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection @push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
<script src="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('js/page/modules-datatables.js') }}"></script>

<!-- Custom JS -->
<script>
document.getElementById('btnDownloadTicketFree').addEventListener('click', function() {
    Swal.fire({
        icon: 'info',
        title: 'Event Gratis',
        text: 'Event gratis tidak memiliki tiket masuk, kamu bisa langsung datang saja ke lokasi event.',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
    });
});
</script>

<script>
$(document).ready(function() {
    $('#table-3').DataTable();
});
</script>

@endpush