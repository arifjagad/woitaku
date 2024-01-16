@extends('layouts.app')

@section('title', 'List Transaction')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.8/sc-2.3.0/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar Transaksi Event</h1>
        </div>

        <div class="section-body">
            <!-- Count -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Daftar Transaksi</h4>
                        </div>
                        <div class="card-body">
                            <form id="your-form-id">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="form-group col-lg-12">
                                            <label>Nama Event</label>
                                            <div 
                                                class="float-right"
                                                data-toggle="tooltip"
                                                title="Pilih nama event yang ingin kamu tampilkan datanya">
                                                <label>
                                                    <i class="fa-solid fa-circle-info"></i> Informasi
                                                </label>
                                            </div>
                                            <select class="form-control select2" id="event_id" name="event_id">
                                                <option value="">-- Pilih Event --</option>
                                                @foreach($dataEvent as $data)
                                                    <option value="{{$data->id}}">{{ $data->event_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            
                            <div class="table-responsive">
                                <table class="table-striped table display nowrap" id="list-transaction">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama Event</th>
                                            <th>Nama Pemesan</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Kategori Transaksi</th>
                                            <th>Status</th>
                                            <th>Total Pembayaran</th>
                                            <th>Metode Pembayaran</th>
                                            <th>Bukti Pembayaran</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($dataTransaction))
                                            @foreach ($dataTransaction as $data)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>{{ $data->event_name }}</td>
                                                    <td>{{ $data->name }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y') }}</td>
                                                    <td>
                                                        @if ($data->id_category == '1')
                                                            <span class="badge badge-primary">Tiket Event</span>
                                                        @elseif ($data->id_category == '2')
                                                            <span class="badge badge-primary">Pendaftaran Perlombaan</span>
                                                        @elseif ($data->id_category == '3')
                                                            <span class="badge badge-primary">Penyewaan Booth</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($data->transaction_status == 'pending')
                                                            <span class="badge badge-warning">Pending</span>
                                                        @elseif ($data->transaction_status == 'success')
                                                            <span class="badge badge-success">Berhasil</span>
                                                        @elseif ($data->transaction_status == 'failed')
                                                            <span class="badge badge-danger">Gagal</span>
                                                        @elseif ($data->transaction_status == 'check')
                                                            <span class="badge badge-info">Sedang dicek</span>
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
                                                    <td class="d-flex justify-content-end">
                                                        @if ($data->transaction_status == 'pending')
                                                            <form action="{{ route('transaction.reject', $data->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn btn-danger">Tolak</button>
                                                            </form>
                                                        @elseif ($data->transaction_status == 'check')
                                                            <form action="{{ route('transaction.accept', $data->id) }}" method="POST" class="mr-2">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn btn-success">Terima</button>
                                                            </form>
                                                            <form action="{{ route('transaction.reject', $data->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn btn-danger">Tolak</button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
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
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.js"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>

    <!-- JSZip -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <!-- DataTables Buttons HTML5 -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

    <!-- DataTables Buttons Print -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <!-- Custom JS -->
    <script>
        $(document).ready(function () {
            // Mendengarkan perubahan pada dropdown event
            $('#event_id').on('change', function () {
                // Mengirimkan formulir ketika event dipilih
                $('#your-form-id').submit();
            });
        });

        $(document).ready(function () {
            $('#list-transaction').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        className: 'btn btn-primary',
                        /* exportOptions: {
                            columns: ':not(:last-child)',
                        } */
                    }, {
                        extend: 'csv',
                        className: 'btn btn-primary',
                    }, {
                        extend: 'excel',
                        className: 'btn btn-primary',
                    }
                ],
                initComplete: function () {
                    $('.btn-primary').removeClass('dt-button');
                }
            });
        });
    </script>
@endpush
