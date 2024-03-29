@extends('layouts.app') @section('title', 'Create Booth')

@push('style')
    <link rel="stylesheet"
        href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
@endpush

@section('main')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Booth</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Detail Booth</h4>
                    </div>
                    
                    <form
                        class="needs-validation"
                        novalidate=""
                        method="POST"
                        action="#"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label>Nama Event</label>
                                        <div 
                                            class="float-right"
                                            data-toggle="tooltip"
                                            title="Pilih nama event yang ingin kamu tambahkan booth">
                                            <label>
                                                <i class="fa-solid fa-circle-info"></i> Informasi
                                            </label>
                                        </div>
                                        <select class="form-control select2" id="event_name" name="event_name">
                                            @foreach($dataEvent as $data)
                                                <option value="{{$data->id}}">{{ $data->event_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Kode Booth</label>
                                        <input
                                            id="booth_code"
                                            type="text"
                                            class="form-control @error('booth_code') is-invalid @enderror"
                                            name="booth_code"
                                            value="{{ old('booth_code') }}"
                                            placeholder="Contoh: AA-001"
                                            required>
                                        <!-- Error Message -->
                                        @error('booth_code')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Ukuran Booth</label>
                                        <input
                                            id="booth_size"
                                            type="text"
                                            class="form-control @error('booth_size') is-invalid @enderror"
                                            name="booth_size"
                                            placeholder="Contoh: 3x3 meter"
                                            value="{{ old('booth_size') }}"
                                            required>
                                        <!-- Error Message -->
                                        @error('booth_size')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Harga Sewa Booth</label>
                                        <input
                                            id="rental_price"
                                            type="text"
                                            class="form-control @error('rental_price') is-invalid @enderror"
                                            name="rental_price"
                                            value="{{ old('rental_price') }}"
                                            required>
                                        <!-- Error Message -->
                                        @error('rental_price')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label>Fasilitas Booth</label>
                                        <textarea
                                            class="summernote-simple @error('provided_facilities') is-invalid @enderror"
                                            name="provided_facilities"
                                            id="provided_facilities"
                                            value="{{ old('provided_facilities') }}"
                                            placeholder=" 1. Gratis Tiket Masuk Untuk 3 Orang"
                                            required>
                                               
                                        </textarea>
                                        <!-- Error Message -->
                                        @error('provided_facilities')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Tambah Booth</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection @push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>


@endpush