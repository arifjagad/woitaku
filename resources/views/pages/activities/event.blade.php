@extends('layouts.app')

@section('title', 'Events')

@push('style')

<link href="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.css" rel="stylesheet">
<link rel="stylesheet"
        href="{{ asset('library/prismjs/themes/prism.min.css') }}">
@endpush

@section('main')


<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Events</h1>
        </div>
        <h2 class="section-title">View All Existing Events Data!</h2>
        <p class="section-lead">
            You can view all Events here.
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
            <div class="card">
                {{-- <div class="card-header">
                        <h4>Example Card</h4>
                    </div> --}}
                <div class="card-body">
                    <form class="needs-validation" novalidate="" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                #
                                            </th>
                                            <th>Event Name</th>
                                            <th>Event Organizer</th>
                                            <th>Event Category</th>
                                            <th>Location</th>
                                            <th>Document</th>
                                            {{-- <th>Event Page</th> --}}
                                            <th>Verification Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $id = 1; @endphp
                                        @foreach ($datas as $data)
                                            <tr>
                                                <td class="text-center">{{ $id++ }}</td>
                                                <td>{{ $data->event_name }}</td>
                                                <td>{{ $data->name }}</td>
                                                <td>{{ $data->event_category }}</td>
                                                <td>{{ $data->city }}</td>
                                                <td><a href="{{ $data->document }}" target="_blank" class="btn btn-primary">View Document</a></td>
                                                {{-- <td>
                                                    <a href="#" class="btn btn-info">Preview</a>
                                                </td> --}}
                                                <td>
                                                    @php if ($data->verification == 'pending') {
                                                        echo '<span class="badge badge-warning">Pending</span>';
                                                    } elseif ($data->verification == 'accepted') {
                                                        echo '<span class="badge badge-success">Accepted</span>';
                                                    } elseif ($data->verification == 'revision') {
                                                        echo '<span class="badge badge-info">Revision</span>';
                                                    }else {
                                                        echo '<span class="badge badge-danger">Rejected</span>';
                                                    } @endphp
                                                </td>
                                                <td>
                                                    @if ($data->verification == 'pending')
                                                        <a href="{{ route('event.accept', $data->id) }}" class="btn btn-success">Accept</a>
                                                        <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#modal-reject" data-id="{{ $data->id }}">Reject</a>
                                                    @elseif ($data->verification == 'accepted')
                                                        <a href="#" class="btn btn-info" data-toggle="modal" data-target="#modal-review" data-id="{{ $data->id }}">Review</a>
                                                    @elseif ($data->verification == 'revision')
                                                        <a href="{{ route('event.accept', $data->id) }}" class="btn btn-success">Accept</a>
                                                        <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#modal-reject" data-id="{{ $data->id }}">Reject</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                    </form>
                </div>
                {{-- <div class="card-footer bg-whitesmoke">
                    This is card footer
                </div> --}}
            </div>
        </div>
    </section>
</div>

<!-- Modal Reject -->
<div class="modal fade" id="modal-reject" tabindex="-1" role="dialog" aria-labelledby="modal-reject-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-reject-label">Feedback for Event Reject</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="needs-validation" novalidate="" method="POST" action="{{ route('event.reject', ['id' => $data->id]) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Modal content goes here -->
                    <div class="form-group">
                        <textarea id="reason_verification_reject" name="reason_verification" class="form-control" data-height="150" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Reject</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Review -->
<div class="modal fade" id="modal-review" tabindex="-1" role="dialog" aria-labelledby="modal-review-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-review-label">Feedback for Event Review</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="needs-validation" novalidate="" method="POST" action="{{ route('event.review', ['id' => $data->id]) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Modal content goes here -->
                    <div class="form-group">
                        <textarea id="reason_verification_review" name="reason_verification" class="form-control" data-height="150" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Review</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection @push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
<script src="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.js"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('js/page/modules-datatables.js') }}"></script>
<script>
    setTimeout(function() {
        $('#success-alert').alert('close');
    }, 1500);
</script>
<script>
    $(document).ready(function() {
        $('#modal-reject').on('show.bs.modal', function(e) {
            var id = $(e.relatedTarget).data('id');
            var href = "{{ route('event.reject', '') }}/" + id;
            $('#modal-reject form').attr('action', href);
        });
    });

    $(document).ready(function() {
        $('#modal-review').on('show.bs.modal', function(e) {
            var id = $(e.relatedTarget).data('id');
            var href = "{{ route('event.review', '') }}/" + id;
            $('#modal-review form').attr('action', href);
        });
    });


</script>


@endpush