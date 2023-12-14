@extends('layouts.app') @section('title', 'Profile')

@push('style')
@endpush

@section('main')


<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Profile Event Organizer</h1>
        </div>
        <h2 class="section-title">Hi, {{auth()->user()->name}}!</h2>
        <p class="section-lead">
            Change information about yourself on this page.
        </p>
        @if (session('success'))
            <div id="success-alert" class="alert alert-success alert-dismissible show fade m">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Guidebook</h4>
                        </div>
                        <div class="card-body">
                            123
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Your Profile</h4>
                        </div>
                        <form
                            class="needs-validation"
                            novalidate=""
                            method="POST"
                            action="{{ route('update-profile-eo', ['id' => $data->id]) }}">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label>Name</label>
                                            <input
                                                id="name"
                                                type="text"
                                                class="form-control"
                                                name="name"
                                                value="{{$data->name}}"
                                                required>
                                        </div>
                                        <div class="form-group col-6">
                                            <label>Email</label>
                                            <input
                                                id="email"
                                                type="email"
                                                class="form-control"
                                                name="email"
                                                value="{{$data->email}}"
                                                required>
                                        </div>
                                        <div class="form-group col-12">
                                            <label>Description / About Organizer</label>
                                            <textarea class="form-control"
                                                name="description"
                                                id="description"
                                                data-height="100"
                                                required>{{$data->description}}</textarea>
                                        </div>
                                        <div class="form-group col-12">
                                            <label>Organizer Profile Picture</label>
                                            <div class="custom-file">
                                                <input type="file"
                                                    name="site_logo"
                                                    class="custom-file-input"
                                                    id="site-logo"
                                                    >
                                                <label class="custom-file-label">Choose File</label>
                                            </div>
                                            <div class="form-text text-muted">The image must have a maximum size of 200KB
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <label>Address</label>
                                            <input
                                                id="address"
                                                type="text"
                                                class="form-control"
                                                name="address"
                                                value="{{$data->alamat}}"
                                                required>
                                        </div>
                                        <div class="form-group col-6">
                                            <label>City</label>
                                            <input
                                                id="city"
                                                type="text"
                                                class="form-control"
                                                name="city"
                                                value="{{$data->kota}}"
                                                required>
                                        </div>
                                        <div class="form-group col-6">
                                            <label>WhatsApp Number</label>
                                            <input
                                                id="whatsappNumber"
                                                type="text"
                                                class="form-control"
                                                name="whatsappNumber"
                                                placeholder="62821xxxxxx"
                                                value="{{$data->nomor_whatsapp}}"
                                                required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Update Profile</button>
                            </div>
                        </form>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4>Update Password</h4>
                        </div>
                        <form
                            class="needs-validation"
                            novalidate=""
                            method="POST"
                            action="{{ route('update-password-eo', ['id' => $data->id]) }}">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label>New Password</label>
                                            <input
                                                id="password"
                                                type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password"
                                                required>
                                            @error('password')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-6">
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
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection @push('scripts')
<!-- JS Libraies -->

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