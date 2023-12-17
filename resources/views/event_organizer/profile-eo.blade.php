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

        <div class="section-body">
            <div class="row">
                {{-- <div class="col-12 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Guidebook</h4>
                        </div>
                        <div class="card-body">
                            Isi Guide Book
                        </div>
                    </div>
                </div> --}}

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Your Profile</h4>
                        </div>
                        <form
                            class="needs-validation"
                            novalidate=""
                            method="POST"
                            action="{{ route('update-profile-eo', ['id' => $data->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label>Name Organizer</label>
                                            <input
                                                id="name"
                                                type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                name="name"
                                                value="{{$data->name}}"
                                                required>
                                            <!-- Error Message -->
                                            @error('name')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-6">
                                            <label>Email</label>
                                            <input
                                                id="email"
                                                type="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                name="email"
                                                value="{{$data->email}}"
                                                required>
                                            <!-- Error Message -->
                                            @error('email')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-12">
                                            <label>Description / About Organizer</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror"
                                                name="description"
                                                id="description"
                                                data-height="100"
                                                required>{{$data->description}}</textarea>
                                            <!-- Error Message -->
                                            @error('description')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-12">
                                            <label>Organizer Profile Picture</label>
                                            <div class="custom-file">
                                                <input type="file"
                                                    name="foto_profile"
                                                    class="custom-file-input @error('foto_profile') is-invalid @enderror"
                                                    id="foto_profile"
                                                    value="{{$data->foto_profile}}"
                                                    >
                                                <label class="custom-file-label">Choose File</label>
                                                <!-- Error Message -->
                                                @error('foto_profile')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="form-text text-muted">
                                                The image must have a maximum size of 300kb <span class="float-right">{{basename($data->foto_profile)}}</span>
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <label>Address</label>
                                            <input
                                                id="address"
                                                type="text"
                                                class="form-control @error('address') is-invalid @enderror"
                                                name="address"
                                                value="{{$data->alamat}}"
                                                required>
                                            <!-- Error Message -->
                                            @error('address')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-6">
                                            <label>City</label>
                                            <input
                                                id="city"
                                                type="text"
                                                class="form-control @error('address') is-invalid @enderror"
                                                name="city"
                                                value="{{$data->kota}}"
                                                required>
                                            <!-- Error Message -->
                                            @error('city')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-6">
                                            <label>WhatsApp Number (628xx)</label>
                                            <input
                                                id="whatsappNumber"
                                                type="text"
                                                class="form-control @error('whatsappNumber') is-invalid @enderror"
                                                name="whatsappNumber"
                                                placeholder="62821xxxxxx"
                                                value="{{$data->nomor_whatsapp}}"
                                                required>
                                            <!-- Error Message -->
                                            @error('whatsappNumber')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                            @enderror
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
                                            <!-- Error Message -->
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
                                                class="form-control"
                                                name="password_confirmation"
                                                required>
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