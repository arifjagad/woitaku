@extends('layouts.app')

@section('title', 'Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Cek Tiket Peserta</h1>
        </div>

        <div class="section-body">
            <div class="section-body">
                <!-- Pengecekan apakah ada data event atau tidak -->
                <div class="card">
                    <div class="card-header">
                        <h4>Cari Tiket Peserta Berdasarkan ID</h4>
                    </div>
                    <form action="{{ route('ticket-check') }}" method="post" class="mb-4">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="form-group col-lg-3">
                                        <label>Nama Event</label>
                                        <select class="form-control select2" id="event_name" name="event_name">
                                            @foreach($dataEvent as $data)
                                                <option value="{{$data->id}}">{{ $data->event_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-9">
                                        <label>ID Tiket</label>
                                        <input
                                            type="text"
                                            name="ticket_identifier"
                                            class="form-control"
                                            placeholder="Search events..."
                                            maxlength="6"
                                            oninput="this.value = this.value.toUpperCase();"
                                            >
                                    </div>
                                </div>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary btn-block">Cari Tiket</button>
                                </div>
                            </div>
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
@endpush
