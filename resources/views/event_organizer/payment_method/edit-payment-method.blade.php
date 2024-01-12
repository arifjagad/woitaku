@extends('layouts.app') @section('title', 'Update Payment Method')

@push('style')
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.css" rel="stylesheet">
@endpush

@section('main')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Perbaharui Metode Pembayaran</h1>
        </div>
        
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <form class="needs-validation" novalidate="" method="POST" action="{{ route('update-payment-method', $data->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="form-group col-lg-4">
                                        <label>Nama Bank</label>
                                        <input
                                            id="bank_name"
                                            type="text"
                                            class="form-control @error('bank_name') is-invalid @enderror"
                                            name="bank_name"
                                            value="{{ $data->bank_name}}"
                                            required>
                                        <!-- Error Message -->
                                        @error('bank_name')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Nomor Rekening</label>
                                        <input
                                            id="account_number"
                                            type="text"
                                            class="form-control @error('account_number') is-invalid @enderror"
                                            name="account_number"
                                            value="{{ $data->account_number}}"
                                            required>
                                        <!-- Error Message -->
                                        @error('account_number')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Nama Pemilik Kartu</label>
                                        <input
                                            id="account_holder_name"
                                            type="text"
                                            class="form-control @error('account_holder_name') is-invalid @enderror"
                                            name="account_holder_name"
                                            value="{{ $data->account_holder_name}}"
                                            oninput="toUpperCase(this)"
                                            required>
                                        <!-- Error Message -->
                                        @error('account_holder_name')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Perbaharui Metode Pembayaran</button>
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
<script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
<script src="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.js"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('js/page/modules-datatables.js') }}"></script>
<script>
    function toUpperCase(element) {
        element.value = element.value.toUpperCase();
    }
</script>
@endpush