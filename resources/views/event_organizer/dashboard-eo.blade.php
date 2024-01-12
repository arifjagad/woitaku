@extends('layouts.app')

@section('title', 'Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.css" rel="stylesheet">

@endpush

@section('main')
<div class="main-content">
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
                            <i class="far fa-solid fa-calendar-day"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Jumlah Event</h4>
                            </div>
                            <div class="card-body">
                                {{$eventsCount}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="far fa-solid fa-ranking-star"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Jumlah Perlombaan</h4>
                            </div>
                            <div class="card-body">
                                {{$competitionCount}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="far fa-solid fa-building"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Jumlah Booth</h4>
                            </div>
                            <div class="card-body">
                                {{$boothCount}}
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
                                <h4>Total Pendapatan</h4>
                            </div>
                            <div class="card-body">
                                IDR {{ number_format($totalAmount, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Graph -->
            <div class="row align-items-stretch">
                <div class="col-9">
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
                <div class="col-3">
                    <div class="card gradient-bottom">
                        <div class="card-header">
                            <h4>5 Event Terpopuler - </h4>
                            <h4>{{ now()->translatedFormat('F') }}</h4>
                        </div>
                        <div class="card-body"
                            id="top-5-scroll">
                            @forelse ($eventPopular as $key => $data)
                                <ul class="list-unstyled list-unstyled-border">
                                    <li class="media">
                                        <img class="mr-3 rounded"
                                            width="55"
                                            src="{{ asset('storage/' . $data->featured_image) }}"
                                            alt="product">
                                        <div class="media-body">
                                            <div class="media-title">
                                                {{ $data->event_name }}
                                            </div>
                                            <div class="mt-1">
                                                <div class="budget-price">
                                                    <div class="budget-price-square bg-primary"
                                                        data-width="{{ 60 - ($key + 1) * 10 }}%"></div>
                                                    <div class="budget-price-label">
                                                        {{ $data->transaction_count }} tiket
                                                    </div>
                                                </div>
                                                <div class="budget-price">
                                                    <div class="budget-price-square bg-danger"
                                                        data-width="{{ 60 - ($key + 1) * 10 }}%"></div>
                                                    <div class="budget-price-label">
                                                        IDR {{ number_format($data->total_transaction_amount, 0, ',', '.') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            @empty
                                <p>Data tidak ditemukan.</p>
                            @endforelse
                        </div>
                        <div class="card-footer d-flex justify-content-center pt-3">
                            <div class="budget-price justify-content-center">
                                <div class="budget-price-square bg-primary"
                                    data-width="20"></div>
                                <div class="budget-price-label">Jumlah Tiket</div>
                            </div>
                            <div class="budget-price justify-content-center">
                                <div class="budget-price-square bg-danger"
                                    data-width="20"></div>
                                <div class="budget-price-label">Pendapatan</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Transaksi Terbaru</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama Event</th>
                                            <th>Nama Pemesan</th>
                                            <th>Tanggal Pemesanan</th>
                                            <th>Status</th>
                                            <th>Total Pembayaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($transaction as $data)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>{{ $data->event_name }}</td>
                                                <td>{{ $data->name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y') }}</td>
                                                <td>
                                                    @if ($data->transaction_status == 'pending')
                                                        <span class="badge badge-warning">Pending</span>
                                                    @elseif ($data->transaction_status == 'success')
                                                        <span class="badge badge-success">Success</span>
                                                    @elseif ($data->transaction_status == 'failed')
                                                        <span class="badge badge-danger">Failed</span>
                                                    @endif
                                                </td>
                                                <td>IDR {{ number_format($data->transaction_amout, 0, ',', '.') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Tidak ada data.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
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
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.js"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/dashboard-chart.js') }}"></script>
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>

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
