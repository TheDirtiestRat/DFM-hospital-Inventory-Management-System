<div class="row g-2">
    <div class="col-12">
        <h2 class="m-0 text-center">
            Diagnosis No. {{ $diagnosis->diagnosis_no }}
        </h2>
    </div>
    <div class="col-md-6">
        Diagnosis: <strong>{{ $diagnosis->diagnosis }}</strong>
    </div>
    <div class="col-md-6">
        Treatment: <strong>{{ $diagnosis->treatment }}</strong>
    </div>
    <div class="col-md-6">
        Date Admit: <strong>{{ $diagnosis->admit_date }}</strong>
    </div>
    <div class="col-md-6">
        Arrival Time: <strong>{{ $diagnosis->arrive_time }}</strong>
    </div>
    <div class="col-12">
        <strong>Remarks:</strong>
    </div>
    <div class="col-12">
        {{ $diagnosis->remarks }}
    </div>
    <div class="col-12">
        <hr>
    </div>
    <div class="col-12 table-responsive" style="max-height: 40vh">
        <h3>Despensed Medicine</h3>
        {{-- table --}}
        <table class="table">
            <thead>
                <tr>
                    <th>Medicine</th>
                    <th class="text-end">Quantity</th>
                    <th class="text-end">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($despensed_medicines as $medicine)
                    <tr>
                        <td>{{ $medicine->medicine }} {{ $medicine->name }}</td>
                        <td class="text-end">{{ $medicine->total }}</td>
                        <td class="text-end">{{ $medicine->created_at }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">
                            Not Despense Yet
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
