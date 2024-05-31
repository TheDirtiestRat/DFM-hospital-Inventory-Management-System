@forelse ($barangays as $brgy)
    @if ($brgy->region == $reg->region)
        <div class="col-md-6">
            <div class="row g-2 p-2 bg-light shadow rounded">
                <div class="col m-0 ">
                    <form>
                        <button type="button" class="btn btn-light w-100 text-start btn_pnt{{ $brgy->id }}" data-bs-toggle="modal"
                            data-bs-target="#exampleModal" id="click_btn" value="{{ $brgy->barangay }}">
                            <h5 class="card-title text-truncate m-0 ">Barangay :
                                {{ $brgy->barangay }}</h5>
                        </button>
                    </form>
                </div>
                <div class="col-auto m-0 ">
                    <a href="{{ url('sortPatient') }}?key=brgy&value={{ $brgy->barangay }}"
                        class="btn btn-outline-dark ps-3 pe-3" data-bs-toggle="tooltip" data-bs-title="Total">
                        @foreach ($patients as $p)
                            @if ($p->barangay == $brgy->barangay)
                                {{ $p->total }}
                            @endif
                        @endforeach
                        Patients
                    </a>
                </div>
            </div>
        </div>
    @endif
@empty
    <div class="col">
        <div class="row g-1">
            <div class="col">
                <h4 class="m-0 text-center ">None Yet</h4>
            </div>
        </div>
    </div>
@endforelse
