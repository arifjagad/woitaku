@extends('layouts.auth') @section('title', 'Register') @push('style')
<!-- CSS Libraries -->
<link
    rel="stylesheet"
    href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush @section('main')
<div class="card card-primary">
    <div class="card-header">
        <h4>Register</h4>
    </div>

    <div class="card-body">
        <form class="needs-validation" novalidate="" method="POST">
            @csrf
            <div class="card-header">
                <h4>Create a New Admin by Filling Out This Form.</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <div class="row">
                        <div class="form-group col-6">
                            <label>Your Name</label>
                            <input
                                id="name"
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                name="name"
                                required="required">
                            @error('name')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group col-6">
                            <label>Your Email</label>
                            <input
                                id="email"
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                name="email"
                                required="required">
                            @error('email')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label>Password</label>
                            <input
                                id="password"
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                name="password"
                                required="required">
                            @error('password')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group col-6">
                            <label>Password Confirmation</label>
                            <input
                                id="password2"
                                type="password"
                                class="form-control @error('password2') is-invalid @enderror"
                                name="password_confirmation"
                                required="required">
                            @error('password2')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                            <!-- Error Message -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <button class="btn btn-primary">Create Admin</button>
            </div>
        </form>
    </div>
</div>
@endsection @push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
<script src="{{ asset('library/jquery.pwstrength/jquery.pwstrength.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/auth-register.js') }}"></script>
@endpush