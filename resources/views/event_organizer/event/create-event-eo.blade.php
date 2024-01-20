@extends('layouts.app')

@section('title', 'Create Event')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Event</h1>
        </div>

        <div class="row">
            <div class="col-12 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Penjelasan Status Verifikasi Event</h4>
                    </div>
                    <div class="card-body">
                        <p class="text-sm text-justify">
                            Kamu dapat melihat status verifikasi event yang kamu buat di sini. 
                            Jika statusnya <span class="badge badge-success">Verified</span>, maka event kamu sudah dapat diakses oleh peserta. 
                            Jika statusnya <span class="badge badge-warning">Pending</span>, maka event kamu sedang dalam proses verifikasi. 
                            Jika statusnya <span class="badge badge-info">Revision</span>, maka perlu mengubah sedikit sesuai instruksi yang kami berikan agar event tersebut sesuai. 
                            Jika statusnya <span class="badge badge-danger">Rejected</span>, maka event kamu tidak memenuhi syarat dan tidak dapat diakses oleh peserta.
                        </p>
                    </div>
                    {{-- <div class="card-footer">
                        STATUS EVENT KAMU
                    </div> --}}
                </div>
            </div>
            <div class="col-12 col-md-8 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Detail Event</h4>
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
                                    <div class="form-group col-lg-6">
                                        <label>Nama Event</label>
                                        <input
                                            id="event_name"
                                            type="text"
                                            class="form-control @error('event_name') is-invalid @enderror"
                                            name="event_name"
                                            value="{{ old('event_name') }}"
                                            required>
                                        <!-- Error Message -->
                                        @error('event_name')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Kota Event</label>
                                        <select class="form-control select2" id="city" name="city">
                                            @foreach ($indonesiaCities as $city)
                                                <option value="{{ $city }}">{{ $city }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label>Alamat Event</label>
                                        <textarea class="form-control @error('event_address') is-invalid @enderror"
                                            name="event_address"
                                            id="event_address"
                                            data-height="60"
                                            required>{{ old('event_address') }}</textarea>
                                        <!-- Error Message -->
                                        @error('event_address')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-12">
                                        <label>Gambar Utama Event</label>
                                        <div class="custom-file">
                                            <input type="file"
                                                name="featured_image"
                                                class="custom-file-input @error('featured_image') is-invalid @enderror"
                                                id="featured_image"
                                                accept=".jpg, .jpeg, .png"
                                                required
                                                >
                                            <label class="custom-file-label">Choose File</label>
                                            <!-- Error Message -->
                                            @error('featured_image')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-text text-muted">
                                            Gambar harus memiliki ukuran maksimal 300 KB.
                                        </div>
                                    </div>
                                    <div class="form-group col-12">
                                        <label>Denah Lokasi Booth</label>
                                        <div 
                                            class="float-right"
                                            data-toggle="tooltip"
                                            title="Jika Anda memiliki denah booth, maka bisa diupload">
                                                <label>
                                                    <i class="fa-solid fa-circle-info"></i> Informasi
                                                </label>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file"
                                                name="booth_layout"
                                                class="custom-file-input @error('booth_layout') is-invalid @enderror"
                                                id="booth_layout"
                                                accept=".jpg, .jpeg, .png"
                                                
                                                >
                                            <label class="custom-file-label">Choose File</label>
                                            <!-- Error Message -->
                                            @error('booth_layout')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-text text-muted">
                                            Gambar harus memiliki ukuran maksimal 300 KB.
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Tanggal Mulai Event</label>
                                        <input type="text"
                                            name="start_date"
                                            id="start_date"
                                            class="form-control datepicker @error('start_date') is-invalid @enderror"
                                            value="{{ old('start_date') }}"
                                            required>
                                        <!-- Error Message -->
                                        @error('start_date')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Tanggal Berakhir Event</label>
                                        <input type="text"
                                            name="end_date"
                                            id="end_date"
                                            class="form-control datepicker @error('end_date') is-invalid @enderror"
                                            value="{{ old('end_date') }}"
                                            required>
                                        <!-- Error Message -->
                                        @error('end_date')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label>Deskripsi Event (isi secara detail)</label>
                                        <textarea class="summernote"
                                            name="event_description"
                                            id="event_description"
                                            required>{{ old('event_description') }}</textarea>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Harga Tiket Masuk</label>
                                        <div 
                                            class="float-right"
                                            data-toggle="tooltip"
                                            title="Masukkan harga tiket jika kamu ingin membuat event berbayar">
                                                <label>
                                                    <i class="fa-solid fa-circle-info"></i> Informasi
                                                </label>
                                        </div>
                                        <input
                                            id="ticket_price"
                                            type="number"
                                            class="form-control @error('ticket_price') is-invalid @enderror"
                                            name="ticket_price"
                                            value="{{ old('ticket_price') }}"
                                            >
                                        <!-- Error Message -->
                                        @error('ticket_price')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Jumlah Tiket</label>
                                        <div 
                                            class="float-right"
                                            data-toggle="tooltip"
                                            title="Masukkan jumlah tiket jika kamu ingin membuat event berbayar">
                                            <label>
                                                <i class="fa-solid fa-circle-info"></i> Informasi
                                            </label>
                                        </div>
                                        <input
                                            id="ticket_qty"
                                            type="number"
                                            class="form-control @error('ticket_qty') is-invalid @enderror"
                                            name="ticket_qty"
                                            value="{{ old('ticket_qty') }}"
                                            >
                                        <!-- Error Message -->
                                        @error('ticket_qty')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-12">
                                        <label>Dokumen Pendukung</label>
                                        <div 
                                            class="float-right"
                                            data-toggle="tooltip"
                                            title="Berikan kami dokumen yang menyatakan bahwa kamu menyelenggarakan event ini secara legal dan sah">
                                            <label>
                                                <i class="fa-solid fa-circle-info"></i> Informasi
                                            </label>
                                        </div>
                                        <input
                                            id="document"
                                            type="text"
                                            class="form-control @error('document') is-invalid @enderror"
                                            name="document"
                                            placeholder="Kirim link dokumen kamu disini"
                                            value="{{ old('document') }}"
                                            required>
                                        <!-- Error Message -->
                                        @error('document')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Tambah Event</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>

    <!-- Custom JS -->
@endpush
