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
            <h1>Create a new booth</h1>
        </div>

        <div class="row">
            <div class="col-12 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Guidebook</h4>
                    </div>
                    <div class="card-body">
                        <ol class="list-group text-justify ml-2">
                            <li>
                                Perhatikan keseluruhan kolom form yang ada, pastikan tidak ada yang kosong.
                            </li>
                            <li>
                                Upload featured image dengan ukuran yang sesuai, yaitu 1300x600 px.
                            </li>
                            <li>
                                Isi deskripsi event selengkap mungkin, agar peserta dapat memahami event yang kamu buat.
                            </li>
                            <li>
                                Jika kamu ingin membuat event berbayar, maka isi kolom ticket price dan ticket qty. Jika tidak, maka kosongkan saja.
                            </li>
                            <li>
                                Upload dokumen yang menyatakan bahwa kamu ingin menyelenggarakan event. Kami akan verifikasi secara manual apakah event yang ingin kamu selenggarakan sudah sesuai ketentuan atau tidak.
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Booth</h4>
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
                                        <label>Event Name</label>
                                        <div 
                                            class="float-right"
                                            data-toggle="tooltip"
                                            title="Pilih nama event yang ingin kamu tambahkan booth">
                                            <label>
                                                <i class="fa-solid fa-circle-info"></i> Infomation
                                            </label>
                                        </div>
                                        <select class="form-control select2" id="event_name" name="event_name">
                                            @foreach($dataEvent as $data)
                                                <option value="{{$data->id}}">{{ $data->event_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Booth Code</label>
                                        <input
                                            id="booth_code"
                                            type="text"
                                            class="form-control @error('booth_code') is-invalid @enderror"
                                            name="booth_code"
                                            required>
                                        <!-- Error Message -->
                                        @error('booth_code')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Booth Size</label>
                                        <input
                                            id="booth_size"
                                            type="text"
                                            class="form-control @error('booth_size') is-invalid @enderror"
                                            name="booth_size"
                                            placeholder="Contoh: 3x3 meter"
                                            required>
                                        <!-- Error Message -->
                                        @error('booth_size')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Booth Price</label>
                                        <input
                                            id="rental_price"
                                            type="text"
                                            class="form-control @error('rental_price') is-invalid @enderror"
                                            name="rental_price"
                                            required>
                                        <!-- Error Message -->
                                        @error('rental_price')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label>Facilities</label>
                                        <div 
                                            class="float-right"
                                            data-toggle="tooltip"
                                            title="Pisahkan dengan koma untuk setiap fasilitas">
                                            <label>
                                                <i class="fa-solid fa-circle-info"></i> Infomation
                                            </label>
                                        </div>
                                        <textarea
                                            id="provided_facilities"
                                            type="text"
                                            class="form-control @error('provided_facilities') is-invalid @enderror"
                                            name="provided_facilities"
                                            data-height="80"
                                            required>
                                            
                                        </textarea>
                                        <!-- Error Message -->
                                        @error('provided_facilities')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label>Terms and Conditions</label>
                                        <textarea
                                            class="summernote @error('terms_and_conditions') is-invalid @enderror"
                                            name="terms_and_conditions"
                                            id="terms_and_conditions"
                                            required>
                                            
                                        </textarea>
                                        <!-- Error Message -->
                                        @error('terms_and_conditions')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Create Booth</button>
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