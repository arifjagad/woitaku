@extends('layouts.app') @section('title', 'Booth')

@push('style')
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.css" rel="stylesheet">
@endpush

@section('main')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar Booth</h1>
        </div>
        <h2 class="section-title">Daftar Semua Booth!</h2>
        <p class="section-lead">
            Anda dapat melihat semua booth yang dibuat di sini.
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
                            <a href=" {{ route('create-booth-eo') }} " class="btn btn-primary">Tambah Booth</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                #
                                            </th>
                                            <th>Nama Booth</th>
                                            <th>Nama Event</th>
                                            <th>Harga Sewa</th>
                                            <th>Status Booth</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $id = 1; @endphp
                                        @foreach($dataBooth as $data)
                                        <tr>
                                            <td class="text-center">
                                                {{ $id++ }}
                                            </td>
                                            <td>{{ $data->booth_code }}</td>
                                            <td>{{ $data->event_name }}</td>
                                            <td>
                                                {{$data->rental_price}}
                                            </td>
                                            <td>
                                                {{$data->availability_status}}
                                            </td>
                                            <td>
                                                <a href="{{ route('edit-booth-eo', $data->id) }}" class="btn btn-primary">Edit</a>
                                                <a href="{{ route('delete-booth-eo', $data->id) }}" class="btn btn-danger">Delete</a>
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

@endpush