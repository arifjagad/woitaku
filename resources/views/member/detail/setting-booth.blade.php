@extends('layouts.app-member') 
@section('title', 'Profile')

@push('style')
<link rel="stylesheet"
        href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')

<div class="main-content " style="padding: 80px 0px;">
    <div class="container">
        <section class="section">
            <h2 class="section-title">Hi, {{auth()->user()->name}}!</h2>
            <p class="section-lead">
                You can adjust all general settings here.
            </p>
            <div class="section-body">
                <div class="row">
                    <!-- Panggil Components Sidebar-Profile.blade.php -->
                    @include('components.sidebar-profile')
                    <div class="col-12 col-md-6 col-lg-9">
                        <div class="card">
                            <div class="card-header">
                                <h4>Pengaturan Booth</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    #
                                                </th>
                                                <th>Nama Event</th>
                                                <th>Kode Booth</th>
                                                <th>Tanggal Berlangsung</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dataBooth as $data)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td class="align-middle">{{ $data->event_name }}</td>
                                            </tr>
                                            @endforeach
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
</div>
@endsection @push('scripts')
<!-- JS Libraies -->

<!-- Page Specific JS File -->

<!-- Custom JS -->

@endpush