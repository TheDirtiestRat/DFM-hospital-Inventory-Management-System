<div class="row justify-content-center g-2 mt-2">
    @forelse ($medicines as $medicine)
        {{-- card --}}
        <div class="col-md-4">
            <div class="card rounded-4 shadow-sm h-100">
                <div class="card-header">
                    @php
                        // shows when the quantity is low
                        $class = '';
                        $tooltip = 'Normal Quantity';
                        $style = '';

                        if ($medicine->quantity <= 15) {
                            $class = 'text-bg-danger rounded-3';
                            $tooltip = 'Low Quantity of Items Needs to replenish';
                            $style = ' fw-bold text-danger ';
                        } elseif ($medicine->quantity <= 50) {
                            $class = 'text-bg-warning rounded-3';
                            $tooltip = 'Quantity of Items Almost Low';
                        }
                    @endphp
                    <div class="text-center {{ $class }}" data-bs-toggle="tooltip"
                        data-bs-title="{{ $tooltip }}">
                        PO No. {{ $medicine->medicine_id }}
                        {{-- PO No. <strong>{{ $medicine->medicine_id }}</strong> --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-md-auto col-12 text-center">
                            <img src="{{ asset('storage/medicine img/' . $medicine->photo) }}"
                                class="img-fill border rounded-4" alt="" width="100" height="100">
                        </div>
                        <div class="col-md-6">
                            <h5 class="card-title text-truncate m-0 ">{{ $medicine->name }}</h5>
                            <p class="card-text m-0 ">Remaining : {{ $medicine->quantity }}</p>
                            <p class="card-text m-0"><small class="text-muted">
                                    {{ $medicine->manufacturer }}</small></p>
                            <p class="card-text m-0"><small class="text-muted">Type :
                                    {{ $medicine->type }}</small></p>
                            {{-- <p class="card-text m-0"><small class="text-muted">Updated:
                                    {{ $medicine->updated_at }}</small></p> --}}
                        </div>
                        <div class="col-md d-flex flex-column gap-2 ">
                            {{-- buttons --}}
                            <form>
                                <button type="button"
                                    class="btn btn-sm btn-outline-primary w-100 btn_pnt{{ $medicine->id }}"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal" id="click_btn"
                                    value="{{ $medicine->id }}">
                                    <i class="bi bi-person-lines-fill"></i>
                                </button>
                            </form>
                            {{-- <a href="#" class="btn btn-sm btn-outline-primary btn_pnt{{ $medicine->id }}"
                                id="click_btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="bi bi-person-lines-fill"></i>
                            </a> --}}
                            <a href="{{ route('medicine.edit', $medicine->id) }}" class="btn btn-sm btn-primary"
                                data-bs-toggle="tooltip" data-bs-title="Update Details">
                                <i class="bi bi-file-earmark-text-fill"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        {{-- if no Medicine --}}
        <div class="col-12 text-center text-muted">
            <h1 class="m-0">No Medicine Listed With that info</h1>
        </div>
    @endforelse
</div>
