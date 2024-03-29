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
                                <h4>Histori Transaksi</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-striped table display nowrap" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    #
                                                </th>
                                                <th>Nama Event</th>
                                                <th>Jenis Transaksi</th>
                                                <th>Total</th>
                                                <th>Tanggal</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $id = 1; @endphp
                                            @foreach($dataTransaction as $data)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $id++ }}
                                                </td>
                                                <td>{{ $data->event_name }}</td>
                                                <td>{{ $data->category_name }}</td>
                                                <td>
                                                    @if($data->transaction_amout == 0 || null)
                                                        GRATIS
                                                    @else
                                                        IDR {{ number_format($data->transaction_amout, 0, ',', '.') }}
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($data->created_at)->format('d F Y') }}
                                                </td>
                                                <td class="text-center">
                                                    @if($data->transaction_status == 'pending')
                                                        <span class="badge badge-warning">Pending</span>
                                                    @elseif($data->transaction_status == 'success')
                                                        <span class="badge badge-success">Berhasil</span>
                                                    @elseif($data->transaction_status == 'expired' || $data->transaction_status == 'failed')
                                                        <span class="badge badge-danger">Gagal</span>
                                                    @elseif($data->transaction_status == 'check')
                                                        <span class="badge badge-info">Menunggu konfirmasi</span>
                                                    @endif
                                                    
                                                </td>
                                                <td>
                                                    @if($data->transaction_status == 'pending' || $data->transaction_status == 'expired' || $data->transaction_status == 'check')
                                                        <a href="{{ route('invoice', ['id' => $data->id]) }}" class="btn btn-primary">Detail</a>
                                                    @elseif($data->transaction_status == 'success')
                                                        <a href="{{ route('download-ticket') }}" class="btn btn-success">Download Tiket</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{-- @foreach($dataTransaksi as $data)
                                        {{ $data->id }}
                                    @endforeach --}}
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