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
                Kamu bisa menemukan semua pengaturan utama di sini.
            </p>
            <div class="section-body">
                <div class="row">
                    <!-- Panggil Components Sidebar-Profile.blade.php -->
                    @include('components.sidebar-profile')
                    <div class="col-sm-12 col-md-12 col-lg-9">
                        @if(auth()->user()->email_verified_at == null)
                        <div class="alert alert-danger mb-4">
                            Akun belum diverifikasi, silahkan cek email anda untuk melakukan verifikasi akun.
                        </div>
                        @endif
                        <div class="card">
                            <div class="card-header">
                                <h4>Informasi Pribadi</h4>
                            </div>
                            <form
                                class="needs-validation"
                                novalidate=""
                                action="{{ route('update-profile', ['id' => $dataMember->id]) }}"
                                method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                                <label>Nama</label>
                                                <input
                                                    id="name"
                                                    type="text"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    name="name"
                                                    value="{{ auth()->user()->name }}"
                                                    required>
                                                <!-- Error Message -->
                                                @error('name')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                                <label>Email</label>
                                                <input
                                                    id="email"
                                                    type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    name="email"
                                                    value=" {{ auth()->user()->email }} "
                                                    required>
                                                <!-- Error Message -->
                                                @error('email')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-12">
                                                <label>Foto Profil</label>
                                                <div class="custom-file">
                                                    <input type="file"
                                                        name="foto_profile"
                                                        class="custom-file-input @error('foto_profile') is-invalid @enderror"
                                                        id="foto_profile"
                                                        value="{{ $dataMember->foto_profile }}"
                                                        accept=".jpg, .jpeg, .png"
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
                                                    Gambar harus memiliki ukuran maksimal 300 KB
                                                    <span class="float-right">{{basename($dataMember->foto_profile)}}</span>
                                                </div>
                                            </div>
                                            <div class="form-group col-12">
                                                <label>Alamat</label>
                                                <input
                                                    id="address"
                                                    type="text"
                                                    class="form-control @error('address') is-invalid @enderror"
                                                    name="address"
                                                    value="{{ $dataMember->address }}"
                                                    required>
                                                <!-- Error Message -->
                                                @error('address')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                                <label>Kota</label>
                                                <select class="form-control select2" id="city" name="city">
                                                    @foreach ($indonesiaCities as $city)
                                                        <option value="{{ $city }}" @if ($city == $dataMember->kota) selected @endif>{{ $city }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                                <label>Nomor Whatsapp (628xx)</label>
                                                <input
                                                    id="whatsappNumber"
                                                    type="text"
                                                    class="form-control @error('whatsappNumber') is-invalid @enderror"
                                                    name="whatsappNumber"
                                                    placeholder="62821xxxxxx"
                                                    value="{{ $dataMember->nomor_whatsapp }}"
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
                                    <button class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h4>Perbaharui Password</h4>
                            </div>
                            <form
                                class="needs-validation"
                                novalidate=""
                                action="{{ route('update-password', ['id' => $dataMember->id]) }}"
                                method="POST"
                                >
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                                <label>Password Baru</label>
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
                                            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                                <label>Konfirmasi Password</label>
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
                                    <button class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection @push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>

<!-- Custom JS -->
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
<script>
    function updateInputLabel(inputId) {
        $(inputId).on('change', function() {
          var fileName = $(this).val().split('\\').pop(); // memisahkan path, mengambil hanya nama file
          $(this).next('.custom-file-label').text(fileName); // mengganti teks pada label
        });
      }
    
      // Memanggil fungsi untuk setiap input file
      updateInputLabel('#foto_profile');
</script>
@endpush