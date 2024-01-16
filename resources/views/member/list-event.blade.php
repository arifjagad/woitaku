@extends('layouts.app-member') 
@section('title', 'List Event')

@push('style')
<link rel="stylesheet"
        href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')

<div class="main-content" style="padding: 80px 0px;">
    <div class="container">
        <div class="row my-5">
            <div class="col-3">
                <h4 class="text-primary">Filter</h4>
                <form action="{{ route('filter-event') }}" method="GET">
                    <div class="form-group">
                        <label for="price-range">Jenis Event</label>
                        <select class="form-control" id="price-range" name="price_range">
                            <option value="">Semua</option>
                            <option value="free">Gratis</option>
                            <option value="paid">Berbayar</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kota Event</label>
                        <select class="form-control select2" id="city" name="city">
                            <option value="">Pilih Kota</option>
                            @foreach ($dataEventCity as $data)
                                <option value="{{ $data->city }}">{{ $data->city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('list-event') }}" class="btn btn-primary btn-block">Reset</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary btn-block">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-9">
                <form action="{{ route('search-event') }}" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama event...">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                    </div>
                </form>
                <div class="row">
                    @forelse($dataEvent as $data)
                        <div class="col-4 h-100">
                            <article class="article article-style-c">
                                <div class="article-header">
                                    <div class="article-image" data-background="{{ asset('storage/' . $data->featured_image) }}">
                                    </div>
                                    <div class="article-badge">
                                        <div class="d-flex">
                                            @if(\Carbon\Carbon::parse($data->end_date)->addDay()->isPast())
                                            <div class="article-badge-item bg-secondary text-uppercase">
                                                    <span class="text-dark">Event Berakhir</span>
                                                </div>
                                            @endif
                                            <div class="ml-2 article-badge-item bg-success text-uppercase">
                                                @if ($data->ticket_price == 0)
                                                    GRATIS
                                                @else
                                                    BERBAYAR
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="article-details">
                                    <div class="article-category">
                                        <a>{{$data->city}}</a><br>
                                        <a>
                                            {{ \Carbon\Carbon::parse($data->start_date)->translatedFormat('l, d F Y') }}
                                        </a>
                                    </div>
                                    <div class="article-title">
                                        <h2>
                                            <a href="{{ route('detail-event', ['eventName' => Str::slug($data->event_name)]) }}">{{ $data->event_name }}</a>
                                        </h2>
                                    </div>
                                    <div class="article-user">
                                        @if($data->foto_profile == null)
                                            <img
                                                alt="image"
                                                src="{{ asset('img/avatar/avatar-1.png') }}">
                                        @else
                                            <img alt="image"
                                                src="{{ asset('storage/' . $data->foto_profile) }}">
                                        @endif
                                        <div class="article-user-details">
                                            <div class="user-detail-name">
                                                <a href="{{ route('detail-event-organizer', ['eoName' => Str::slug($data->name)]) }}">{{ $data->name }}</a>
                                            </div>
                                            <div class="text-job">Verified</div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="col-12">
                            Data tidak ada
                        </div>
                    @endforelse
                </div>
                <!-- Pagination -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item">
                            <span class="sr-only">Previous</span>
                        </li>
                        {{ $dataEvent->onEachSide(1)->links('pagination::bootstrap-4') }}
                        <li class="page-item">
                            <span class="sr-only">Next</span>
                        </li>
                    </ul>
                </nav>

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
@endpush