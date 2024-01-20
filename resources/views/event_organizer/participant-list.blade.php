@extends('layouts.app')

@section('title', 'Peserta Event')

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
            <h1>Daftar Peserta Event</h1>
        </div>

        <div class="section-body">
            <!-- Count -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Daftar Peserta Event</h4>
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
                                            <th>#</th>
                                            <th>Id Tiket</th>
                                            <th>Nama Event</th>
                                            <th>Nama Member</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Kategori Transaksi</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($dataTicket))
                                            @foreach ($dataTicket as $data)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>{{ $data->ticket_identifier }}</td>
                                                    <td>{{ $data->event_name }}</td>
                                                    <td>{{ $data->name }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($data->updated_at)->translatedFormat('d F Y') }}</td>
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
                                                        @if ($data->status == 'unused')
                                                            <span class="badge badge-danger">Belum digunakan</span>
                                                        @elseif ($data->status == 'success')
                                                            <span class="badge badge-success">Sudah digunakan</span>
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
                        exportOptions: {
                            columns: ':not(:last-child)',
                        }
                    }, {
                        extend: 'csv',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: ':not(:last-child)',
                        }
                    }, {
                        extend: 'excel',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: ':not(:last-child)',
                        }
                    }
                ],
                initComplete: function () {
                    $('.btn-primary').removeClass('dt-button');
                }
            });
        });
    </script>
@endpush
