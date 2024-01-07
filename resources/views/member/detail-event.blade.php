@extends('layouts.app-member') 
@section('title', $detailEvent->event_name)

@push('style')
<link rel="stylesheet"
        href="{{ asset('library/select2/dist/css/select2.min.css') }}">
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
                                    aria-selected="false">List Perlombaan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" 
                                    id="booth-tab" 
                                    data-toggle="tab" 
                                    href="#booth" 
                                    role="tab" 
                                    aria-controls="booth" 
                                    aria-selected="false">List Booth</a>
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
                                            <div class="card-header">
                                                <img src="{{
                                                    asset('storage/'.$detailEvent->featured_image)
                                                }}" alt="" class="img-fluid rounded" style="width: 100%; height: auto;">
                                                <span style="position: absolute; top: 30px; right: 40px;" class="badge badge-success text-uppercase py-2 px-4">
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
                                                <form action="{{ route('daftar-sekarang') }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-lg btn-block text-uppercase mt-3 mb-4 py-3" style="font-size: 16px;">Daftar Sekarang</button>
                                                </form>
                                            @else
                                                <a href="#" class="btnTransaksi btn btn-success btn-lg btn-block text-uppercase mt-3 mb-4 py-3" style="font-size: 16px;">Daftar Sekarang</a>
                                            @endif
                                        @else
                                            @if(Auth::check())
                                                @php session(['event_id' => $detailEvent->id]); @endphp
                                                <a href="#" class="btn btn-success btn-lg btn-block text-uppercase mt-3 mb-4 py-3" style="font-size: 16px;" data-toggle="modal" data-target="#beliTiketModal">
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
                                                        <td>{{ \Carbon\Carbon::parse($detailEvent->start_date)->format('d F Y') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-6"><b>Tanggal berakhir:</b></td>
                                                        <td>{{ \Carbon\Carbon::parse($detailEvent->end_date)->format('d F Y') }}</td>
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
                                                    <tr>
                                                        <td class="col-6"><b>Deskripsi:</b></td>
                                                        <td>{!! $detailEvent->description !!}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade"
                                id="perlombaan"
                                role="tabpanel"
                                aria-labelledby="perlombaan-tab">
                                
                                <div class="row">
                                    @forelse($detailCompetition as $data)
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h4>{{ $data->competition_name }}</h4>
                                                </div>
                                                <div class="card-body">
                                                    {!! \Illuminate\Support\Str::limit(strip_tags($data->competition_description), 50) !!}
                                                </div>
                                                <div class="card-footer">
                                                    {{-- <a href="#" class="btn btn-primary">Detail</a> --}}
                                                    <button class="btn btn-primary" 
                                                        onclick="showDetailsModal(
                                                            '{{ $data->competition_name }}',
                                                            '{{ number_format($data->competition_fee, 0, ',', '.') }}',
                                                            '{{ $data->participant_qty }}',
                                                            '{{ \Carbon\Carbon::parse($data->competition_start_date)->format('d F Y') }}',
                                                            '{{ \Carbon\Carbon::parse($data->competition_end_date)->format('d F Y') }}',
                                                            '{{ trim(addslashes(html_entity_decode(strip_tags($data->competition_description)))) }}'
                                                        )">
                                                        Detail
                                                    </button>
                                                    @if(Auth::check())
                                                        <a href="#" class="btn btn-success" data-toggle="modal" data-target="#daftarPerlombaanModal">Daftar</a>
                                                    @else
                                                        <a href="#" class="btnTransaksi btn btn-success">Daftar</a>
                                                    @endif
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
                            <div class="tab-pane fade"
                                id="booth"
                                role="tabpanel"
                                aria-labelledby="booth-tab">

                                <div class="row">
                                    @forelse($detailBooth as $data)
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h4>{{ $data->booth_code }}</h4>
                                                </div>
                                                <div class="card-footer">
                                                    <a href="#" class="btn btn-primary btn-block">Daftar produk booth</a>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">Detail Perlombaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between">
                    <h3 id="competitionName" class="text-primary"></h3>
                    <h3 id="competitionFee" class="text-primary"></h3>
                </div>
                <div class="d-flex justify-content-between">
                    <h6>Sisa partisipan: <span id="participantQty">10</span> peserta</h6>
                    <div>
                        <h6>
                            <span id="competitionStartDate"></span> - <span id="competitionEndDate"></span>
                        </h6>
                    </div>
                </div>

                <p id="competitionDescription" class="text-justify mt-3"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Beli Tiket -->
<div class="modal fade" id="beliTiketModal" tabindex="-1" role="dialog" aria-labelledby="beliTiketModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('beli-tiket') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="beliTiketModalLabel">Pembelian Tiket</h5>
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
                                            <option value="{{ $currentDate->format('Y-m-d') }}">
                                                {{ $currentDate->format('d F Y') }}
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

<!-- Modal Daftar Perlombaan -->
<div class="modal fade" id="daftarPerlombaanModal" tabindex="-1" role="dialog" aria-labelledby="daftarPerlombaanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="beliTiketModalLabel">Pendaftaran Lomba</h5>
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
                        <td class="col-5"><b>Nama Perlombaan:</b></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">

            </div>
        </div>
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

    // Menampilkan modal detail perlombaan
    function showDetailsModal(
        competitionName, 
        competitionFee,
        participantQty,
        competitionStartDate,
        competitionEndDate,
        competitionDescription
    ) {
        $('#competitionName').text(competitionName);
        var competitionFeeFormatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 3, maximumFractionDigits: 3 }).format(competitionFee);
        $('#competitionFee').text(competitionFeeFormatted);
        $('#participantQty').text(participantQty);
        $('#competitionStartDate').text(competitionStartDate);
        $('#competitionEndDate').text(competitionEndDate);
        $('#competitionDescription').text(competitionDescription);
        $('#detailsModal').modal('show');

        if(
            competitionFee == 0
        ){
            $('#competitionFee').text('GRATIS');
        }
    }
</script>

<script>
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

@endpush