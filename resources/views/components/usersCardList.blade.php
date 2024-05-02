{{-- list of users --}}
@forelse ($users as $user)
    {{-- card --}}
    <div class="col-auto p-0">
        <div class="card" style="width: 18rem;">
            <div class="card-header">
                User ID<strong>: {{ $user->id }}</strong>
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $user->name }}</h5>
                <p class="card-text">{{ $user->email }}</p>
                <div class="text-center">
                    {{-- show level access --}}
                    @if ($user->type == 'ADMIN')
                        <a href="{{ route('user.show', $user->id) }}"
                            class="btn btn-outline-primary w-100">{{ $user->type }}</a>
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
@empty
    {{-- if no users --}}
    <div class="col-12 text-center text-muted">
        <h1 class="m-0">No users Existed with that</h1>
    </div>
@endforelse
