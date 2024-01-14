@extends('layouts.app')

@section('title', 'Event')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar Event</h1>
        </div>
        <h2 class="section-title">Daftar Semua Event</h2>
        <p class="section-lead">
            Anda dapat melihat semua event yang dibuat di sini.
        </p>
        <div class="section-body">
            <!-- Pengecekan apakah ada data event atau tidak -->
            @if(count($data) > 0)
            <div class="card">
                <div class="card-footer text-right">
                    <a href="{{ route('create-event-eo') }}" class="btn btn-primary">Tambah Event</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('event-eo') }}" method="GET" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama event...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        @foreach ($data as $data)
                            <div class="col-12 col-md-4 col-lg-4">
                                <article class="article article-style-c h-100">
                                    <div class="article-header">
                                        <div class="article-image" data-background="{{ asset('storage/' . $data->featured_image) }}">
                                        </div>
                                        <div class="article-badge">
                                            @if ($data->verification == 'accepted')
                                                <div class="article-badge-item bg-success text-uppercase">{{ $data->verification }}</div>
                                            @elseif ($data->verification == 'revision')
                                                <div class="article-badge-item bg-info text-uppercase">{{ $data->verification }}</div>
                                            @elseif ($data->verification == 'pending')
                                                <div class="article-badge-item bg-warning text-uppercase">{{ $data->verification }}</div>
                                            @else
                                                <div class="article-badge-item bg-danger text-uppercase">{{ $data->verification }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="article-details">
                                        <div class="article-category">
                                            {{Carbon\Carbon::parse($data->start_date)->translatedFormat('d F Y')}} - {{Carbon\Carbon::parse($data->end_date)->translatedFormat('d F Y')}}
                                        </div>
                                        <div class="article-title">
                                            <h1>
                                                <a href="#">
                                                    {{ Str::limit($data->event_name, $limit = 50, $end = '...') }}
                                                </a>
                                            </h1>
                                        </div>
                                        <p class="text-justify">
                                            {!! \Illuminate\Support\Str::limit(strip_tags($data->event_description), 100) !!}
                                        </p>
                                        <div class="article-user">
                                            <a href="{{ route('edit-event-eo', ['id' => $data->id]) }}" class="btn btn-icon icon-left btn-primary">
                                                EDIT
                                            </a>
                                            <a href="{{ route('delete-event-eo', ['id' => $data->id]) }}" class="btn btn-icon icon-left btn-danger">
                                                DELETE
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Jika data event tidak ada tampilkan ini -->
            @else
                <div class="card col-12">
                    <div class="card-body">
                        <div class="empty-state"
                            data-height="400">
                            <div class="empty-state-icon">
                                <i class="fas fa-question"></i>
                            </div>
                            <h2>
                                Kami tidak dapat menemukan data apapun.
                            </h2>
                            <p class="lead">
                                Maaf, kami tidak dapat menemukan event apapun. Untuk menghilangkan pesan ini, harap buat setidaknya satu event.
                            </p>
                            <a href="{{ route('create-event-eo') }}"
                                class="btn btn-primary mt-4">Tambah Event</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
@endpush
