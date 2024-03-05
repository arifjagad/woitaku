@if (isset($detailBooth))
<div class="mt-4">
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-6">
            <h3 class="text-primary">KODE: {{ $detailBooth->booth_code }}</h3>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6">
            <h3 class="text-primary float-sm-right">IDR {{ number_format($detailBooth->rental_price, 0, ',', '.') }}</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-6">
        <h6>Ukuran: <span>{{ $detailBooth->booth_size }} m<sup>2</sup></span></h6>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6">
            <h6 class="float-sm-right">
                {{ \Carbon\Carbon::parse($detailBooth->start_date)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($detailBooth->end_date)->translatedFormat('d F Y') }}
            </h6>
        </div>
    </div>
    <h6 class="mt-5">Fasilitas:</h6>
    <p class="text-justify mt-2">
        {!! $detailBooth->provided_facilities !!}
    </p>

    <div class="d-flex justify-content-end">
        @if(Auth::check())
            @if(strtotime(\Carbon\Carbon::parse(now())->translatedFormat('Y-m-d')) < strtotime($detailBooth->start_date))
                <a href="#" id="btnPesanBoothModal" class="btn btn-success show-detail" data-rental-id="{{ $detailBooth->id }}" data-toggle="modal" data-target="#daftarRentalBoothModal">
                    Pesan Booth
                </a>
            @else
                <a href="#" class="btn btn-success show-detail" onclick="checkEventDateBooth()">Pesan Booth</a>
            @endif
        @else
            <a href="#" class="btnTransaksi btn btn-success">Pesan Booth</a>
        @endif
    </div>
</div>

<!-- Modal Pemesanan Booth -->
<div class="modal fade" id="daftarRentalBoothModal" tabindex="-1" role="dialog" aria-labelledby="daftarRentalBoothModalLabel" aria-hidden="true">
    <!-- Modal content -->
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- ... bagian lain dari modal ... -->
            <form action="{{ route('payment-booth') }}" method="POST">
                @csrf
                <input type="hidden" name="rentalBooth_id" value="{{ $detailBooth->id }}" />
                <div class="modal-header">
                    <h5 class="modal-title" id="daftarRentalBoothModalLabel">Pendaftaran Booth</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <td class="col-5"><b>Kode Booth:</b></td>
                            <td>{{ $detailBooth->booth_code }}</td>
                        </tr>
                        <tr>
                            <td class="col-5"><b>Biaya pendaftaran:</b></td>
                            <td>IDR {{ number_format($detailBooth->rental_price, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="col-5"><b>Metode Pembayaran:</b></td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control select2" name="payment_method">
                                        @foreach ($detailPaymentMethod as $method)
                                            <option value="{{ $method->id }}">{{ $method->bank_name }}</option>
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

@endif