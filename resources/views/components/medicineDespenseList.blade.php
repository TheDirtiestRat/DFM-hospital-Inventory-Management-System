<div class="row g-3">
    @forelse ($medicines as $medicine)
        <div class="col-md-4">
            <div class="card h-100" style="">
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
                    <div class="text-start p-2 {{ $class }}" data-bs-toggle="tooltip"
                        data-bs-title="{{ $tooltip }}">
                        Type<strong>: {{ $medicine->type }}</strong></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-1 m-0">
                        <div class="col-auto">
                            <img src="{{ asset('storage/medicine img/' . $medicine->photo) }}"
                                class="img-fill border rounded-4" alt="" width="100" height="100">
                        </div>
                        <div class="col-6">
                            <h5 class="card-title text-truncate m-0 ">{{ $medicine->name }}</h5>
                            <p class="card-text ">Remaining : <span class="{{ $style }}"
                                    id="remaining{{ $medicine->medicine_id }}">{{ $medicine->quantity }}</span>
                            </p>
                            <button type="button" class="btn btn-primary btn-sm w-100 "
                                onclick='add_medicine("med{{ $medicine->medicine_id }}", "{{ $medicine->name }}", "{{ $medicine->medicine_id }}", "remaining{{ $medicine->medicine_id }}")'>
                                Add
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center">
            <h1 class="m-0">No Medicine Listed</h1>
        </div>
    @endforelse
</div>
{{-- <div class="row justify-content-center g-2 mt-2 w-100">
    @forelse ($medicines as $medicine)
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
                            <button type="button" class="btn btn-primary w-100 "
                                onclick='add_medicine("med{{ $medicine->medicine_id }}", "{{ $medicine->name }}", "{{ $medicine->medicine_id }}", "remaining{{ $medicine->medicine_id }}")'>
                                Add
                            </button>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center text-muted">
            <h1 class="m-0">No Medicine Listed</h1>
        </div>
    @endforelse
</div> --}}
