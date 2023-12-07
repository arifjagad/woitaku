@extends('layouts.app')

@section('title', 'Transaction')

@push('style')
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.8/sc-2.3.0/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('main')


<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Transaction</h1>
        </div>
        <h2 class="section-title">View All Existing Transaction Data!</h2>
        <p class="section-lead">
            You can view all Transaction here.
        </p>
        <div class="section-body">
            <div class="card">
                {{-- <div class="card-header">
                        <h4>Example Card</h4>
                    </div> --}}
                <div class="card-body">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table-striped table" id="list-transaction">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            #
                                        </th>
                                        <th>Member Name</th>
                                        <th>Event Name</th>
                                        <th>Transaction Type</th>
                                        <th>Transaction Amout</th>
                                        <th>Payment Method</th>
                                        <th>Payment Status</th>
                                        <th>Invoice</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $id = 1; @endphp
                                    @foreach ($datas as $data)
                                        <tr>
                                            <td class="text-center">{{ $id++ }}</td>
                                            <td>{{$data->name}}</td>
                                            <td>{{$data->event_name}}</td>
                                            <td>
                                                @if ($data->id_category == 1)
                                                    <span class="badge badge-info">Event Ticket</span>
                                                @elseif ($data->id_category == 2)
                                                    <span class="badge badge-info">Competition Registration</span>
                                                @elseif ($data->id_category == 3)
                                                    <span class="badge badge-info">Booth Rental</span>
                                                @endif
                                            </td>
                                            <td>IDR {{ number_format($data->transaction_amout, 0, ',', '.') }}</td>
                                            <td>{{$data->payment_method}}</td>
                                            <td>
                                                @if ($data->payment_status == 'paid')
                                                    <span class="badge badge-success">Paid</span>
                                                @elseif ($data->payment_status == 'unpaid')
                                                    <span class="badge badge-danger">Unpaid</span>
                                                @elseif ($data->payment_status == 'cancelled')
                                                    <span class="badge badge-danger">Cancelled</span>
                                                @elseif ($data->payment_status == 'expired')
                                                    <span class="badge badge-danger">Expired</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-primary">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- <div class="card-footer bg-whitesmoke">
                    This is card footer
                </div> --}}
            </div>
        </div>
    </section>
</div>

@endsection @push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
<script src="https://cdn.datatables.net/v/bs5/dt-1.13.8/sc-2.3.0/datatables.min.js"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('js/page/modules-datatables.js') }}"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>

<!-- JSZip -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<!-- DataTables Buttons HTML5 -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

<!-- DataTables Buttons Print -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
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
