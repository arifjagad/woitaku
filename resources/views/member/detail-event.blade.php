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
                        <ul class="nav nav-pills nav-fill" id="myTab3" role="tablist">
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
                                    <div class="col-8">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between" style="position: relative;">
                                                <img src="{{ asset('storage/'.$detailEvent->featured_image) }}" alt="" class="img-fluid rounded" style="width: 100%; height: auto;">
                                                @if(\Carbon\Carbon::parse($detailEvent->end_date)->isPast())
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
                                            <div class="card-body">
                                                <p>
                                                    {!! $detailEvent->event_description !!}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        @if ($detailEvent->ticket_price == 0)
                                            @if(Auth::check())
                                                <form action="{{ route('payment-ticket-free') }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-lg btn-block text-uppercase mt-3 mb-4 py-3" style="font-size: 16px;">Daftar Sekarang</button>
                                                </form>
                                            @else
                                                <a href="#" class="btnTransaksi btn btn-success btn-lg btn-block text-uppercase mt-3 mb-4 py-3" style="font-size: 16px;">Daftar Sekarang</a>
                                            @endif
                                        @else
                                            @if(Auth::check())
                                                @php session(['event_id' => $detailEvent->id]); @endphp
                                                <a href="#" class="btn btn-success btn-lg btn-block text-uppercase mt-3 mb-4 py-3" style="font-size: 16px;" onclick="checkEventDate()">
                                                    Beli Tiket
                                                </a>
                                            @else
                                                <a href="#" class="btnTransaksi btn btn-success btn-lg btn-block text-uppercase mt-3 mb-4 py-3" style="font-size: 16px;">Beli Tiket</a>
                                            @endif
                                        @endif
                        
                                        <!-- Detail Event -->
                                        <div class="card">
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
                                                        <td>{{ $detailEvent->kota . ', Indonesia' }}</td>
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
                                        <div class="card">
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
                                                <a href="#" class="btn btn-primary btn-block">Profil Penyelenggara</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Tampilan Detail Perlombaan -->
                            <div class="tab-pane fade"
                                id="perlombaan"
                                role="tabpanel"
                                aria-labelledby="perlombaan-tab">
                                
                                <div class="row">
                                    @forelse($listCompetition as $key => $data)
                                        @php session(['competition_id' => $data->id]); @endphp
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="card card-primary h-100">
                                                <div class="card-header">
                                                    <h4>{{ $data->competition_name }}</h4>
                                                </div>
                                                <div class="card-body">
                                                    {!! \Illuminate\Support\Str::limit(strip_tags($data->competition_description), 50) !!}
                                                </div>
                                                <div class="card-footer">
                                                    <a href="#" class="btn btn-primary show-detail" data-toggle="modal" data-target="#detailCompetitionModal{{ $key }}">Detail</a>
                                                    @if(Auth::check())
                                                        @if($data->end_date != true)
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
                                                        <div class="d-flex justify-content-between">
                                                            <h3 class="text-primary">{{ $data->competition_name }}</h3>
                                                            @if ($data->competition_fee == 0)
                                                                <h3 class="text-primary">GRATIS</h3>
                                                            @else
                                                                <h3 class="text-primary">IDR. {{ number_format($data->competition_fee, 0, ',', '.') }}</h3>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex justify-content-between">
                                                            <h6>Sisa partisipan: <span>{{ $data->participant_qty }}</span> peserta</h6>
                                                            <div>
                                                                <h6>
                                                                    {{ \Carbon\Carbon::parse($data->competition_start_date)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($data->competition_start_date)->translatedFormat('d F Y') }}
                                                                </h6>
                                                            </div>
                                                        </div>
                                        
                                                        <p class="text-justify mt-3">
                                                            {!! $data->competition_description !!}
                                                        </p>
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
                                                            <button type="submit" class="btn btn-success">Daftar Sekarang</button>
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
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="card card-primary h-100">
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
                                                    <div class="modal-body row">
                                                        @foreach (json_decode($data->booth_image) as $key => $image)
                                                            <div class="col-4 mb-4">
                                                                <img src="{{ asset('storage/booth_images/'.$image) }}" class="img-fluid preview-image" alt="Image {{ $key + 1 }}">
                                                            </div>
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
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <img src="{{
                                            asset('storage/'.$detailEvent->booth_layout)
                                        }}" alt="" class="img-fluid rounded" style="width: 100%; height: auto;">
                                    </div>
                                    @forelse($detailBooth as $key => $data)
                                        <div class="col-12 col-md-6 col-lg-4">
                                        <div class="card card-primary h-100">
                                                <div class="d-flex justify-content-between card-header">
                                                    <h4>{{ $data->booth_code }}</h4>
                                                    @if ($data->availability_status == 'available')
                                                        <span class="badge badge-success text-uppercase py-2 px-4">
                                                            Tersedia
                                                        </span>
                                                    @else
                                                        <span class="badge badge-danger text-uppercase py-2 px-4">
                                                            Tidak Tersedia
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="card-body">
                                                </div>
                                                <div class="card-footer">
                                                    <a href="#" class="btn btn-primary show-detail" data-toggle="modal" data-target="#detailRentalBoothModal{{ $key }}">Detail</a>
                                                    @if($data->availability_status == 'available')
                                                        @if(Auth::check())
                                                            @if($data->end_date != true)
                                                                <a href="#" class="btn btn-success show-detail" data-toggle="modal" data-target="#daftarRentalBoothModal{{ $key }}">Pesan Booth</a>
                                                            @else
                                                                <a href="#" class="btn btn-success" onclick="checkEventDate()">Pesan Booth</a>
                                                            @endif
                                                        @else
                                                            <a href="#" class="btnTransaksi btn btn-success">Pesan Booth</a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Detail Booth -->
                                        <div class="modal fade" id="detailRentalBoothModal{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="detailRentalBoothModalLabel" aria-hidden="true">
                                            <!-- Modal content -->
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="detailRentalBoothModalLabel">Detail Booth</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="d-flex justify-content-between">
                                                            <h3 class="text-primary">{{ $data->booth_code }}</h3>
                                                            <h3 class="text-primary">IDR {{ number_format($data->rental_price, 0, ',', '.') }}</h3>
                                                        </div>
                                                        <div class="d-flex justify-content-between">
                                                            <h6>Ukuran: <span>{{ $data->booth_size }} m<sup>2</sup></span></h6>
                                                            <div>
                                                                <h6>
                                                                    {{ \Carbon\Carbon::parse($data->start_date)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($data->end_date)->translatedFormat('d F Y') }}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                        <h6 class="mt-5">Fasilitas:</h6>
                                                        <p class="text-justify mt-2">
                                                            {!! $data->provided_facilities !!}
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Pemesanan Booth -->
                                        <div class="modal fade" id="daftarRentalBoothModal{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="daftarRentalBoothModalLabel" aria-hidden="true">
                                            <!-- Modal content -->
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <form action="{{ route('payment-booth') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="rentalBooth_id" value="{{ $data->id }}" />
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="daftarRentalBoothModalLabel">Pendaftaran Booth</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <table class="table">
                                                                <tr>
                                                                    <td class="col-5"><b>Code Booth:</b></td>
                                                                    <td>{{ $data->booth_code }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="col-5"><b>Biaya pendaftaran:</b></td>
                                                                    <td>IDR {{ number_format($data->rental_price, 0, ',', '.') }}</td>
                                                                </tr>
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
                                                            <button type="submit" class="btn btn-success">Pesan Booth</button>
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
                                                <h2>Maaf, event ini tidak menyewakan booth.</h2>
                                                <p class="lead">
                                                    Harap bersabar dan tunggu informasi selanjutnya, ketika penyelenggara acara menambahkan booth baru.
                                                </p>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
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
        var today = new Date();

        if (new Date(eventEndDate) < today) {
            Swal.fire({
                icon: 'error',
                title: 'Event Telah Berakhir!',
                text: 'Maaf, event ini telah berakhir.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            });
        } else {
            // Lakukan apa yang diperlukan jika event masih berlangsung
            // Contoh: Tampilkan modal atau lanjutkan ke halaman pembelian tiket
        }
    }
</script>

@endpush