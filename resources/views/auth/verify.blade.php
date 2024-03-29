@extends('layouts.auth')

@section('title', 'Verify Account')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="card card-primary">
        <div class="card-header">
            <h4>Verifikasi Akun</h4>
        </div>

        <div class="card-body">

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600">
                    Kami telah mengirimkan verifikasi email baru ke inbox Anda!
                </div>
            @endif
            
            <form method="POST" action="{{ route('verification.send')}}" class="needs-validation" novalidation>
                @csrf

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        Kirim Ulang Email Verifikasi
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/jquery.pwstrength/jquery.pwstrength.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/auth-register.js') }}"></script>
@endpush
