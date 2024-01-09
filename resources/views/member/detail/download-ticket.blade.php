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
                    <div class="col-12 col-md-6 col-lg-9">
                        <div class="card">
                            <div class="card-header">
                                <h4>Download Tiket</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
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
                                                <th>Download</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dataTicket as $data)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>{{ $data->ticket_identifier }}</td>
                                                <td>{{ $data->event_name }}</td>
                                                <td>{{ $data->category_name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($data->active_date)->format('d F Y') }}</td>
                                                <td>
                                                    @if ($data->status == 'used')
                                                        <div class="badge badge-success">Sudah dipakai</div>
                                                    @else
                                                        <div class="badge badge-danger">Belum dipakai</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-success">Download</a>
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

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/modules-datatables.js') }}"></script>

<!-- Custom JS -->

@endpush