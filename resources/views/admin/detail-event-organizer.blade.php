@extends('layouts.app')

@section('title', 'Event Organizer Details')

@push('style')
    <!-- CSS Libraries -->
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.8/fc-4.3.0/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('main')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Event Organizer - {{ $dataProfile->first()->name }}</h1>
        </div>
        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12">
                    <div class="card profile-widget">
                        <div class="profile-widget-header">
                            <img alt="image"
                                src="{{ asset('img/avatar/avatar-1.png') }}"
                                class="rounded-circle profile-widget-picture">
                            <div class="profile-widget-items">
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Dibuat Pada</div>
                                    <div class="profile-widget-item-value">{{ \Carbon\Carbon::parse($dataProfile->first()->created_at)->format('d-m-Y') }}</div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Jumlah Event</div>
                                    <div class="profile-widget-item-value">{{$eventCount}}</div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Jumlah Perlombaan</div>
                                    <div class="profile-widget-item-value">{{$competitionCount}}</div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Jumlah Booth</div>
                                    <div class="profile-widget-item-value">{{$boothCount}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-widget-description">
                            <p class="profile-widget-name">
                                {{ $dataProfile->first()->name }}
                            </p>
                            <p class="text-justify">
                                {{ $dataProfile->first()->description }}
                            </p>
                        </div>
                    </div>
                </div>
                <!-- List Events -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Daftar Event</h4>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{route('event')}}" target="_blank" class="btn btn-primary">Lihat Semua Event</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                #
                                            </th>
                                            <th>Nama Event</th>
                                            <th>Dibuat Pada</th>
                                            <th>Verification Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $id = 1; @endphp
                                        @foreach ($dataEvent as $data)
                                            <tr>
                                                <td class="text-center">{{ $id++ }}</td>
                                                <td>{{ $data->event_name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y') }}</td>
                                                <td>
                                                    @php if ($data->verification == 'pending') {
                                                        echo '<span class="badge badge-warning">Pending</span>';
                                                    } elseif ($data->verification == 'accepted') {
                                                        echo '<span class="badge badge-success">Accepted</span>';
                                                    } elseif ($data->verification == 'revision') {
                                                        echo '<span class="badge badge-info">Revision</span>';
                                                    }else {
                                                        echo '<span class="badge badge-danger">Rejected</span>';
                                                    } @endphp
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- List Competitions -->
                    <div class="card">
                        <div class="card-header">
                            <h4>Daftar Perlombaan</h4>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{route('competition')}}" target="_blank" class="btn btn-primary">Lihat Semua Perlombaan</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table" id="table-2">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                #
                                            </th>
                                            <th>Nama Event</th>
                                            <th>Nama Perlombaan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $id = 1; @endphp
                                        @foreach ($dataCompetition as $data)
                                            <tr>
                                                <td class="text-center">{{ $id++ }}</td>
                                                <td>{{ $data->event_name }}</td>
                                                <td>{{ $data->competition_name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- List Booth -->
                    <div class="card">
                        <div class="card-header">
                            <h4>Daftar Booth</h4>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{route('booth')}}" target="_blank" class="btn btn-primary">Lihat Semua Booth</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table" id="table-3">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                #
                                            </th>
                                            <th>Nama Event</th>
                                            <th>Kode Booth</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $id = 1; @endphp
                                        @foreach ($dataBooth as $data)
                                            <tr>
                                                <td class="text-center">{{ $id++ }}</td>
                                                <td>{{ $data->event_name }}</td>
                                                <td>{{ $data->booth_code }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.8/fc-4.3.0/datatables.min.js"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#table-3').DataTable();
        });
        </script>
@endpush
