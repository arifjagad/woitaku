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
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
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
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
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
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
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
                <div class="col-lg-8 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="far fa-solid fa-money-bill-transfer"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Pendapatan Tahun {{ date('Y') }}</h4>
                            </div>
                            <div class="card-body">
                                IDR {{ number_format($totalAmount, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="far fa-solid fa-ticket"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Tiket Terjual Tahun {{ date('Y') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalTransaction }} tiket
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
                            <h4>Grafik Perkembangan Pendapatan Untuk Setiap Bulan</h4>
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
                        
                        <div class="card-header d-flex justify-content-between">
                            <h4>Transaksi Terbaru</h4>
                            <a href="#" class="btn btn-primary">Lihat Semua</a>
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
                                            <th>Metode Pembayaran</th>
                                            <th>Bukti Pembayaran</th>
                                            <th>Action</th>
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
                                                <td>{{ $data->bank_name }}</td>
                                                <td>
                                                    @if ($data->proof_of_transaction)
                                                        <a href="{{ asset('storage/' . $data->proof_of_transaction) }}" target="_blank" class="btn btn-primary">Lihat</a>
                                                    @else
                                                        <span class="badge badge-danger">Belum Upload</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($data->transaction_status == 'pending')
                                                        <form action="{{ route('transaction.reject', $data->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-danger">Tolak</button>
                                                        </form>
                                                    @elseif ($data->transaction_status == 'check')
                                                        <form action="{{ route('transaction.accept', $data->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-success">Terima</button>
                                                        </form>
                                                    @endif
                                                </td>
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
        var totalAmoutGraph = {!! json_encode($totalAmoutGraph) !!};

        // Menyiapkan data untuk Chart.js
        var chartData = {
            labels: ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
            datasets: [
                {
                    label: 'Total Pendapatan Bulanan',
                    data: [0, ...totalAmoutGraph.map(entry => entry.total)],
                    backgroundColor: 'rgba(255, 0, 0, 0.2)',
                    borderColor: 'red',
                    borderWidth: 1
                },
                
            ]
        };

        // Membuat Vertical Bar Chart menggunakan Chart.js
        var ctx = document.getElementById('monthlyChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: chartData,
            options: {
                responsive: true,
                scales: {
                    x: {
                        type: 'category',
                        labels: chartData.labels
                    },
                    y: {
                        beginAtZero: true,
                    }
                }
            }
        });
    </script>
@endpush
