@extends('layouts.app-member')
    
@section('title', 'Home')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
<div class="main-content" style="padding: 80px 0px 0px 0px; backgorund-color:white;">
    <div class="container h-100">
        <div class="row vh-100 d-flex align-items-center">
            <div class="col-lg-6">
                <h2 class="text-primary heading-hero-text">Bergabunglah dalam Keasyikan Jejepangan bersama Woitaku!</h2>
                <p class="subheading-hero-text">
                    Temukan Semua Event Jejepangan di Seluruh Indonesia dengan Mudah dan Seru!
                </p>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('img/static/hero-section-2.jpg')}}" class="rounded img-fluid"/>
            </div>
        </div>
    </div>
    <div class="container padding-main">
        <div class="row">
            <div class="col-12 text-center pb-5">
                <h3 class="text-primary">Manfaatkan Woitaku untuk Pengalaman Jejepangan Terbaik!</h3>
                <p>Nikmati Keuntungan Tak Terbatas Saat Bergabung Bersama Kami</p>
                <!-- Icon -->
                <div class="row mb-3">
                    <div class="col-md-6 col-lg-3">
                        <div class="product-item py-3 mx-4">
                            <div class="mb-3">
                                <i class="fas fa-solid fa-calendar-days bg-info p-4 rounded home-icon text-white"></i>
                            </div>
                            <div class="product-details">
                                <div class="product-name">Informasi Event Terupdate</div>
                                <div class="text-muted text-small">
                                    Dapatkan pembaruan terkini mengenai event jejepangan favorit Anda secara real-time.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="product-item py-3 mx-4">
                            <div class="mb-3">
                                <i class="fas fa-solid fa-note-sticky bg-info p-4 rounded home-icon text-white"></i>
                            </div>
                            <div class="product-details">
                                <div class="product-name">Informasi Lengkap untuk Event yang Ingin Diikuti</div>
                                <div class="text-muted text-small">
                                    Temukan semua informasi yang Anda butuhkan untuk merencanakan kehadiran Anda, mulai dari jadwal hingga lokasi.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="product-item py-3 mx-4">
                            <div class="mb-3">
                                <i class="fas fa-solid fa-building-ngo bg-info p-4 rounded home-icon text-white"></i>
                            </div>
                            <div class="product-details">
                                <div class="product-name">Kemudahan untuk EO dalam Mengelola Event</div>
                                <div class="text-muted text-small">
                                    Sediakan dan kelola event dengan mudah menggunakan fitur canggih dari Woitaku.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="product-item py-3 mx-4">
                            <div class="mb-3">
                                <i class="fas fa-solid fa-credit-card bg-info p-4 rounded home-icon text-white"></i>
                            </div>
                            <div class="product-details">
                                <div class="product-name">Transaksi Lebih Mudah</div>
                                <div class="text-muted text-small">
                                    Nikmati pengalaman bertransaksi yang lancar dan aman dengan sistem pembayaran yang mudah dipahami.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 py-5">
                <h3 class="text-primary text-center">Temukan Semua Event Jejepangan di Sini bersama Woitaku!</h3>
                <p class="text-center">Jelajahi keasyikan event jejepangan favoritmu. Temukan informasi lengkap, perbarui jadwal, dan nikmati kemudahan bertransaksi—semua dalam satu tempat, Woitaku!</p>
                <div class="row py-3">
                    @forelse ($dataEvent->take(3) as $data)
                        <div class="col-12 col-md-4 col-lg-4">
                            <article class="article article-style-c d-flex flex-column h-100">
                                <div class="article-header">
                                    <div class="article-image" data-background="{{ asset('storage/' . $data->featured_image) }}">
                                    </div>
                                    <div class="article-badge">
                                        <div class="article-badge-item bg-success text-uppercase">
                                            @if ($data->ticket_price == 0)
                                                GRATIS
                                            @else
                                                BERBAYAR
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="article-details flex-grow-1 d-flex flex-column align-items-start">
                                    <div class="article-category">
                                        <a>{{ $data->city }}</a>
                                        <br>
                                        <a>Date</a>
                                        <div class="bullet"></div> 
                                        <a>
                                            {{ \Carbon\Carbon::parse($data->start_date)->format('l, d F Y') }}
                                        </a>
                                    </div>
                                    <div class="article-title">
                                        <h2>
                                            <a href="{{ route('detail-event', ['id' => $data->id]) }}">{{ $data->event_name }}</a>
                                        </h2>
                                    </div>
                                    <p class="text-justify">
                                        {!! \Illuminate\Support\Str::limit(strip_tags($data->event_description), 100) !!}
                                    </p>
                                    <div class="article-user mt-auto">
                                        <img alt="image"
                                            src="{{ asset('storage/' . $data->foto_profile) }}">
                                        <div class="article-user-details">
                                            <div class="user-detail-name">
                                                <a href="{{ route('detail-event', ['id' => $data->id]) }}">{{ $data->name }}</a>
                                            </div>
                                            <div class="text-job">Verified</div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-danger text-center">
                                <h4 class="alert-heading">Tidak ada event yang tersedia</h4>
                                <p class="mb-0">Tidak ada event yang tersedia saat ini. Silahkan coba lagi nanti.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="text-center">
                    <a href="{{ route('list-event') }}" target="_blank" class="btn btn-primary">Lihat semua event</a>
                </div>
            </div>
        </div>
    </div>
    <div class="hero align-items-center bg-primary text-white text-center">
        <div class="container">
            <div class="hero-inner">
                <h2>Daftar Sekarang dan Rasakan Semua Fitur Menariknya!</h2>
                <p class="lead">Bergabunglah sekarang dengan Woitaku untuk mengeksplorasi dunia event jejepangan. Dapatkan akses eksklusif ke informasi terupdate, penuh fitur, dan nikmati kemudahan pengalaman tanpa batas!</p>
                <div class="mt-4">
                    @auth
                        <a href="{{ route('profile') }}"
                        class="btn btn-outline-white btn-lg btn-icon icon-left"><i class="far fa-user"></i>
                        Atur Akun</a>
                    @else
                        <a href="{{ route('register') }}"
                        class="btn btn-outline-white btn-lg btn-icon icon-left"><i class="far fa-user"></i>
                        Buat Akun</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="container padding-main">
        <div class="row py-4">
            <div class="col-12 text-center pb-5">
                <h3 class="text-primary">Temukan Berita Terkini Seputar Jejepangan Hanya di Woitaku!</h3>
                <p>Dapatkan berita terbaru dan terpanas tentang dunia jejepangan. Jelajahi artikel menarik, ulasan, dan informasi eksklusif lainnya, semua dalam satu tempat yang nyaman, Woitaku!</p>

            </div>
        </div>
    </div> --}}
</div>
@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
