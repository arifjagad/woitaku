@extends('layouts.app') @section('title', 'Competition')

@push('style')
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.css" rel="stylesheet">
@endpush

@section('main')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Competition</h1>
        </div>
        <h2 class="section-title">Explore the List of Competitions!</h2>
        <p class="section-lead">
            You can view all provided Competitions here.
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
                            <a href=" {{ route('create-payment-method') }} " class="btn btn-primary">Create New Competition</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                #
                                            </th>
                                            <th>Bank Name</th>
                                            <th>Account Number</th>
                                            <th>Account Holder Name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach($data as $data)
                                        <tr>
                                            <td class="text-center">
                                                @php for ($i=0; $i < 1; $i++) { echo $i+1; } @endphp
                                            </td>
                                            <td>{{ $data->bank_name }}</td>
                                            <td>{{ $data->account_number }}</td>
                                            <td>{{ $data->account_holder_name }}</td>
                                            <td>
                                                
                                            </td>
                                            <td>
                                                <a href="{{ route('edit-payment-method', $data->id) }}" class="btn btn-primary">Edit</a>
                                                <a href="{{ route('delete-payment-method', $data->id) }}" class="btn btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                        @endforeach --}}
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