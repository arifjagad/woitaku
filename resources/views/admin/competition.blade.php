@extends('layouts.app')

@section('title', 'Competitions')

@push('style')

<link href="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.css" rel="stylesheet">
<link rel="stylesheet"
        href="{{ asset('library/prismjs/themes/prism.min.css') }}">
@endpush

@section('main')


<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Competitions</h1>
        </div>
        <h2 class="section-title">View All Existing Competitions Data!</h2>
        <p class="section-lead">
            You can view all Competitions here.
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
                                        <th>Competition Name</th>
                                        <th>Event Name</th>
                                        <th>Category</th>
                                        <th>Competition Fee</th>
                                        <th>Participant Qty</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $id = 1; @endphp
                                    @foreach ($datas as $data)
                                        <tr>
                                            <td class="text-center">{{ $id++ }}</td>
                                            <td>{{$data->competition_name}}</td>
                                            <td>{{$data->event_name}}</td>
                                            <td>{{$data->id_competition_category}}</td>
                                            <td>IDR {{ number_format($data->competition_fee, 0, ',', '.') }}</td>
                                            <td>{{$data->participant_qty}} peserta</td>
                                            <td>
                                                <button class="btn btn-primary" 
                                                    onclick="showDetailsModal(
                                                        '{{ $data->competition_name }}',
                                                        '{{ $data->event_name }}',
                                                        '{{ $data->name }}',
                                                        '{{ $data->id_competition_category }}',
                                                        '{{ number_format($data->competition_fee, 0, ',', '.') }}',
                                                        '{{ $data->participant_qty }}',
                                                        '{{ addslashes(htmlspecialchars($data->competition_description)) }}',
                                                        '{{ $data->competition_start_date}}',
                                                        '{{ $data->competition_end_date}}',
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
                <h5 class="modal-title" id="detailsModalLabel">Competition Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                <table class="table-striped table">
                    <tr>
                        <td>Competition Name</td>
                        <td>:</td>
                        <td id="competitionName"></td>
                    </tr>
                    <tr>
                        <td>Event Name</td>
                        <td>:</td>
                        <td id="eventName"></td>
                    </tr>
                    <tr>
                        <td>Event Organizer</td>
                        <td>:</td>
                        <td id="eoName"></td>
                    </tr>
                    <tr>
                        <td>Competition Category</td>
                        <td>:</td>
                        <td id="idCompetitionCategory"></td>
                    </tr>
                    <tr>
                        <td>Competition Fee</td>
                        <td>:</td>
                        <td id="competitionFee"></td>
                    </tr>
                    <tr>
                        <td>Participant Quantity</td>
                        <td>:</td>
                        <td id="participantQty"></td>
                    </tr>
                    <tr>
                        <td>Competition Description</td>
                        <td>:</td>
                        <td id="competitionDescription" class="text-justify"></td>
                    </tr>
                    <tr>
                        <td>Competition Period</td>
                        <td>:</td>
                        <td>
                            <span id="competitionStartDate"></span> - <span id="competitionEndDate"></span>
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
        competitionName, 
        name, 
        eventName, 
        idCompetitionCategory, 
        competitionFee, 
        participantQty, 
        competitionDescription,
        competitionStartDate,
        competitionEndDate
    ) {
        $('#competitionName').text(competitionName);
        $('#eventName').text(name);
        $('#eoName').text(eoName);
        $('#idCompetitionCategory').text(idCompetitionCategory);
        var competitionFeeFormatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 3, maximumFractionDigits: 3 }).format(competitionFee);
        $('#competitionFee').text(competitionFeeFormatted);
        $('#participantQty').text(participantQty + ' peserta');
        $('#competitionDescription').text(competitionDescription);
        $('#competitionStartDate').text(competitionStartDate);
        $('#competitionEndDate').text(competitionEndDate);
        $('#detailsModal').modal('show');
    }
</script>
@endpush
