@extends('layouts.app-member') 
@section('title', 'Profile')

@push('style')
<link rel="stylesheet"
        href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')

<div class="main-content" style="padding: 80px 0px;">
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <img src="{{
                            asset('storage/'.$detailEvent->featured_image)
                        }}" alt="" class="img-fluid rounded" style="width: 100%; height: auto;">
                        <span style="position: absolute; top: 30px; right: 40px;" class="badge badge-danger text-uppercase py-2 px-4">
                            @if ($detailEvent->ticket_price = 0)
                                GRATIS
                            @else
                                BERBAYAR
                            @endif
                        </span>
                    </div>
                    <div class="card-body">
                        <h3 class="text-primary">  {{ $detailEvent->event_name }} </h3>
                        <p>
                            {!! $detailEvent->event_description !!}
                        </p>
                    </div>
                </div>

                
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Your Profile</h4>
                    </div>

                
                </div>
            </div>
        </div>
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
@endpush