@extends('layouts.app')

@section('content')
    <h1 class="text-center">Assistance Request List</h1>
    <hr>

    {{-- alert --}}
    @include('components.alert')

    {{-- search bar --}}
    <div class="row gap-2 m-0">
        <div class="col p-0">
            <input type="search" class="form-control" id="searchbar" name="searchbar"
                placeholder="Search Request case number...">
        </div>
        <div class="col-auto p-0">
            <button class="btn btn-success">Search</button>
        </div>
        <div class="col-12 p-0">
            {{-- tag list --}}
            <div class="row gap-2 m-0">
                <div class="col-auto p-0">
                    <!-- Split dropup button -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-success">Requests Status</button>
                        <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('search_request') }}?key=APPROVE">Approve</a></li>
                            <li><a class="dropdown-item" href="{{ url('search_request') }}?key=PENDING">Pending</a></li>
                            <li><a class="dropdown-item" href="{{ url('search_request') }}?key=REJECT">Rejected</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col p-0">
                    <a href="" class="text-decoration-none float-end" target="_blank">
                        <button class="btn btn-success rounded-3">Print list as PDF</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="m-3">
        {{-- content nav tab --}}
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link active" href="#"><i class="bi bi-card-list"></i> Requests</a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link" href="#"><i class="bi bi-card-list"></i> Rejected</a>
            </li> --}}
        </ul>

        {{-- list of request --}}
        <div class="row justify-content-center gap-2 m-0" id="request_list_area">
            @forelse ($assistance_requests as $request)
                {{-- card --}}
                <div class="col-auto p-0">
                    <div class="card" style="width: 18rem;">
                        <div class="card-header">
                            Case number<strong>: {{ $request->case_no }}</strong>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $request->first_name }} {{ $request->mid_name }}
                                {{ $request->last_name }}</h5>
                            <p class="card-text">{{ $request->request_type }}</p>
                            <div class="text-center">
                                {{-- show status buttons --}}
                                @if ($request->status == 'PENDING')
                                    <a href="{{ route('assistanceRequest.edit', $request->id) }}"
                                        class="btn btn-warning w-100">{{ $request->status }}</a>
                                @elseif ($request->status == 'APPROVE')
                                    <a href="" class="btn btn-success w-100">{{ $request->status }}</a>
                                @else
                                    <a href="" class="btn btn-danger w-100">{{ $request->status }}</a>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted">
                    <h1 class="m-0">No Requests Listed</h1>
                </div>
            @endforelse
        </div>
    </div>

    {{-- pagination --}}
    <div class="row m-0 text-bg-success rounded-4 p-3">
        {{ $assistance_requests->links('vendor.pagination.bootstrap-5') }}
    </div>

    {{-- script ajax --}}
    <script type="module">
        $('#searchbar').on('keyup', function() {
            var $value = $(this).val();
            // console.log($value)
            search_patient($value);
        });

        // ajax search function
        function search_patient(key) {
            var $search_key = key
            // console.log($search_key)
            $.ajax({
                url: "{{ url('search_request') }}",
                type: "GET",
                data: {
                    'key': $search_key
                },
                success: function(data) {
                    $('#request_list_area').html(data);
                }
            })
        }
    </script>
@endsection
