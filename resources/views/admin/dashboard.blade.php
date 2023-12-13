@extends('layouts.app')

@section('title', 'Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>

            <div class="section-body">
                <!-- Count -->
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="far fa-solid fa-user-tie"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Administrators</h4>
                                </div>
                                <div class="card-body">
                                    {{$adminCount}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning">
                                <i class="far fa-solid fa-building-user"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Event Organizer</h4>
                                </div>
                                <div class="card-body">
                                    {{$eventOrganizerCount}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-danger">
                                <i class="far fa-solid fa-calendar-day"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Events</h4>
                                </div>
                                <div class="card-body">
                                    {{$eventsCount}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="far fa-solid fa-users"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Members</h4>
                                </div>
                                <div class="card-body">
                                    {{$membersCount}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Graph -->
                <div class="row">
                    <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Monthly Transaction</h4>
                            </div>
                            <div class="card-body">
                                <!-- Montly Transaction -->
                                <canvas id="montly-transaction" height="182"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Recent Transaction</h4>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled list-unstyled-border">
                                    @foreach($latestTransactions as $data)
                                    <li class="media">
                                        <img class="rounded-circle mr-3"
                                            width="50"
                                            src="{{ asset('img/avatar/avatar-1.png') }}"
                                            alt="avatar">
                                        <div class="media-body">
                                            <div class="text-primary float-right">
                                                @if ($data->payment_status == 'paid')
                                                    <span class="text-success">Paid</span>
                                                @elseif ($data->payment_status == 'unpaid')
                                                    <span class="text-danger">Unpaid</span>
                                                @elseif ($data->payment_status == 'cancelled')
                                                    <span class="text-danger">Cancelled</span>
                                                @elseif ($data->payment_status == 'expired')
                                                    <span class="text-danger">Expired</span>
                                                @endif
                                            </div>
                                            <div class="media-title">{{$data->name}}</div>
                                            <span>
                                                {{$data->event_name}} 
                                            </span>
                                            <br>
                                            <span class="text-small">
                                                @if ($data->id_category == 1)
                                                    Event Ticket
                                                @elseif ($data->id_category == 2)
                                                    Competition Registration
                                                @elseif ($data->id_category == 3)
                                                    Booth Rental
                                                @endif
                                            </span>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                                <div class="pt-1 pb-1 text-center">
                                    <a href="{{ route('transaction') }}" target="_blank"
                                        class="btn btn-primary btn-lg btn-round">
                                        View All
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>User (Member and Event Organizer) Growth</h4>
                            </div>
                            <div class="card-body">
                                <div class="statistic-details mt-sm-4">
                                    <div class="statistic-details-item">
                                        
                                        <div class="detail-value">{{$usersTodayCount}}
                                            <span class="text-muted">
                                                @if($usersTodayCount == $usersYesterdayCount)
                                                    
                                                @elseif ($usersTodayCount < $usersYesterdayCount) 
                                                    <span class="text-danger"><i class="fas fa-caret-down"></i></span>
                                                @else 
                                                    <span class="text-primary"><i class="fas fa-caret-up"></i></span>
                                                @endif
                                            </span></div>
                                        <div class="detail-name">Today's New Users</div>
                                    </div>
                                    <div class="statistic-details-item">
                                        <div class="detail-value">
                                            {{$usersThisWeekCount}}

                                            @if($usersThisWeekCount == $usersLastWeekCount)
                                                    
                                            @elseif ($usersThisWeekCount < $usersYesterdayCount) 
                                                <span class="text-danger"><i class="fas fa-caret-down"></i></span>
                                            @else 
                                                <span class="text-primary"><i class="fas fa-caret-up"></i></span>
                                            @endif
                                        </div>
                                        <div class="detail-name">This Week's Users</div>
                                    </div>
                                    <div class="statistic-details-item">
                                        <div class="detail-value">
                                            {{$usersThisMonthCount}}
                                        
                                            @if($usersThisMonthCount == $usersLastMonthCount)
                                                    
                                            @elseif ($usersThisMonthCount < $usersYesterdayCount) 
                                                <span class="text-danger"><i class="fas fa-caret-down"></i></span>
                                            @else 
                                                <span class="text-primary"><i class="fas fa-caret-up"></i></span>
                                            @endif
                                        </div>
                                        <div class="detail-name">This Month's Users</div>
                                    </div>
                                    <div class="statistic-details-item">
                                        <div class="detail-value">
                                            {{$usersThisYearCount}}
                                        
                                            @if($usersThisYearCount == $usersLastYearCount)
                                                    
                                            @elseif ($usersThisYearCount < $usersYesterdayCount) 
                                                <span class="text-danger"><i class="fas fa-caret-down"></i></span>
                                            @else 
                                                <span class="text-primary"><i class="fas fa-caret-up"></i></span>
                                            @endif
                                        </div>
                                        <div class="detail-name">This Year's Users</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/dashboard-chart.js') }}"></script>

    <script>
        var monthlyData = @json($monthlyData);

        var script = document.createElement('script');
        script.src = '{{ asset('js/dashboard-chart.js') }}';
        document.head.appendChild(script);
    </script>

@endpush
