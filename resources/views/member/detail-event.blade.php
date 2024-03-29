@extends('layouts.app-member') 
@section('title', $detailEvent->event_name)

@push('style')
<link rel="stylesheet"
        href="{{ asset('library/select2/dist/css/select2.min.css') }}">
<style>
    .preview-image {
        width: 300px;
        height: 300px;
        object-fit: cover;
        border-radius: 5px;
        margin-right: 6px;
    }
</style>
@endpush

@section('main')

<div class="main-content" style="padding: 80px 0px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <h3 class="text-primary mb-4">{{ $detailEvent->event_name }} </h3>
                        <ul class="nav nav-pills nav-fill flex-column flex-sm-row" id="myTab3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active"
                                    id="detail-event-tab"
                                    data-toggle="tab" 
                                    href="#detail-event" 
                                    role="tab" 
                                    aria-controls="detail-event" 
                                    aria-selected="true">Detail Event</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" 
                                    id="perlombaan-tab" 
                                    data-toggle="tab" 
                                    href="#perlombaan" 
                                    role="tab" 
                                    aria-controls="perlombaan" 
                                    aria-selected="false">Daftar Perlombaan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" 
                                    id="booth-tab" 
                                    data-toggle="tab" 
                                    href="#booth" 
                                    role="tab" 
                                    aria-controls="booth" 
                                    aria-selected="false">Daftar Booth</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" 
                                    id="pendaftaran-booth-tab" 
                                    data-toggle="tab" 
                                    href="#pendaftaran-booth" 
                                    role="tab" 
                                    aria-controls="pendaftaran-booth" 
                                    aria-selected="false">Pendaftaran Booth</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-4" id="myTabContent2">
                            <!-- Isi konten tab di sini -->
                            <div class="tab-pane fade show active"
                                id="detail-event"
                                role="tabpanel"
                                aria-labelledby="detail-event-tab">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-8">
                                        <div class="d-flex justify-content-between" style="position: relative;">
                                            <img src="{{ asset('storage/'.$detailEvent->featured_image) }}" alt="" class="img-fluid rounded" style="width: 100%; height: auto;">
                                            @if(\Carbon\Carbon::parse($detailEvent->end_date)->addDay()->isPast())
                                                <span class="badge badge-secondary text-uppercase py-2 px-4" style="position: absolute; top: 30px; left: 50px;">
                                                    <span class="text-dark">Event Berakhir</span>
                                                </span>
                                            @endif
                                            
                                            <span class="badge badge-success text-uppercase py-2 px-4" style="position: absolute; top: 30px; right: 50px;">
                                                @if ($detailEvent->ticket_price == 0)
                                                    GRATIS
                                                @else
                                                    BERBAYAR
                                                @endif
                                            </span>
                                        </div>
                                        <p>
                                            {!! $detailEvent->event_description !!}
                                        </p>
                                        
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-4">
                                        @if ($detailEvent->ticket_price == 0)
                                            @if(Auth::check())
                                                @if(strtotime(now()) < strtotime((new Carbon\Carbon($detailEvent->end_date))->addDays()))
                                                    <form action="{{ route('payment-ticket-free') }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-lg btn-block text-uppercase mt-3 mb-4 py-3" style="font-size: 16px;">Daftar Sekarang</button>
                                                    </form>
                                                @else
                                                    <a href="#" class="btn btn-success btn-lg btn-block text-uppercase mt-3 mb-4 py-3" style="font-size: 16px;" onclick="checkEventDate()">Daftar Sekarang</a>
                                                @endif
                                            @else
                                            <a href="#" class="btnTransaksi btn btn-success btn-lg btn-block text-uppercase mt-3 mb-4 py-3" style="font-size: 16px;">Daftar Sekarang</a>
                                        @endif
                                        @else
                                            @if(Auth::check())
                                                @if($detailEvent->ticket_qty == 0)
                                                    <div class="alert alert-info text-center">
                                                        Tiket sudah habis terjual!
                                                    </div>
                                                    @elseif(strtotime(now()) < strtotime((new Carbon\Carbon($detailEvent->end_date))->addDays()))
                                                        <a href="#" class="btn btn-success btn-lg btn-block text-uppercase mt-3 mb-4 py-3" style="font-size: 16px;" data-toggle="modal" data-target="#ticketModal">
                                                        Beli Tiket
                                                        </a>
                                                @else
                                                    <a href="#" class="btn btn-success btn-lg btn-block text-uppercase mt-3 mb-4 py-3" style="font-size: 16px;" onclick="checkEventDate()">Beli Tiket</a>
                                                @endif
                                            @else
                                                <a href="#" class="btnTransaksi btn btn-success btn-lg btn-block text-uppercase mt-3 mb-4 py-3" style="font-size: 16px;">Beli Tiket</a>
                                            @endif
                                        @endif
                        
                                        <!-- Detail Event -->
                                        <div>
                                            <div class="card-header">
                                                <h4 class="card-title">Informasi Event</h4>
                                            </div>
                                            <div>
                                                <table class="table">
                                                    <tr>
                                                        <td class="col-6"><b>Tanggal mulai:</b></td>
                                                        <td>{{ \Carbon\Carbon::parse($detailEvent->start_date)->translatedFormat('d F Y') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-6"><b>Tanggal berakhir:</b></td>
                                                        <td>{{ \Carbon\Carbon::parse($detailEvent->end_date)->translatedFormat('d F Y') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-6"><b>Lokasi:</b></td>
                                                        <td>{{ $detailEvent->city . ', Indonesia' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-6"><b>Alamat:</b></td>
                                                        <td>{{ $detailEvent->address }}</td>
                                                    </tr>
                                                    @if ($detailEvent->ticket_price == 0)
                                                        
                                                    @else
                                                        <tr>
                                                            <td class="col-6"><b>Harga tiket:</b></td>
                                                            <td>IDR. {{ number_format($detailEvent->ticket_price, 0, ',', '.') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-6"><b>Sisa tiket:</b></td>
                                                            <td>{{$detailEvent->ticket_qty }} tiket</td>
                                                        </tr>
                                                    @endif
                                                </table>
                                            </div>
                                        </div>
                        
                                        <!-- Detail Organizer -->
                                        <div>
                                            <div class="card-header">
                                                <h4 class="card-title">Informasi Penyelenggara</h4>
                                            </div>
                                            <div>
                                                <table class="table">
                                                    <tr>
                                                        <td class="col-6"><b>Nama:</b></td>
                                                        <td>{{ $detailEvent->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-6"><b>Email:</b></td>
                                                        <td>{{ $detailEvent->email }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-6"><b>WhatsApp:</b></td>
                                                        <td>{{ $detailEvent->nomor_whatsapp }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-6"><b>Alamat:</b></td>
                                                        <td>{{ $detailEvent->address }}</td>
                                                    </tr>
                                                    {{-- <tr>
                                                        <td class="col-6"><b>Deskripsi:</b></td>
                                                        <td>{!! $detailEvent->description !!}</td>
                                                    </tr> --}}
                                                </table>
                                                <a href="{{ route('detail-event-organizer', ['eoName' => Str::slug($detailEvent->name)]) }}" class="btn btn-primary btn-block">Profil Penyelenggara</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tampilan List Perlombaan -->
                            <div class="tab-pane fade"
                                id="perlombaan"
                                role="tabpanel"
                                aria-labelledby="perlombaan-tab">
                                
                                <div class="row">
                                    @forelse($listCompetition as $key => $data)
                                        @php session(['competition_id' => $data->id]); @endphp
                                        <div class="col-sm-12 col-md-6 col-lg-4 my-2">
                                            <div class="card card-primary h-100">
                                                <img src="{{ asset('storage/'.$data->thumbnail_competition) }}" alt="" class="img-fluid rounded" style="width: 100%; height: auto;">

                                                <div class="card-header">
                                                    <h4>{{ $data->competition_name }}</h4>
                                                </div>
                                                <div class="card-body">
                                                    {!! \Illuminate\Support\Str::limit(strip_tags($data->competition_description), 50) !!}
                                                </div>
                                                <div class="card-footer">
                                                    <a href="#" class="btn btn-primary show-detail" data-toggle="modal" data-target="#detailCompetitionModal{{ $key }}">Detail</a>
                                                    @if(Auth::check())
                                                        @if(strtotime(now()) < strtotime((new Carbon\Carbon($detailEvent->end_date))->addDays()))
                                                            <a href="#" class="btn btn-success show-detail" data-toggle="modal" data-target="#daftarCompetitionModal{{ $key }}">Daftar</a>
                                                        @else
                                                            <a href="#" class="btn btn-success" onclick="checkEventDate()">Daftar</a>
                                                        @endif
                                                    @else
                                                        <a href="#" class="btnTransaksi btn btn-success">Daftar</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Detail Perlombaan -->
                                        <div class="modal fade" id="detailCompetitionModal{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="detailCompetitionModalLabel" aria-hidden="true">
                                            <!-- Modal content -->
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="detailCompetitionModalLabel">Detail Perlombaan</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-sm-12 col-md-12 col-lg-6">
                                                                <h3 class="text-primary">{{ $data->competition_name }}</h3>
                                                            </div>
                                                            <div class="col-sm-12 col-md-12 col-lg-6">
                                                                @if ($data->competition_fee == 0)
                                                                    <h3 class="text-primary float-lg-right">GRATIS</h3>
                                                                @else
                                                                    <h3 class="text-primary float-lg-right">IDR. {{ number_format($data->competition_fee, 0, ',', '.') }}</h3>
                                                                @endif
                                                            </div>
                                                            <div class="col-sm-12 col-md-12 col-lg-6">
                                                                <h6>Sisa partisipan: <span>{{ $data->participant_qty }}</span> peserta</h6>
                                                            </div>
                                                            <div class="col-sm-12 col-md-12 col-lg-6">
                                                                <h6 class="float-lg-right">
                                                                    {{ \Carbon\Carbon::parse($data->competition_start_date)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($data->competition_end_date)->translatedFormat('d F Y') }}
                                                                </h6>
                                                            </div>
                                                            <div class="col-12">
                                                                <p class="text-justify mt-3">
                                                                    {!! $data->competition_description !!}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Daftar Perlombaan -->
                                        <div class="modal fade" id="daftarCompetitionModal{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="daftarCompetitionModalLabel" aria-hidden="true">
                                            <!-- Modal content -->
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <form action="{{ route('payment-competition') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="competition_id" value="{{ $data->id }}" />
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="daftarCompetitionModalLabel">Pendaftaran Perlombaan</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <table class="table">
                                                                <tr>
                                                                    <td class="col-5"><b>Nama Perlombaan:</b></td>
                                                                    <td>{{ $data->competition_name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="col-5"><b>Tanggal mulai:</b></td>
                                                                    <td>{{ \Carbon\Carbon::parse($data->competition_start_date)->translatedFormat('l, d F Y') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="col-5"><b>Tanggal berakhir:</b></td>
                                                                    <td>{{ \Carbon\Carbon::parse($data->competition_end_date)->translatedFormat('l, d F Y') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="col-5"><b>Sisa partisipan:</b></td>
                                                                    <td>{{ $data->participant_qty }} peserta</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="col-5"><b>Biaya pendaftaran:</b></td>
                                                                    <td>
                                                                        @if ($data->competition_fee == 0)
                                                                            GRATIS
                                                                        @else
                                                                            IDR. {{ number_format($data->competition_fee, 0, ',', '.') }}
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                @if ($data->competition_fee != 0)
                                                                    <tr>
                                                                        <td class="col-5"><b>Metode Pembayaran:</b></td>
                                                                        <td>
                                                                            <div class="input-group">
                                                                                <select class="form-control select2" name="payment_method">
                                                                                    @foreach ($detailPaymentMethod as $method)
                                                                                        <option value="{{ $method->id }}">Transfer {{ $method->bank_name }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                            @if($data->participant_qty == 0)
                                                                <button id="btnCompetition" type="button" class="btn btn-success">Daftar Sekarang</button>
                                                            @else
                                                                <button type="submit" class="btn btn-success">Daftar Sekarang</button>
                                                            @endif
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <div class="empty-state"
                                                data-height="400">
                                                <div class="empty-state-icon">
                                                    <i class="fas fa-question"></i>
                                                </div>
                                                <h2>Maaf, event ini tidak memiliki perlombaan.</h2>
                                                <p class="lead">
                                                    Harap bersabar dan tunggu informasi selanjutnya, ketika penyelenggara acara menambahkan perlombaan baru.
                                                </p>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Tampilan List Booth -->
                            <div class="tab-pane fade"
                                id="booth"
                                role="tabpanel"
                                aria-labelledby="booth-tab">

                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <img src="{{
                                            asset('storage/'.$detailEvent->booth_layout)
                                        }}" alt="" class="img-fluid rounded" style="width: 100%; height: auto;">
                                    </div>
                                    @forelse($listBooth as $key => $data)
                                        <div class="col-12 col-md-6 col-lg-4 my-2">
                                            <div class="card card-primary h-100">
                                                <img src="{{ asset('storage/'.$data->thumbnail_booth) }}" alt="" class="img-fluid rounded" style="width: 100%; height: auto;">

                                                <div class="d-flex justify-content-between card-header">
                                                    <h4>{{ $data->booth_code }}</h4>
                                                    <h4>{{ $data->booth_name }}</h4>
                                                </div>
                                                <div class="card-body">
                                                    <p class="text-justify">
                                                        {!! \Illuminate\Support\Str::limit(strip_tags($data->booth_description), 150) !!}
                                                    </p>
                                                </div>
                                                <div class="card-footer">
                                                    <button class="btn btn-primary btn-block show-detail" data-toggle="modal" data-target="#listProductBooth{{ $key }}">Lihat Daftar Produk Booth</button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal List Produk Booth -->
                                        <div class="modal fade" id="listProductBooth{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="listProductBoothLabel" aria-hidden="true">
                                            <!-- Modal content -->
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="listProductBoothLabel">Daftar Produk Booth</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body  row text-center">
                                                        @foreach (json_decode($data->booth_image) as $key => $image)
                                                            <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                                                                <a href="{{ asset('storage/booth_images/'.$image) }}"
                                                                    target="_blank"
                                                                    data-toggle="tooltip"
                                                                    data-original-title="Open image new tab!">
                                                                        <img
                                                                            src="{{ asset('storage/booth_images/'.$image) }}"
                                                                            class="img-fluid preview-image"
                                                                            alt="Image {{ $key + 1 }}"
                                                                        >
                                                                </a>                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <div class="empty-state"
                                                data-height="400">
                                                <div class="empty-state-icon">
                                                    <i class="fas fa-question"></i>
                                                </div>
                                                <h2>Maaf, event ini tidak memiliki booth.</h2>
                                                <p class="lead">
                                                    Harap bersabar dan tunggu informasi selanjutnya, ketika penyelenggara acara menambahkan booth baru.
                                                </p>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Tampilan Pendaftaran Booth -->
                            <div class="tab-pane fade"
                                id="pendaftaran-booth"
                                role="tabpanel"
                                aria-labelledby="pendaftaraan-booth-tab">
                                @if(is_null($dataBooth))
                                    <div class="col-12">
                                        <div class="empty-state"
                                            data-height="400">
                                            <div class="empty-state-icon">
                                                <i class="fas fa-question"></i>
                                            </div>
                                            <h2>Maaf, event ini tidak memiliki booth.</h2>
                                            <p class="lead">
                                                Harap bersabar dan tunggu informasi selanjutnya, ketika penyelenggara acara menambahkan booth baru.
                                            </p>
                                        </div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-12 mb-4">
                                            <img src="{{
                                                asset('storage/'.$detailEvent->booth_layout)
                                            }}" alt="" class="img-fluid rounded" style="width: 100%; height: auto;">
                                        </div>
                                        <div class="col-12 card">
                                            <div class="input-group">
                                                <div class="form-group col-12">
                                                    <label>Kode Booth</label>
                                                    <div 
                                                        class="float-right"
                                                        data-toggle="tooltip"
                                                        title="Pilih lokasi booth yang di-inginkan">
                                                        <label>
                                                            <i class="fa-solid fa-circle-info"></i> Informasi
                                                        </label>
                                                    </div>
                                                    <select class="form-control select2" name="booth_code" id="booth_code">
                                                        <option value="">Pilih Booth</option>
                                                        @foreach ($boothCode as $data)
                                                            <option value="{{ $data->id }}">
                                                                {{ $data->booth_code }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div id="booth_info">
                                                        @include('booth_info', ['detailBooth' => $detailBooth])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Beli Tiket -->
<div class="modal fade" id="ticketModal" tabindex="-1" role="dialog" aria-labelledby="ticketModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('payment-ticket') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="ticketModalLabel">Pembelian Tiket</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <td class="col-5"><b>Nama Event:</b></td>
                            <td>{{ $detailEvent->event_name }}</td>
                        </tr>
                        <tr>
                            <td class="col-5"><b>Pilih Tanggal:</b></td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control select2" name="selected_date">
                                        @for ($i = 0; $i <= $daysDifference; $i++)
                                            @php
                                                $currentDate = $start_date_event->copy()->addDays($i);
                                            @endphp
                                            <option value="{{ $currentDate->translatedFormat('Y-m-d') }}">
                                                {{ $currentDate->translatedFormat('d F Y') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-5"><b>Harga Tiket:</b></td>
                            <td>
                                IDR. {{ number_format($detailEvent->ticket_price, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="col-5"><b>Jumlah Tiket:</b></td>
                            <td>
                                <div class="input-group">
                                    <input type="number" class="form-control" value="1" min="1" max="{{ $detailEvent->ticket_qty }}" id="ticketQuantity" name="ticket_quantity">
                                </div>
                            </td>
                        </tr>
                    </table>
                    <hr class="my-4">
                    <table class="table">
                        <tr>
                            <td class="col-5"><b>Total Pembayaran:</b></td>
                            <td id="totalPayment">IDR. {{ number_format($detailEvent->ticket_price, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                    <hr class="my-4">
                    <table class="table">
                        <tr>
                            <td class="col-5"><b>Metode Pembayaran:</b></td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control select2" name="payment_method">
                                        @foreach ($detailPaymentMethod as $method)
                                            <option value="{{ $method->id }}">Transfer {{ $method->bank_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    @php session(['event_id' => $detailEvent->id]); @endphp
                    <button type="submit" class="btn btn-success">Beli Tiket</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection @push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script> --}}

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>

<!-- Custom JS -->
<script>
    // Sweetalert untuk user yg belum login
    document.querySelectorAll('.btnTransaksi').forEach(function(button) {
        button.addEventListener('click', function() {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Anda harus login terlebih dahulu untuk melakukan pendaftaran!',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        });
    });

    // Menghitung total harga secara live untuk pembelian tiket event
    $(document).ready(function() {
        function updateTotalPayment() {
            var ticketPrice = parseFloat({{ $detailEvent->ticket_price }});
            var ticketQuantity = parseInt($('#ticketQuantity').val());

            var totalPayment = ticketPrice * ticketQuantity;

            $('#totalPayment').text('IDR. ' + totalPayment.toLocaleString('en-ID'));
        }

        updateTotalPayment();

        $('#ticketQuantity').on('input', function() {
            updateTotalPayment();
        });
    });
</script>
<script>
    function checkEventDate() {
        var eventEndDate = '{{ $detailEvent->end_date }}';
        var today = moment().format('YYYY-MM-DD');

        if (new Date(eventEndDate) <= new Date(today)) {
            Swal.fire({
                icon: 'error',
                title: 'Event Telah Berakhir!',
                text: 'Maaf, event ini telah berakhir.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            });
        } else {
        }
    }

    function checkEventDateBooth() {
        var eventStartDate = '{{ $detailEvent->start_date }}';
        var today = moment().format('YYYY-MM-DD');
        
        if (new Date(eventStartDate) <= new Date(today)) {
            Swal.fire({
                icon: 'info',
                title: 'Event Telah Dimulai!',
                text: 'Maaf, Anda tidak bisa melakukan penyewaan booth lagi.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            });
        } else {
        }
    }
    

    document.getElementById('btnCompetition').addEventListener('click', function() {
        // Tampilkan SweetAlert
        Swal.fire({
            icon: 'error',
            title: 'Tidak ada slot tersedia!',
            text: 'Maaf, partisipan perlombaan sudah penuh.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });
    });

    document.getElementById('btnEvent').addEventListener('click', function() {
        // Tampilkan SweetAlert
        Swal.fire({
            icon: 'error',
            title: 'Tiket event sudah habis terjual!',
            text: 'Maaf, tiket untuk event ini sudah habis terjual. Terima kasih atas minat Anda!',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#booth_code').change(function () {
            // Ambil nilai booth_code yang dipilih
            var selectedBoothId = $(this).val();

            $.ajax({
                url: '/get-booth-info/' + selectedBoothId,
                type: 'GET',
                data: { booth_code: selectedBoothId },
                success: function (response) {
                    // Tampilkan data booth di dalam div dengan id "booth_info"
                    $('#booth_info').html(response);
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        // Tangani klik pada tombol "Pesan Booth"
        $('#btnPesanBoothModal').on('click', function () {
            // Ambil nilai data-rental-id dari tombol yang diklik
            var rentalId = $(this).data('rental-id');

            // Setel nilai input tersembunyi pada modal sesuai dengan data-rental-id
            $('#daftarRentalBoothModal').find('input[name="rentalBooth_id"]').val(rentalId);

            // Tampilkan modal
            $('#daftarRentalBoothModal').modal('show');
        });
    });
</script>
@endpush