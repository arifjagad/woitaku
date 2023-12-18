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
        <div class="row">
            <div class="col-md-6">
                
            </div>
        </div>
        <div class="section-body">
            <!-- Pengecekan apakah ada data event atau tidak -->
            @if(count($data) > 0)
            <div class="card">
                <div class="card-header">
                    <h4>All Events You Have</h4>
                    <div class="card-header-action">
                        <a href="{{ route('create-event-eo') }}" class="btn btn-primary">Create New Event</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('event-eo') }}" method="GET" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search events...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        @foreach ($data as $data)
                            <div class="col-12 col-md-4 col-lg-4">
                                <article class="article article-style-c">
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
