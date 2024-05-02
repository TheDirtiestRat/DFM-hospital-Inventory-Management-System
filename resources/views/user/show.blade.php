@extends('layouts.app')

@section('content')
    <h1 class="text-center">User Profile</h1>
    <hr>

    {{-- alert --}}
    @include('components.alert')

    <div class="row gap-2 m-0">
        <div class="col-12">
            <h4>
                <strong>User Id : </strong>
                {{ $user->id }}
            </h4>
            <hr>
        </div>
        <div class="col-md col-12">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Username :</strong> {{ $user->name }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Email :</strong> {{ $user->email }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>User Type:</strong> {{ $user->type }}</p>
                </div>
                {{-- <div class="col-md-6">
                    <p><strong>Password :</strong> </p>
                </div> --}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-bg-primary rounded-3 p-2 mb-3">
                <h4 class="text-center m-0">User Activity</h4>
            </div>
            <div class="row">
                <div class="col-md-6">
                    {{-- show if user is log-in --}}
                    @if (Auth::check())
                        <span class="text-success">Is Login</span>
                    @else
                        <span class="text-muted">Offline</span>
                    @endif

                    <p><strong>Active :</strong>
                        @if ($user->is_login == 1)
                            <span class="text-success">Is Login</span>
                        @else
                            <span class="text-muted">Offline</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
        <div class="col-12">
            <hr class="mb-0">
        </div>
        <div class="col-12">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formModal">Update
                Profile</button>
            {{-- show if not the user it self --}}
            @if ($user->id != Auth::user()->id)
                <button type="button" class="btn btn-danger float-md-end" data-bs-toggle="modal"
                    data-bs-target="#deleteModal">Remove User</button>
            @endif
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- form --}}
                <form action="" method="post" class="needs-validations" enctype="multipart/form-data" novalidat>
                    <div class="modal-body">
                        {{-- for validation --}}
                        @csrf
                        @method('PUT')

                        {{-- credentials login --}}
                        <div class="row g-2">
                            <div class="col-12">
                                <h3>User Information</h3>
                            </div>
                            <div class="col-12">
                                <label for="username" class="form-label">* User Name</label>
                                <input type="text" class="form-control" placeholder="Last Name" name="username"
                                    id="username" value="{{ $user->name }}" required>
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
                                    <option value="PHARMACIST">PHARMACIST</option>
                                    <option value="RECEPTIONIST">RECEPTIONIST</option>
                                    {{-- <option value="ADMIN">ADMIN</option> --}}
                                </select>
                            </div>
                            <div class="col-md col-12">
                                <label for="email" class="form-label">* Email</label>
                                <input type="email" class="form-control" placeholder="John@email.ocm" name="email"
                                    id="email" value="{{ $user->email }}" required>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- delete Modal --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Remove User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure to remove <strong>{{ $user['name'] }}</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                    {{-- data deletion form --}}
                    <form action="{{ route('user.destroy', $user->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- script --}}
    <script>
        document.getElementById('type').value = '{{ $user->type }}';
    </script>
@endsection
