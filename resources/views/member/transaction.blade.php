@extends('layouts.app-transaction') 
@section('title', 'Transaksi')

@push('style')
@endpush
@section('main')
<div class="row">
    <div class="col-12 col-lg-8">
        <div class="card card-primary card-lg">
            <div class="card-header">
                <h4>Login</h4>
            </div>
        
            <div class="card-body">
        
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="card card-primary card-lg">
            <div class="card-header">
                <h4>Detail Transaksi</h4>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <td>Nama Event</td>
                        <td>{{ $dataEvent->event_name }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>{{ now()->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td>Harga Tiket</td>
                        <td>IDR. {{ number_format($dataEvent->ticket_price, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td><span class="badge badge-success">Lunas</span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection 
@push('scripts')

@endpush