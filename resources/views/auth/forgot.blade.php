@extends('layouts.auth')

@section('title', 'Forgot Password')

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
            <h4>Forgot Password</h4>
        </div>
        
        <div class="card-body">
            <p class="text-muted">We will send a link to reset your password</p>
            <form class="needs-validation" novalidate="" method="POST" action="{{ route('password.email')}}">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email"
                        type="email"
                        class="form-control"
                        name="email"
                        tabindex="1"
                        required
                        autofocus>
                </div>
                
                <div class="form-group">
                    <button type="submit"
                        class="btn btn-primary btn-lg btn-block"
                        tabindex="4">
                        Forgot Password
                    </button>
                </div>
            </form>
            <div class="text-center">
                <a href="{{ route('login') }}">Back to Login</a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
    <script>
        // Setelah 3 detik, sembunyikan atau hapus elemen alert
        setTimeout(function() {
            $('#success-alert').alert('close'); // Menggunakan metode 'close' dari Bootstrap
            // atau
            // $('#success-alert').remove(); // Untuk menghapus elemen dari DOM
        }, 1500);
    </script>
@endpush
