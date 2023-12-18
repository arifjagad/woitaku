@extends('layouts.app')

@section('title', 'Booth')

@push('style')

<link href="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.css" rel="stylesheet">
<link rel="stylesheet"
        href="{{ asset('library/prismjs/themes/prism.min.css') }}">
@endpush

@section('main')


<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Booth</h1>
        </div>
        <h2 class="section-title">View All Existing Booth Data!</h2>
        <p class="section-lead">
            You can view all Booth here.
        </p>
        <div class="section-body">
            <div class="card">
                {{-- <div class="card-header">
                        <h4>Example Card</h4>
                    </div> --}}
                <div class="card-body">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table-striped table" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            #
                                        </th>
                                        <th>Booth Name</th>
                                        <th>Event Name</th>
                                        <th>Event Organizer Phone</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $id = 1; @endphp
                                    @foreach($datas as $data)
                                    <tr>
                                        <td>
                                            {{ $id++ }}
                                        </td>
                                        <td>{{ $data->booth_name }}</td>
                                        <td>{{ $data->event_name }}</td>
                                        <td>{{ $data->admin_phone }}</td>
                                        <td>
                                            @php if ($data->availability_status == 'available') {
                                                echo '<span class="badge badge-success">Available</span>';
                                            }else {
                                                echo '<span class="badge badge-danger">Booked</span>';
                                            } @endphp
                                        </td>
                                        <td>
                                            <button class="btn btn-primary" 
                                                onclick="showDetailsModal(
                                                    '{{ $data->booth_name }}',
                                                    '{{ $data->event_name }}',
                                                    '{{ $data->booth_size }}',
                                                    '{{ $data->booth_location }}',
                                                    '{{ $data->provided_facilities }}',
                                                    '{{ addslashes(htmlspecialchars($data->booth_description)) }}',
                                                    '{{ number_format($data->rental_price, 0, ',', '.') }}',
                                                    '{{ $data->rental_time_limit}}',
                                                    '{{ $data->admin_phone}}',
                                                    '{{ $data->availability_status}}',
                                                )">
                                                Detail
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- <div class="card-footer bg-whitesmoke">
                    This is card footer
                </div> --}}
            </div>
        </div>
    </section>
</div>

<!-- Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">Booth Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                <table class="table-striped table">
                    <tr>
                        <td>Booth Name</td>
                        <td>:</td>
                        <td id="boothName"></td>
                    </tr>
                    <tr>
                        <td>Event Name</td>
                        <td>:</td>
                        <td id="eventName"></td>
                    </tr>
                    <tr>
                        <td>Booth Size</td>
                        <td>:</td>
                        <td id="boothSize"></td>
                    </tr>
                    <tr>
                        <td>Booth Location</td>
                        <td>:</td>
                        <td id="boothLocation"></td>
                    </tr>
                    <tr>
                        <td>Provided Facilities</td>
                        <td>:</td>
                        <td id="providedFacilities"></td>
                    </tr>
                    <tr>
                        <td>Booth Description</td>
                        <td>:</td>
                        <td id="boothDescription"></td>
                    </tr>
                    <tr>
                        <td>Rental Price</td>
                        <td>:</td>
                        <td id="rentalPrice"></td>
                    </tr>
                    <tr>
                        <td>Rental Time Limit</td>
                        <td>:</td>
                        <td id="rentalTimeLimit"></td>
                    </tr>
                    <tr>
                        <td>Admin Phone</td>
                        <td>:</td>
                        <td id="adminPhone"></td>
                    </tr>
                    <tr>
                        <td>Availability Status</td>
                        <td>:</td>
                        <td id="availabilityStatus">
                        </td>
                    </tr>
                    
                </table>
                </div>
                <h5 id="competitionName"></h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



@endsection @push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
<script src="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.js"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('js/page/modules-datatables.js') }}"></script>

<!-- Show Modal -->
<script>
    function showDetailsModal(
        boothName, 
        eventName, 
        boothSize, 
        boothLocation, 
        providedFacilities,
        boothDescription,
        rentalPrice,
        rentalTimeLimit,
        adminPhone,
        availabilityStatus
    ) {
        $('#boothName').text(boothName);
        $('#eventName').text(eventName);
        $('#boothSize').text(boothSize);
        $('#boothLocation').text(boothLocation);
        $('#providedFacilities').text(providedFacilities);
        $('#boothDescription').text(boothDescription);
        var rentalPriceFormatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 3, maximumFractionDigits: 3 }).format(rentalPrice);
        $('#rentalPrice').text(rentalPriceFormatted);
        $('#rentalTimeLimit').text(rentalTimeLimit);
        $('#adminPhone').text(adminPhone);
        $('#availabilityStatus').text(availabilityStatus);
        $('#detailsModal').modal('show');
    }

    if (availabilityStatus == 'available') {
        $('#availabilityStatus').text('<span class="badge badge-success">Available</span>');
    }else {
        $('#availabilityStatus').text('<span class="badge badge-danger">Booked</span>');
    }
</script>

@endpush
