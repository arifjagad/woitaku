@extends('layouts.app') @section('title', 'Create Admin') @push('style')
<!-- CSS Libraries -->
@endpush @section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Create Admin</h1>
        </div>

        <div class="section-body">
            <div class="card">
                {{-- <div class="card-header">
                        <h4>Example Card</h4>
                    </div> --}}
                <div class="card-body">
                    <form
                        class="needs-validation"
                        novalidate=""
                        method="POST">
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
                <div class="card-footer bg-whitesmoke">
                    This is card footer
                </div>
            </div>
        </div>
    </section>
</div>
@endsection @push('scripts')
<!-- JS Libraies -->

<!-- Page Specific JS File -->
@endpush