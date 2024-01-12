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
                                    <h4>Administrator</h4>
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
                                    <h4>Event</h4>
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
                                    <h4>Member</h4>
                                </div>
                                <div class="card-body">
                                    {{$membersCount}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Perkembangan Jumlah Pengguna (Member & Event Organizer)</h4>
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
                                        <div class="detail-name">Total User Baru Hari Ini</div>
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
                                        <div class="detail-name">Total User Baru Minggu Ini</div>
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
                                        <div class="detail-name">Total User Baru Bulan Ini</div>
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
                                        <div class="detail-name">Total User Baru Tahun Ini</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Graph -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Grafik Perkembangan Jumlah Event, Perlombaan, dan Booth Setiap Bulannya</h4>
                            </div>
                            <div class="card-body">
                                <!-- Data Perkembangan Bulanan Untuk Setiap Kategori -->
                                <canvas id="monthlyChart"></canvas>
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

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/dashboard-chart.js') }}"></script>

    <script>
        // Mengambil data dari controller
        var detailEventData = {!! json_encode($detailEventData) !!};
        var detailCompetitionData = {!! json_encode($detailCompetitionData) !!};
        var boothRentalData = {!! json_encode($boothRentalData) !!};

        // Menyiapkan data untuk Chart.js
        var chartData = {
            labels: ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
            datasets: [
                {
                    label: 'Jumlah Event',
                    data: [0, ...detailEventData.map(entry => entry.count)],
                    backgroundColor: 'rgba(255, 0, 0, 0.2)',
                    borderColor: 'red',
                    borderWidth: 1
                },
                {
                    label: 'Jumlah Perlombaan',
                    data: [0, ...detailCompetitionData.map(entry => entry.count)],
                    backgroundColor: 'rgba(0, 0, 255, 0.2)',
                    borderColor: 'blue',
                    borderWidth: 1
                },
                {
                    label: 'Jumlah Booth',
                    data: [0, ...boothRentalData.map(entry => entry.count)],
                    backgroundColor: 'rgba(0, 255, 0, 0.2)',
                    borderColor: 'green',
                    borderWidth: 1
                }
            ]
        };

        // Membuat Vertical Bar Chart menggunakan Chart.js
        var ctx = document.getElementById('monthlyChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: chartData,
            options: {
                responsive: true,
                scales: {
                    x: {
                        type: 'category',
                        labels: chartData.labels
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

@endpush
