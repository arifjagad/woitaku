@extends('layouts.app')

@section('title', 'Booth')

@push('style')

<link href="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.css" rel="stylesheet">
<link rel="stylesheet"
        href="{{ asset('library/prismjs/themes/prism.min.css') }}">
@endpush

@section('main')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar Booth</h1>
        </div>
        <h2 class="section-title">Daftar Semua Booth</h2>
        <p class="section-lead">
            Anda dapat melihat semua booth yang ada.
        </p>
        <div class="section-body">
            <div class="card">
                {{-- <div class="card-header">
                        <h4>Example Card</h4>
                    </div> --}}
                <div class="card-body">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table-striped table display nowrap" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            #
                                        </th>
                                        <th>Nama Event</th>
                                        <th>Kode Booth</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $id = 1; @endphp
                                    @foreach($datas as $key => $data)
                                    <tr>
                                        <td class="text-center">
                                            {{ $id++ }}
                                        </td>
                                        <td>{{ $data->event_name }}</td>
                                        <td>{{ $data->booth_code }}</td>
                                        <td>
                                            @if($data->availability_status == 'available')
                                                <span class="badge badge-success">Tersedia</span>
                                            @else
                                                <span class="badge badge-danger">Tidak Tersedia</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-primary show-detail" data-toggle="modal" data-target="#detailBooth{{ $key }}">Detail</a>
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
    <!-- Modal Detail Booth -->
    <div class="modal fade" id="detailBooth{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="detailBoothLabel" aria-hidden="true">
        <!-- Modal content -->
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailBoothLabel">Detail Booth</h5>
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
                                <td class="col-5">Kode Booth</td>
                                <td class="col-1">:</td>
                                <td class="col-6">{{ $data->booth_code }}</td>
                            </tr>
                            <tr>
                                <td class="col-5">Ukuran Booth</td>
                                <td class="col-1">:</td>
                                <td class="col-6">{{ $data->booth_size }}</td>
                            </tr>
                            <tr>
                                <td class="col-5">Biaya Sewa Booth</td>
                                <td class="col-1">:</td>
                                <td class="col-6">{{ $data->rental_price }}</td>
                            </tr>
                            <tr>
                                <td class="col-5">Fasilitas Booth</td>
                                <td class="col-1">:</td>
                                <td class="col-6">{!! $data->provided_facilities !!}</td>
                            </tr>
                            <tr>
                                <td class="col-5">Status</td>
                                <td class="col-1">:</td>
                                <td class="col-6">
                                    @if($data->availability_status == 'available')
                                        <span class="badge badge-success">Tersedia</span>
                                    @else
                                        <span class="badge badge-danger">Tidak Tersedia</span>
                                    @endif
                                </td>
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

@endpush
