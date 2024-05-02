<div class="row justify-content-center g-2 mt-2 w-100">
    @forelse ($medicines as $medicine)
        {{-- card --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    @php
                        // shows when the quantity is low
                        $class = '';
                        $tooltip = 'Normal Quantity';
                        $style = '';

                        if ($medicine->quantity <= 15) {
                            $class = 'text-bg-danger rounded-3';
                            $tooltip = 'Low Quantity of Items';
                            $style = ' fw-bold text-danger ';
                        }
                    @endphp
                    <div class="text-start {{ $class }}" data-bs-toggle="tooltip"
                        data-bs-title="{{ $tooltip }}">
                        Type<strong>: {{ $medicine->type }}</strong></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-between  gap-1 m-0">
                        <div class="col-auto">
                            <img src="{{ asset('storage/medicine img/' . $medicine->photo) }}"
                                class="img-fill border rounded-4" alt="" width="100" height="100">
                        </div>
                        <div class="col-6 p-0">
                            <h5 class="card-title text-truncate m-0 ">{{ $medicine->name }}</h5>
                            <p class="card-text ">Remaining : <span class="{{ $style }}"
                                    id="remaining{{ $medicine->medicine_id }}">{{ $medicine->quantity }}</span></p>
                            {{-- buttons --}}
                            <button type="button" class="btn btn-primary w-100 "
                                onclick='add_medicine("med{{ $medicine->medicine_id }}", "{{ $medicine->name }}", "{{ $medicine->medicine_id }}", "remaining{{ $medicine->medicine_id }}")'>
                                Add
                            </button>
                        </div>
                        {{-- <div class="col-auto text-end p-0 d-flex flex-column gap-2 ">
                            buttons
                            <button type="button" class="btn btn-primary" onclick='add_medicine("med{{ $medicine->medicine_id }}", "{{ $medicine->name }}", "remaining{{ $medicine->medicine_id }}")'>
                                Add
                            </button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    @empty
        {{-- if no Medicine --}}
        <div class="col-12 text-center text-muted">
            <h1 class="m-0">No Medicine Listed</h1>
        </div>
    @endforelse
</div>
