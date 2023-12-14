@extends('layouts.auth') 
@section('title', 'Register') 
@push('style')
<!-- CSS Libraries -->
<link
    rel="stylesheet"
    href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">
<style>

</style>
@endpush 
@section('main')

<div class="card card-primary">
    <div class="card-header">
        <h4>Register</h4>
    </div>

    <div class="card-body">
        <form
            method="POST"
            action="{{route('register')}}"
            class="needs-validation"
            novalidate="">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input
                    id="name"
                    type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    name="name"
                    tabindex="1"
                    required="required"
                    autofocus="autofocus">
                @error('name')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    id="email"
                    type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    name="email"
                    tabindex="1"
                    required="required"
                    autofocus="autofocus">
                @error('email')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="control-label">Password</label>
                <input
                    id="password"
                    type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    name="password"
                    tabindex="2"
                    required="required">
                @error('password')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Password Confirmation</label>
                <input
                    id="password_confirmation"
                    type="password"
                    class="form-control @error('password_confirmation') is-invalid @enderror"
                    name="password_confirmation"
                    required>
                @error('password_confirmation')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
                <!-- Error Message -->
            </div>

            <!-- ... -->
            <div class="form-group">
                <div class="d-block">
                    <label for="account-type" class="control-label">Account Type</label>
                    <div class="float-right">
                        <a href="#" data-toggle="tooltip" title="Tentukan Jenis Akun Anda!" class="text-small">
                            <i class="fa-solid fa-circle-info"></i> Information
                        </a>
                    </div>
                </div>
                <div class="selectgroup w-100">
                    <label class="selectgroup-item">
                        <input type="radio" name="user_type" value="member" class="selectgroup-input" checked>
                        <span class="selectgroup-button">Member</span>
                    </label>
                    <label class="selectgroup-item">
                        <input type="radio" name="user_type" value="event organizer" class="selectgroup-input">
                        <span class="selectgroup-button">Event Organizer</span>
                    </label>
                </div>
            </div>
            <!-- ... -->


            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                    Register
                </button>
            </div>
        </form>
    </div>
</div>

<div class="text-muted mt-5 text-center">
    Already have an account? <a href='{{ route('login') }}'>Log in</a>
</div>
@endsection @push('scripts')
<!-- JS Libraies -->

<!-- Page Specific JS File -->
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