@extends('layouts.app-member') 
@section('title', 'Profile')

@push('style')
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.css" rel="stylesheet">
    <style>
        .preview-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 6px;
        }
    </style>
@endpush

@section('main')

<div class="main-content " style="padding: 80px 0px;">
    <div class="container">
        <section class="section">
            <h2 class="section-title">Hi, {{auth()->user()->name}}!</h2>
            <p class="section-lead">
                You can adjust all general settings here.
            </p>
            <div class="section-body">
                <div class="row">
                    <!-- Panggil Components Sidebar-Profile.blade.php -->
                    @include('components.sidebar-profile')
                    <div class="col-sm-12 col-md-12 col-lg-9">
                        <div class="card">
                            <div class="card-header">
                                <h4>Pengaturan Booth</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped nowrap" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    #
                                                </th>
                                                <th>Nama Event</th>
                                                <th>Kode Booth</th>
                                                <th>Tanggal Berlangsung</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dataBooth as $key => $data)
                                                <tr>
                                                    <td class="text-center">
                                                    {{ $loop->iteration }}
                                                    </td>
                                                    <td>{{ $data->event_name }}</td>
                                                    <td>{{ $data->booth_code }}</td>
                                                    <td>{{ $data->start_date }}</td>
                                                    <td class="align-middle">
                                                        <a href="#" class="btn btn-success show-detail" data-toggle="modal" data-target="#tambahProdukBoothModal{{ $key }}">Atur Booth</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@foreach ($dataBooth as $key => $data)
<!-- Modal Detail Booth -->
<div class="modal fade" id="tambahProdukBoothModal{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="tambahProdukBoothModalLabel" aria-hidden="true">
    <!-- Modal content -->
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahProdukBoothModalLabel">Tambahkan Produk Booth Kamu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form 
                    action="{{ route('update-detail-booth') }}"
                    method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="booth_id" value="{{ $data->id }}">
                    <div class="card-body">
                        <div class="alert alert-info my-4">
                            <p class="text-center">Upload semua produk yang kamu punya ke dalam ini</p>
                        </div>
                        <div class="form-group col-12">
                            <label>Nama Booth</label>
                            <input
                                id="booth_name"
                                type="text"
                                class="form-control @error('booth_name') is-invalid @enderror"
                                name="booth_name"
                                value="{{ $data->booth_name }}"
                                required>
                            <!-- Error Message -->
                            @error('booth_name')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group col-12">
                            <label>Thumbnail Booth</label>
                            <div class="custom-file">
                                <input type="file"
                                    name="thumbnail_booth"
                                    class="custom-file-input @error('thumbnail_booth') is-invalid @enderror"
                                    id="thumbnail_booth"
                                    accept=".jpg, .jpeg, .png"
                                    >
                                <label class="custom-file-label">Choose File</label>
                                <!-- Error Message -->
                                @error('thumbnail_booth')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="form-text text-muted">
                                Gambar harus memiliki ukuran maksimal 300 KB.
                            </div>
                        </div>
                        <div class="form-group col-12">
                            <label>Deskripsi Booth</label>
                            <textarea
                                id="booth_description"
                                class="form-control @error('booth_description') is-invalid @enderror"
                                name="booth_description"
                                rows="5"
                                required
                            >{{ $data->booth_description }}</textarea>
                            <!-- Error Message -->
                            @error('booth_description')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group col-12">
                            <label>Upload Produk Booth</label>
                            <div class="custom-file" style="display: flex; align-items: center;">
                                <input type="file"
                                    name="booth_image[]"
                                    class="custom-file-input @error('booth_image') is-invalid @enderror"
                                    id="booth_image"
                                    accept=".jpg, .jpeg, .png"
                                    multiple
                                >
                                <label class="custom-file-label" id="file-label">Choose Files</label>
                                <!-- Error Message -->
                                @error('booth_image')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            @if($data->booth_image == null)
                                <div class="d-flex justify-content-start mt-4">
                                    <div id="preview-container">
                                    </div>
                                </div>
                            @else
                                <div class="d-flex justify-content-start mt-4">
                                    <div id="preview-container">
                                        @foreach (json_decode($data->booth_image) as $key => $image)
                                            <img src="{{ asset('storage/booth_images/'.$image) }}" class="preview-image gap">
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection @push('scripts')
<!-- JS Libraies -->
<script src="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.js"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/modules-datatables.js') }}"></script>

<!-- Custom JS -->
<script>
    document.getElementById('booth_image').addEventListener('change', function (e) {
        var files = e.target.files;
        var previewContainer = document.getElementById('preview-container');
        previewContainer.innerHTML = '';

        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            var reader = new FileReader();

            reader.onload = function (e) {
                var img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('preview-image');
                img.classList.add('gap');
                previewContainer.appendChild(img);
            };

            reader.readAsDataURL(file);
        }

        // Update label to display the number of selected files
        document.getElementById('file-label').innerText = files.length + ' Files Selected';
    });
</script>


@endpush