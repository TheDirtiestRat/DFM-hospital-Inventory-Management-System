<table class="table table-striped table-hover w-100 ">
    <thead class="">
        <tr>
            <th scope="col" style="width: 10%">Id</th>
            <th scope="col">Medicine</th>
            <th scope="col" class="text-end">Type</th>
            <th scope="col" class="text-center" style="width: 15%">Quantity</th>
            <th scope="col" style="width: 5%">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($medicines as $medicine)
            <tr>
                <th>@php
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
                        data-bs-title="{{ $tooltip }}">{{ $medicine->medicine_id }}</a>
                    </div>
                </th>
                <td>{{ $medicine->name }} <small class="text-muted float-end">{{ $medicine->manufacturer }}</small></td>
                <td class="text-end">{{ $medicine->type }}</td>
                <td class="text-center">{{ $medicine->quantity }}</td>
                <td class="d-flex flex-row gap-2 ">
                    <form>
                        <button type="button" class="btn btn-sm btn-outline-primary btn_pnt{{ $medicine->id }}"
                            data-bs-toggle="modal" data-bs-target="#exampleModal" id="click_btn"
                            value="{{ $medicine->id }}">
                            <i class="bi bi-person-lines-fill"></i>
                        </button>
                    </form>
                    <a href="{{ route('medicine.edit', $medicine->id) }}" class="btn btn-sm btn-primary"
                        data-bs-toggle="tooltip" data-bs-title="Update Details">
                        <i class="bi bi-file-earmark-text-fill"></i>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <th colspan="4">1</th>
            </tr>
        @endforelse
    </tbody>
    <caption>List of users</caption>
</table>
