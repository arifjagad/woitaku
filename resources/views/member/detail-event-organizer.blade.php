@extends('layouts.app-member') 
@section('title', 'Profile Event Organizer')

@push('style')
<link rel="stylesheet"
        href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')

<div class="main-content" style="padding: 80px 0px;">
    <div class="container">
        <div class="row mt-sm-4">
            <div class="col-12">
                <div class="card profile-widget">
                    <div class="profile-widget-header">
                        @if($eventOrganizer->foto_profile == null)
                            <img
                                alt="image"
                                src="{{ asset('img/avatar/avatar-1.png') }}"
                                class="rounded-circle profile-widget-picture">
                        @else
                            <img alt="image"
                                src="{{ asset('storage/' . $eventOrganizer->foto_profile) }}"
                                class="rounded-circle profile-widget-picture">
                        @endif
                        <div class="profile-widget-items">
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-label">Tanggal Bergabung</div>
                                <div class="profile-widget-item-value">
                                    {{ Carbon\Carbon::parse($eventOrganizer->created_at)->translatedFormat('d F Y'); }}
                                </div>
                            </div>
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-label">Jumlah Event</div>
                                <div class="profile-widget-item-value">
                                    {{ $eventCount }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-widget-description">
                        <div class="profile-widget-name">{{ $eventOrganizer->name }} 
                            <div class="text-muted d-inline font-weight-normal">
                                <div class="slash"></div> Verified
                            </div>
                        </div>
                        {{ $eventOrganizer->description }}
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <form method="post"
                        class="needs-validation"
                        novalidate="">
                        <div class="card-header">
                            <h4>Daftar Event</h4>
                        </div>
                        <div class="card-body">
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
                                                            <span class="badge badge-secondary text-uppercase py-2 px-4" style="position: absolute; left: -155px;">
                                                                <span class="text-dark">Event Berakhir</span>
                                                            </span>
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
                    </form>
                </div>
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