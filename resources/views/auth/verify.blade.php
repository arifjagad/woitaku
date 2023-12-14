@extends('layouts.auth')

@section('title', 'Verify Account')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="card card-primary">
        <div class="card-header">
            <h4>Verify Account</h4>
        </div>

        <div class="card-body">

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600">
                    A new email verification link has been emailed to you!
                </div>
            @endif
            
            <form method="POST" action="{{ route('verification.send')}}" class="needs-validation" novalidation>
                @csrf

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        Resend Verification Email
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
