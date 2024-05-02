@extends('layouts.app')

@section('content')
    <h1 class="text-center">User List</h1>
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
            <div class="row gap-2 m-0">
                <div class="col-auto p-0">
                    <!-- Split dropup button -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-primary">Users Type</button>
                        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            {{-- list user types --}}
                            @forelse ($user_types as $type)
                                <li><a class="dropdown-item"
                                        href="{{ url('search_user') }}?key={{ $type->type }}">{{ $type->type }}</a></li>
                            @empty
                                <li>No Users</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                <div class="col p-0">
                    <button class="btn btn-primary rounded-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Add New
                        Users</button>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="m-3">
        {{-- content nav tab --}}
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#"><i class="bi bi-card-list"></i> Users</a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link active" href="#"><i class="bi bi-table"></i> STAFF</a>
            </li> --}}
        </ul>

        {{-- list of request --}}
        <div class="row justify-content-center g-2" id="usersListArea">
            {{-- add new user card (optional) --}}
            {{-- <div class="col-auto p-0">
                <button class="btn btn-primary rounded-3 h-100" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    style="width: 18rem;">
                    <h3 class="m-0">Add New User</h3>
                </button>
            </div> --}}
            {{-- list of users --}}
            @foreach ($users as $user)
                {{-- card --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            User ID<strong>: {{ $user->id }}</strong>
                            @if ($user->is_login == 1)
                                <span class="badge text-bg-success">Online</span>
                            @else
                                <span class="badge text-bg-secondary">Offline</span>
                            @endif

                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $user->name }}</h5>
                            <p class="card-text">{{ $user->email }}</p>
                            <div class="text-center">
                                {{-- show level access --}}
                                @if ($user->type == 'ADMIN')
                                    <a href="{{ route('user.show', $user->id) }}"
                                        class="btn btn-outline-primary w-100">{{ $user->type }}
                                    </a>
                                @elseif ($user->type == 'PHARMACIST')
                                    <a href="{{ route('user.show', $user->id) }}"
                                        class="btn btn-primary w-100">{{ $user->type }}</a>
                                @elseif ($user->type == 'RECEPTIONIST')
                                    <a href="{{ route('user.show', $user->id) }}"
                                        class="btn btn-outline-primary w-100">{{ $user->type }}</a>
                                @else
                                    <a href="{{ route('user.show', $user->id) }}"
                                        class="btn btn-secondary w-100">{{ $user->type }}</a>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- pagination --}}
    <div class="row m-0 text-bg-primary rounded-4 p-3">
        {{ $users->links('vendor.pagination.bootstrap-5') }}
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add New User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" class="needs-validations" enctype="multipart/form-data" novalidat>
                    <div class="modal-body">
                        {{-- form --}}

                        {{-- for validation --}}
                        @csrf

                        {{-- credentials login --}}
                        <div class="row g-2">
                            <div class="col-12">
                                <h3>User Information</h3>
                            </div>
                            <div class="col-12">
                                <label for="username" class="form-label">* User Name</label>
                                <input type="text" class="form-control" placeholder="UserName" name="username"
                                    id="username" value="" required>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="password" placeholder="Password"
                                        name="password" required>
                                    <label for="password">* Password</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="password_confirmation"
                                        placeholder="Confirm Password" name="password_confirmation" required>
                                    <label for="password">Confirm Password</label>
                                </div>
                            </div>

                            {{-- <div class="col">
                                <label for="password" class="form-label">* Password</label>
                                <input type="password" class="form-control" placeholder="First Name" name="password"
                                    id="password" value="" required>
                            </div> --}}

                        </div>

                        {{-- credentials details --}}
                        <div class="row g-2 mt-2">
                            <div class="col-md col-12">
                                <label for="type" class="form-label">* User Type</label>
                                <select class="form-select" name="type" id="type" required>
                                    <option selected disabled value>Select User Type</option>
                                    {{-- <option value="STAFF">STAFF</option>
                                    <option value="ADMIN">ADMIN</option>
                                    <option value="LGU">LGU</option> --}}
                                    <option value="PHARMACIST">PHARMACIST</option>
                                    <option value="RECEPTIONIST">RECEPTIONIST</option>
                                    {{-- <option value="ADMIN">ADMIN</option> --}}
                                </select>
                            </div>
                            <div class="col-md col-12">
                                <label for="email" class="form-label">* Email</label>
                                <input type="email" class="form-control" placeholder="John@email.ocm" name="email"
                                    id="email" value="" required>
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
                url: "{{ url('search_user') }}",
                type: "GET",
                data: {
                    'key': $search_key
                },
                success: function(data) {
                    $('#usersListArea').html(data);
                }
            })
        });
    </script>
@endsection
