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
            <h1>Create a new competition</h1>
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
                        <h4>Create Competition</h4>
                    </div>
                    <form
                        class="needs-validation"
                        novalidate=""
                        method="POST"
                        action="{{ route('update-competition-eo', ['id' => $dataCompetition->id]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label>Event Name</label>
                                        <div 
                                            class="float-right"
                                            data-toggle="tooltip"
                                            title="Pilih nama event yang ingin kamu tambahkan competition">
                                            <label>
                                                <i class="fa-solid fa-circle-info"></i> Infomation
                                            </label>
                                        </div>
                                        <select class="form-control select2" id="event_name" name="event_name">
                                            @foreach($dataEvent as $data)
                                                <option 
                                                    value="{{ $data->id }}"
                                                    {{ ($selectedEvent && $selectedEvent->contains('id', $data->id)) ? 'selected' : '' }}                                                    >
                                                    {{ $data->event_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Competition Name</label>
                                        <input
                                            id="competition_name"
                                            type="text"
                                            class="form-control @error('competition_name') is-invalid @enderror"
                                            name="competition_name"
                                            value="{{$dataCompetition->competition_name}}"
                                            required>
                                        <!-- Error Message -->
                                        @error('competition_name')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Competition Category</label>
                                        <div 
                                            class="float-right"
                                            data-toggle="tooltip"
                                            title="Pilih kategori yang sesuai">
                                            <label>
                                                <i class="fa-solid fa-circle-info"></i> Infomation
                                            </label>
                                        </div>
                                        <select class="form-control select2" id="competition_category" name="competition_category">
                                            @foreach($dataCompetitionCategory as $data)
                                                <option 
                                                    value="{{ $data->id }}"
                                                    {{ ($selectCompetitionCategory && $selectCompetitionCategory->contains('id', $data->id)) ? 'selected' : '' }}                                                    >
                                                    {{ $data->category_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label>Competition Description</label>
                                        <textarea
                                            class="summernote @error('competition_description') is-invalid @enderror"
                                            name="competition_description"
                                            id="competition_description"
                                            required>
                                            {{ $dataCompetition->competition_description }}
                                        </textarea>
                                        <!-- Error Message -->
                                        @error('competition_description')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Competition Start Date</label>
                                        <input type="text"
                                            name="competition_start_date"
                                            id="competition_start_date"
                                            class="form-control datepicker @error('competition_start_date') is-invalid @enderror"
                                            required
                                            value="{{ $dataCompetition->competition_start_date }}"
                                            >
                                        <!-- Error Message -->
                                        @error('competition_start_date')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Competition End Date</label>
                                        <input type="text"
                                            name="competition_end_date"
                                            id="competition_end_date"
                                            class="form-control datepicker @error('competition_end_date') is-invalid @enderror"
                                            required
                                            value="{{ $dataCompetition->competition_end_date }}"
                                            >
                                        <!-- Error Message -->
                                        @error('competition_end_date')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Competition Fee</label>
                                        <div 
                                            class="float-right"
                                            data-toggle="tooltip"
                                            title="Masukkan harga tiket jika competition ini berbayar">
                                                <label>
                                                    <i class="fa-solid fa-circle-info"></i> Infomation
                                                </label>
                                        </div>
                                        <input
                                            id="competition_fee"
                                            type="number"
                                            class="form-control @error('competition_fee') is-invalid @enderror"
                                            name="competition_fee"
                                            value="{{ $dataCompetition->competition_fee }}"
                                            >
                                        <!-- Error Message -->
                                        @error('competition_fee')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Participant Qty</label>
                                        <div 
                                            class="float-right"
                                            data-toggle="tooltip"
                                            title="Masukkan maximal participant">
                                                <label>
                                                    <i class="fa-solid fa-circle-info"></i> Infomation
                                                </label>
                                        </div>
                                        <input
                                            id="participant_qty"
                                            type="number"
                                            class="form-control @error('participant_qty') is-invalid @enderror"
                                            name="participant_qty"
                                            value="{{ $dataCompetition->participant_qty }}"
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
                            <button class="btn btn-primary">Create Competition</button>
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