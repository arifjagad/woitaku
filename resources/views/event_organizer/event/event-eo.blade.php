@extends('layouts.app')

@section('title', 'Event')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Your Event</h1>
        </div>
        <div class="section-body">
            <!-- Pengecekan apakah ada data event atau tidak -->
            @if(count($data) > 3)
            <div class="card">
                <div class="card-header">
                    <h4>Example Card</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-4 col-lg-4">
                            @foreach ($data as $data)
                                <article class="article article-style-c">
                                    <div class="article-header">
                                        <div class="article-image"
                                            data-background="{{ asset('img/news/img13.jpg') }}">
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
                                            {{$data->start_date}} s/d {{$data->end_date}}
                                        </div>
                                        <div class="article-title">
                                            <h1>
                                                <a href="#">
                                                    {{ Str::limit($data->event_name, $limit = 50, $end = '...') }}
                                                </a>
                                            </h1>
                                        </div>
                                        <p class="text-justify">
                                            {{ Str::limit($data->event_description, $limit = 100, $end = '...') }}
                                        </p>
                                        <div class="article-user">
                                            <a href="#" class="btn btn-icon icon-left btn-primary">
                                                EDIT
                                            </a>
                                            <a href="#" class="btn btn-icon icon-left btn-danger">
                                                DELETE
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-whitesmoke">
                    123
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
                            <h2>We couldn't find any data</h2>
                            <p class="lead">
                                Sorry, we couldn't find any events. To remove this message, please create at least one entry.
                            </p>
                            <a href="{{ route('create-event-eo') }}"
                                class="btn btn-primary mt-4">Create new event</a>
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
