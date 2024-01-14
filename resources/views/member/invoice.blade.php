@extends('layouts.app-transaction') 
@section('title', 'Invoice')

@push('style')
<link rel="stylesheet"
        href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
<div class="row">
    <div class="col-12 col-lg-8 mx-auto">
        <div class="card card-primary card-xl">
            <!-- Detail Invoice -->
            <div class="card-header">
                <h4>Pembayaran</h4>
            </div>
            <div class="card-body">
                <h6>Informasi Pembelian</h6>
                <hr>
                <div class="d-flex justify-content-between">
                    <h6 class="mt-3">Nama Event</h6>
                    <h6 class="text-primary mt-3">{{ $dataTransactionEvent->event_name}}</h6>
                </div>
                @if($dataTransaction->id_event != null && $dataTransaction->id_competition != null)
                    <div class="d-flex justify-content-between">
                        <h6 class="mt-3">Nama Perlombaan</h6>
                        <h6 class="text-primary mt-3">{{ $dataTransactionCompetition->competition_name}}</h6>
                    </div>
                @elseif($dataTransaction->id_event != null && $dataTransaction->id_booth_rental != null)
                    <div class="d-flex justify-content-between">
                        <h6 class="mt-3">Kode Booth</h6>
                        <h6 class="text-primary mt-3">{{ $dataTransactionBooth->booth_code}}</h6>
                    </div>
                @endif
                <hr>
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
                <div class="d-flex justify-content-end">
                    <h6 class="mt-3 text-primary">Transfer Sesuai Dengan Total Pembayaran
                        <i class="far fa-solid fa-turn-up text-primary"></i>
                    </h6>
                </div>
                @if ($dataTransaction->transaction_status == 'pending')
                    <div class="alert alert-info my-4">
                        <p class="text-center">Transfer ke rekening <strong>{{ $dataTransaction->account_holder_name }}</strong> <br>sebesar <strong>IDR. {{ number_format($dataTransaction->transaction_amout, 0, ',', '.') }}</strong></p>
                    </div>
                @elseif ($dataTransaction->transaction_status == 'expired')
                    <div class="alert alert-danger my-4">
                        <p class="text-center">Pembayaran gagal</p>
                    </div>
                @else
                    
                @endif

                {{-- <div class="text-center mt-5">
                    <a href="javascript:history.back()" class="btn btn-primary">Kembali</a>
                </div> --}}
            </div>

            <!-- Upload Bukti Pemabayaran -->
            {{-- <div class="card-header">
                <h4>Upload Bukti </h4>
            </div> --}}
        </div>
    </div>
    <div class="col-12 col-lg-4 mx-auto">
        <div class="card card-primary card-xl">
            <div class="card-header">
                <h4>Upload Bukti Transfer</h4>
            </div>
            <div class="card-body">
                @if ($dataTransaction->transaction_status == 'check')
                    <div class="alert alert-info">
                        <p class="text-center">Bukti transfer telah dikirim, mohon tunggu konfirmasi.</p>
                    </div>
                @elseif ($dataTransaction->transaction_status == 'pending')
                    <form action="{{ route('upload-transaction', ['id' => $dataTransaction->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="custom-file">
                            <input type="file"
                                name="proof_of_transaction"
                                class="custom-file-input @error('proof_of_transaction') is-invalid @enderror"
                                id="proof_of_transaction"
                                accept=".jpg, .jpeg, .png, .pdf"
                                required
                                >
                            <label class="custom-file-label">Choose File</label>
                            <!-- Error Message -->
                            @error('proof_of_transaction')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-text text-muted">
                            File harus memiliki ukuran maksimal 300 KB.
                        </div>
                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-primary btn-block">Upload</button>
                        </div>
                    </form>
                @elseif ($dataTransaction->transaction_status == 'success')
                    <div class="alert alert-success">
                        <p class="text-center">Pembayaran berhasil</p>
                    </div>
                @endif
            </div>
        </div>
        <div class="float-right">
            <a href="{{ route('history-transaction') }}" class="btn btn-primary">Kembali</a>
        </div>
    </div>
    
</div>

@endsection 

@push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>

<!-- Custom JS -->
@endpush