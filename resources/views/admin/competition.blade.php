@extends('layouts.app')

@section('title', 'Competitions')

@push('style')

<link href="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.css" rel="stylesheet">
<link rel="stylesheet"
        href="{{ asset('library/prismjs/themes/prism.min.css') }}">
@endpush

@section('main')


<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar Perlombaan</h1>
        </div>
        <h2 class="section-title">Daftar Semua Perlombaan!</h2>
        <p class="section-lead">
            Anda dapat melihat semua perlombaan yang ada.
        </p>
        <div class="section-body">
            <div class="card">
                {{-- <div class="card-header">
                        <h4>Example Card</h4>
                    </div> --}}
                <div class="card-body">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table-striped table" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            #
                                        </th>
                                        <th>Nama Event</th>
                                        <th>Nama Perlombaan</th>
                                        <th>Biaya Pendaftaran</th>
                                        <th>Jumlah Partisipan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $id = 1; @endphp
                                    @foreach ($datas as $key => $data)
                                        <tr>
                                            <td class="text-center">{{ $id++ }}</td>
                                            <td>{{$data->event_name}}</td>
                                            <td>{{$data->competition_name}}</td>
                                            <td>IDR {{ number_format($data->competition_fee, 0, ',', '.') }}</td>
                                            <td>{{$data->participant_qty}} peserta</td>
                                            <td>
                                                <a href="#" class="btn btn-primary show-detail" data-toggle="modal" data-target="#detailCompetition{{ $key }}">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- <div class="card-footer bg-whitesmoke">
                    This is card footer
                </div> --}}
            </div>
        </div>
    </section>
</div>

@foreach ($datas as $key => $data)
    <!-- Modal Detail Competition -->
    <div class="modal fade" id="detailCompetition{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="detailCompetitionLabel" aria-hidden="true">
        <!-- Modal content -->
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailCompetitionLabel">Detail Perlombaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <td class="col-5">Nama Event</td>
                                <td class="col-1">:</td>
                                <td class="col-6">{{ $data->event_name }}</td>
                            </tr>
                            <tr>
                                <td class="col-5">Nama Perlombaan</td>
                                <td class="col-1">:</td>
                                <td class="col-6">{{ $data->competition_name }}</td>
                            </tr>
                            <tr>
                                <td class="col-5">Biaya Pendaftaran</td>
                                <td class="col-1">:</td>
                                <td class="col-6">
                                    @if ($data->competition_fee == 0 || $data->competition_fee == null)
                                        Gratis
                                    @else
                                        IDR. {{ number_format($data->competition_fee, 0, ',', '.') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="col-5">Jumlah Partisipan</td>
                                <td class="col-1">:</td>
                                <td class="col-6">{{ $data->participant_qty }}</td>
                            </tr>
                            <tr>
                                <td class="col-5">Tanggal Berlangsung Perlombaan</td>
                                <td class="col-1">:</td>
                                <td class="col-6">{{ Carbon\Carbon::parse($data->competition_start_date)->translatedFormat('d F Y') }} - {{ Carbon\Carbon::parse($data->competition_end_date)->translatedFormat('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td class="col-5">Deskripsi Perlombaan</td>
                                <td class="col-1">:</td>
                                <td class="col-6">{!! $data->competition_description !!}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection @push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
<script src="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.js"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('js/page/modules-datatables.js') }}"></script>
<!-- Show Modal -->
@endpush
