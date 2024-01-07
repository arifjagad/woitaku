@extends('layouts.app-member') 
@section('title', 'Transaksi')

@push('style')
@endpush
@section('main')
<div class="main-content d-flex justify-content-center align-items-center" style="padding-left: 0px !important">
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Transaksi Anda</h3>
                    </div>
                    <div class="card-body">
                        <h6>Detail Transaksi</h6>
                        <table class="table">
                            <tr>
                                <td>1</td>
                                <td>12-12-2019</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>12-12-2019</td>
                            </tr>
                        </table>
                    </div>
                    <div class="card-footer">

                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-header">

                    </div>
                    <div class="card-body">

                    </div>
                    <div class="card-footer">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
@push('scripts')

@endpush