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
                                            
                                        @else
                                            <a href="#" class="btn btn-success btn-lg btn-block text-uppercase mt-3 mb-4 py-3" style="font-size: 16px;">Beli Tiket</a>
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
                                    @foreach($detailCompetition as $data)
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h4>{{ $data->competition_name }}</h4>
                                            </div>
                                            <div class="card-body">
                                                {!! \Illuminate\Support\Str::limit(strip_tags($data->competition_description), 50) !!}
                                            </div>
                                            <div class="card-footer">
                                                <a href="#" class="btn btn-primary">Detail</a>
                                                <a href="#" class="btn btn-success">Daftar</a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
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
                                        <p>No data available</p>
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
@endsection @push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>

<!-- Custom JS -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var passwordInput = document.getElementById('password');
        var passwordConfirmationInput = document.getElementById('password_confirmation');
        var initialPasswordValue = passwordInput.value;

        passwordInput.addEventListener('input', function () {
            if (passwordInput.value !== initialPasswordValue) {
                // Jika kata sandi utama berubah, atur kembali nilai konfirmasi kata sandi
                passwordConfirmationInput.value = initialPasswordValue;
            }
        });

        passwordConfirmationInput.addEventListener('input', function () {
            if (passwordInput.value !== passwordConfirmationInput.value) {
                passwordConfirmationInput.setCustomValidity("Passwords do not match");
            } else {
                passwordConfirmationInput.setCustomValidity('');
            }
        });
    });
</script>
@endpush