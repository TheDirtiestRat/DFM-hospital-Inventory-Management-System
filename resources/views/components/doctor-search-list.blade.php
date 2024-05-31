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
