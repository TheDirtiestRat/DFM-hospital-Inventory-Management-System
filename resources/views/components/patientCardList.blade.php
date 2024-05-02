<div class="row justify-content-center g-2 mt-2">
    @forelse ($patients as $patient)
        {{-- card --}}
        <div class="col-md-4">
            <div class="card rounded-4 shadow-sm ">
                {{-- <div class="card rounded-4 shadow-sm " style="width: 19rem;"> --}}
                <div class="card-header">
                    <div class="text-center">
                        <form>
                            <button type="button" class="btn btn-primary w-100 text-start btn_pnt{{ $patient->id }}"
                                data-bs-toggle="modal" data-bs-target="#exampleModal" id="click_btn"
                                value="{{ $patient->id }}">
                                MRN<strong>: {{ $patient->case_no }}</strong></a>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row gap-1 m-0">
                        <div class="col-10 p-0">
                            <h5 class="card-title text-truncate m-0 ">{{ $patient->first_name }}
                                {{ $patient->mid_name }}
                                {{ $patient->last_name }}</h5>
                            <p class="card-text m-0 ">{{ $patient->diagnosis }}</p>
                            <p class="card-text m-0"><small class="text-muted">Admission Date:
                                    {{ $patient->created_at }}</small></p>
                        </div>
                        <div class="col-auto p-0">
                            <div class="d-flex flex-column gap-1">
                                {{-- buttons --}}
                                <a href="{{ route('patient.show', $patient->id) }}" class="text-decoration-none"
                                    data-bs-toggle="tooltip" data-bs-title="Go to Patient Case">
                                    <button type="button" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-person-lines-fill"></i>
                                    </button>
                                </a>
                                <a href="{{ url('applyAssistanceRequest', $patient->id) }}" class="text-decoration-none"
                                    data-bs-toggle="tooltip" data-bs-title="Apply for Assistance">
                                    <button type="button" class="btn btn-sm btn-primary">
                                        <i class="bi bi-file-earmark-text-fill"></i>
                                    </button>
                                </a>
                                <a href="{{ route('patient.edit', $patient->id) }}" class="text-decoration-none"
                                    data-bs-toggle="tooltip" data-bs-title="Update Patient Case">
                                    <button type="button" class="btn btn-sm btn-primary">
                                        <i class="bi bi-person-fill-gear"></i>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        {{-- if no patients --}}
        <div class="col-12 text-center text-body-emphasis ">
            <h1 class="m-0">No Patients Listed With that Name</h1>
        </div>
    @endforelse
</div>
