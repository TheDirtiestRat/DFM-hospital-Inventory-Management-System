@extends('layouts.app')

@section('content')
    <h1 class="text-center">List of Doctors</h1>
    <hr>

    {{-- alert --}}
    @include('components.alert')

    {{-- search bar --}}
    <div class="row gap-2 m-0">
        <div class="col p-0">
            <input type="search" class="form-control" id="searchbar" name="searchbar" placeholder="Search User Name...">
        </div>
        <div class="col-auto p-0">
            <button class="btn btn-primary">Search</button>
        </div>
        <div class="col-12 p-0">
            {{-- tag list --}}
            {{-- <div class="row gap-2 m-0">
                <div class="col p-0">
                    <button class="btn btn-primary rounded-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Add New
                        Doctor</button>
                </div>
            </div> --}}
        </div>
    </div>

    <hr>

    <div class="m-3">
        {{-- content nav tab --}}
        {{-- <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#"><i class="bi bi-card-list"></i> Doctors</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#"><i class="bi bi-table"></i> STAFF</a>
            </li>
        </ul> --}}

        <div class="tabcontent">
            <div class="row g-2" id="doctorsListArea">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            Add Doctor
                        </div>
                        <div class="card-body">
                            <button class="btn btn-primary rounded-3 h-100 w-100 " data-bs-toggle="modal"
                                data-bs-target="#exampleModal">Add New
                                Doctor</button>
                        </div>
                    </div>
                </div>
                {{-- list of users --}}
                @forelse ($doctors as $doc)
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <strong>License No. {{ $doc->license_no }}</strong>

                                {{-- data deletion form --}}
                                <form action="{{ route('doctors.destroy', $doc->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">
                                        DR. {{ $doc->full_name }}
                                    </h5>
                                    <a href="{{ route('doctors.show', $doc->id) }}" class="btn btn-success">See Details</a>
                                </div>
                                <p class="card-text mt-2">{{ $doc->description }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-header">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-muted">No Doctors Listed</h5>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        {{-- list of request --}}

    </div>

    {{-- pagination --}}
    <div class="row m-0 text-bg-primary rounded-4 p-3">
        {{ $doctors->links('vendor.pagination.bootstrap-5') }}
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Doctor</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('doctors.store') }}" method="post" class="needs-validations"
                    enctype="multipart/form-data" novalidat>
                    <div class="modal-body">
                        {{-- for validation --}}
                        @csrf

                        <div class="row g-2">
                            <div class="col-12">
                                <h3>Doctor Information</h3>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="license_no" placeholder="License Number"
                                        name="license_no" required>
                                    <label for="license_no" class="form-label">License No.</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="full_name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" placeholder="Full Name" name="full_name"
                                    id="full_name" value="" required>
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" class="form-control" id="description" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- search user script --}}
    <script type="module">
        $('#searchbar').on('keyup', function() {
            var $value = $(this).val();
            console.log($value)
            var $search_key = $value
            // console.log($search_key)
            $.ajax({
                url: "{{ url('search_doctor') }}",
                type: "GET",
                data: {
                    'key': $search_key
                },
                success: function(data) {
                    $('#doctorsListArea').html(data);
                }
            })
        });
    </script>
@endsection
