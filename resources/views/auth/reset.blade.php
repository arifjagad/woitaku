@extends('layouts.auth')

@section('title', 'Reset Password')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="card card-primary">
        @if (session('status'))
            <div id="success-alert" class="alert alert-success alert-dismissible show fade m mb-4">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                    {{ session('status') }}
                </div>
            </div>
        @endif
        <div class="card-header">
            <h4>Reset Password</h4>
        </div>

        <div class="card-body">
            <p class="text-muted">Kami akan mengirimkan link untuk mereset kata sandi Anda.</p>
            <form method="POST" class="needs-validation" novalidate="" action="{{ route('password.update')}}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->token }}">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email"
                        type="email"
                        class="form-control"
                        name="email"
                        tabindex="1"
                        disabled
                        value="{{$request->email}}">
                </div>

                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <input id="password"
                        type="password"
                        class="form-control pwstrength"
                        data-indicator="pwindicator"
                        name="password"
                        tabindex="2"
                        autofocus
                        required>
                </div>

                <div class="form-group">
                    <label for="password-confirm">Konfirmasi Password</label>
                    <input
                        id="password_confirmation"
                        type="password"
                        class="form-control"
                        name="password_confirmation"
                        tabindex="2"
                        required>
                </div>

                <div class="form-group">
                    <button type="submit"
                        class="btn btn-primary btn-lg btn-block"
                        tabindex="4">
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/auth-register.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var passwordInput = document.getElementById('password');
            var passwordConfirmationInput = document.getElementById('password_confirmation');
            var initialPasswordValue = passwordInput.value;
    
            passwordInput.addEventListener('input', function () {
                if (passwordInput.value !== initialPasswordValue) {
                    // Jika kata sandi utama berubah, atur kembali nilai konfirmasi kata sandi
                    passwordConfirmationInput.value = initialPasswordValue;
                }
            });
    
            passwordConfirmationInput.addEventListener('input', function () {
                if (passwordInput.value !== passwordConfirmationInput.value) {
                    passwordConfirmationInput.setCustomValidity("Passwords do not match");
                } else {
                    passwordConfirmationInput.setCustomValidity('');
                }
            });
        });
    </script>
@endpush
