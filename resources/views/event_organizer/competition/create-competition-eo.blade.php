@extends('layouts.app') @section('title', 'Create Competition')

@push('style')
    <link rel="stylesheet"
        href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Perlombaan</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Detail Perlombaan</h4>
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
                                        <div 
                                            class="float-right"
                                            data-toggle="tooltip"
                                            title="Pilih nama event yang ingin kamu tambahkan competition">
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
                                    <div class="form-group col-lg-6">
                                        <label>Nama Perlombaan</label>
                                        <input
                                            id="competition_name"
                                            type="text"
                                            class="form-control @error('competition_name') is-invalid @enderror"
                                            name="competition_name"
                                            value="{{ old('competition_name') }}"
                                            required>
                                        <!-- Error Message -->
                                        @error('competition_name')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-12">
                                        <label>Thumbnail Perlombaan</label>
                                        <div class="custom-file">
                                            <input type="file"
                                                name="thumbnail_competition"
                                                class="custom-file-input @error('thumbnail_competition') is-invalid @enderror"
                                                id="thumbnail_competition"
                                                accept=".jpg, .jpeg, .png"
                                                required
                                                >
                                            <label class="custom-file-label">Choose File</label>
                                            <!-- Error Message -->
                                            @error('thumbnail_competition')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-text text-muted">
                                            Gambar harus memiliki ukuran maksimal 300 KB.
                                        </div>
                                    </div>
                                    
                                    <div class="form-group col-lg-12">
                                        <label>Deskripsi Perlombaan</label>
                                        <textarea
                                            class="summernote @error('competition_description') is-invalid @enderror"
                                            name="competition_description"
                                            id="competition_description"
                                            required>
                                            {{ old('competition_description') }}
                                        </textarea>
                                        <!-- Error Message -->
                                        @error('competition_description')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Tanggal Mulai Perlombaan</label>
                                        <input type="text"
                                            name="competition_start_date"
                                            id="competition_start_date"
                                            class="form-control datepicker @error('competition_start_date') is-invalid @enderror"
                                            value="{{ old('competition_start_date') }}"
                                            required>
                                        <!-- Error Message -->
                                        @error('competition_start_date')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Tanggal Berakhir Perlombaan</label>
                                        <input type="text"
                                            name="competition_end_date"
                                            id="competition_end_date"
                                            class="form-control datepicker @error('competition_end_date') is-invalid @enderror"
                                            value="{{ old('competition_end_date') }}"
                                            required>
                                        <!-- Error Message -->
                                        @error('competition_end_date')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Biaya Pendaftaran</label>
                                        <div 
                                            class="float-right"
                                            data-toggle="tooltip"
                                            title="Masukkan harga tiket jika competition ini berbayar">
                                                <label>
                                                    <i class="fa-solid fa-circle-info"></i> Informasi
                                                </label>
                                        </div>
                                        <input
                                            id="competition_fee"
                                            type="number"
                                            class="form-control @error('competition_fee') is-invalid @enderror"
                                            name="competition_fee"
                                            value="{{ old('competition_fee') }}"
                                            >
                                        <!-- Error Message -->
                                        @error('competition_fee')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Jumlah Peserta</label>
                                        <div 
                                            class="float-right"
                                            data-toggle="tooltip"
                                            title="Masukkan maximal participant">
                                                <label>
                                                    <i class="fa-solid fa-circle-info"></i> Informasi
                                                </label>
                                        </div>
                                        <input
                                            id="participant_qty"
                                            type="number"
                                            class="form-control @error('participant_qty') is-invalid @enderror"
                                            name="participant_qty"
                                            value="{{ old('participant_qty') }}"
                                            required>
                                        <!-- Error Message -->
                                        @error('participant_qty')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Tambah Perlombaan</button>
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
    <script src="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>

    <!-- Custom JS -->
@endpush