@extends('layouts.app') @section('title', 'Payment Method')

@push('style')
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.css" rel="stylesheet">
@endpush

@section('main')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Metode Pembayaran</h1>
        </div>
        <h2 class="section-title">Daftar Semua Metode Pembayaran</h2>
        <p class="section-lead">
            Anda dapat melihat semua metode pembayaran yang dibuat di sini.
        </p>
        <div class="section-body">
            <div class="card">
                {{-- <div class="card-header">
                        <h4>Example Card</h4>
                    </div> --}}
                <div class="card-body">
                    <form class="needs-validation" novalidate="" method="POST">
                        @csrf
                        <div class="card-footer text-right">
                            <a href=" {{ route('create-payment-method') }} " class="btn btn-primary">Tambah Metode Pembayaran</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                #
                                            </th>
                                            <th>Nama Bank</th>
                                            <th>Nomor Rekening</th>
                                            <th>Nama Pemilik Kartu</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $data)
                                        <tr>
                                            <td class="text-center">
                                                {{ $loop->index + 1 }}
                                            </td>
                                            <td>{{ $data->bank_name }}</td>
                                            <td>{{ $data->account_number }}</td>
                                            <td>{{ $data->account_holder_name }}</td>
                                            <td>
                                                
                                                <div class="custom-control custom-switch">
                                                    <input 
                                                        data-id="{{$data->id}}"
                                                        class="custom-control-input toggle-class"
                                                        type="checkbox"
                                                        data-onstyle="success"
                                                        data-offstyle="danger"
                                                        data-toggle="toggle"
                                                        data-on="Active"
                                                        data-off="InActive"
                                                        {{ $data->status ? 'checked' : '' }}
                                                        id="customSwitch{{ $data->id }}"
                                                    >
                                                    <label 
                                                        class="custom-control-label" 
                                                        for="customSwitch{{ $data->id }}"
                                                        id="statusLabel{{ $data->id }}">
                                                        @if($data->status == 1)
                                                            Active
                                                        @else
                                                            Inactive
                                                        @endif
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('edit-payment-method', $data->id) }}" class="btn btn-primary">Edit</a>
                                                <a href="{{ route('delete-payment-method', $data->id) }}" class="btn btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
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
<script src="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.js"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('js/page/modules-datatables.js') }}"></script>

<script>
    $(function () {
    $('.toggle-class').change(function () {
        var status = $(this).prop('checked') == true
            ? 1
            : 0;
        var id = $(this).data('id');

        var label = $('#statusLabel' + id);
        label.text(status ? 'Active' : 'Inactive');

        console.log(status);
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/updateStatusPaymentMethodEO',
            data: {
                'status': status,
                'id': id
            },
            success: function (data) {
                console.log(data.success)
            }
        });
    })
})
</script>

@endpush