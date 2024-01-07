@extends('layouts.app-transaction') 
@section('title', 'Transaksi')

@push('style')
@endpush
@section('main')
<div class="row">
    <div class="col-12 col-lg-5 mx-auto">
        
        <div class="card card-primary card-lg">
            <div class="card-header">
                <h4>Pembayaran</h4>
            </div>
            <div class="card-body">
                <div>
                    <div class="d-flex justify-content-between">
                        <h6 class="mt-3">Bank Tujuan</h6>
                        <h6 class="text-primary mt-3">{{ $dataTransaction->bank_name}}</h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="mt-3">No. Rekening</h6>
                        <h6 class="text-primary mt-3">{{ $dataTransaction->account_number }}</h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="mt-3">Atas Nama</h6>
                        <h6 class="text-primary mt-3">{{ $dataTransaction->account_holder_name }}</h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="mt-3">Total Pembayaran</h6>
                        <h6 class="text-primary mt-3">IDR. {{ number_format($dataTransaction->transaction_amout, 0, ',', '.') }}</h6>
                    </div>
                    @if($dataTransaction->transaction_status == 'pending')
                        <div class="alert alert-info my-4">
                            <p class="text-center">Transfer ke rekening <strong>{{ $dataTransaction->account_holder_name }}</strong> <br>sebesar <strong>IDR. {{ number_format($dataTransaction->transaction_amout, 0, ',', '.') }}</strong></p>
                        </div>
                    @elseif($dataTransaction->transaction_status == 'failed')
                        <div class="alert alert-danger my-4">
                            <p class="text-center">Pembayaran gagal</p>
                        </div>
                    @else
                        <div class="alert alert-success my-4">
                            <p class="text-center">Pembayaran berhasil</p>
                        </div>
                    @endif

                </div>
                <div class="text-center mt-5">
                    <a href="#" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection 
@push('scripts')

@endpush