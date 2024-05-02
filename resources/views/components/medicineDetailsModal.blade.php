{{-- imported data --}}

<div class="row align-items-center ">
    <div class="col-12">
        <h3>Medicine Information</h3>
        <hr>
    </div>

    {{-- image --}}
    <div class="col-md-4">
        <img src="{{ asset('storage/medicine img/'. $medicine->photo) }}" class="img-fill border rounded-4 shadow " alt=""
            id="outputImage" width="250px" height="250px">
    </div>
    {{-- information --}}
    <div class="col-md-8">
        <div class="row">
            <div class="col-12">
                <p class="m-0"><strong>Batch No. : </strong> <br>{{ $medicine->batch_no }}</p>
            </div>

            <div class="col-md-4">
                <p class="m-0"><strong>Name : </strong> <br> {{ $medicine->name }}</p>
            </div>
            <div class="col-md-4">
                <p class="m-0"><strong>Manufacturer : </strong> <br>{{ $medicine->manufacturer }}</p>
            </div>
            <div class="col-md-4">
                <p>
                    <strong>Type : </strong> <br>
                    {{ $medicine->type }}
                </p>
            </div>

            <div class="col-md-4">
                <p class="m-0"><strong>Quantity : </strong> <br> {{ $medicine->quantity }}</p>
            </div>
            <div class="col-md-4">
                <p class="m-0"><strong>Package Type : </strong> <br> {{ $medicine->package_type }}</p>
            </div>
            <div class="col-md-4">
                <p class="m-0"><strong>Mesurement : </strong> <br>{{ $medicine->mesurement_value }}
                    {{ $medicine->mesurement }}</p>
            </div>

            <div class="col-12">
                <p>
                    <strong>Description : </strong> <br>
                    {{ $medicine->description }}
                </p>
            </div>

            <div class="col-12">
                <p class="m-0"><strong>Expiration Date :</strong> <br> {{ $medicine->expired_date }}</p>
            </div>
        </div>
    </div>

    <div class="col-12">
        <hr>
        <h3>Medicine Despensed</h3>
    </div>

    {{-- list of despensed meds --}}
    <div class="col-12 overflow-scroll" style="height: 20vh">
        @forelse ($despensed_meds as $despense)
            <div class="row">
                <div class="col-md-4">
                    <p class="m-0"><strong>Despenser : </strong> <br> {{ $despense->despenser }}</p>
                </div>
                <div class="col-md">
                    <p class="m-0"><strong>Despensed :</strong> <br> ({{ $despense->case_no }})
                        {{ $despense->first_name }} {{ $despense->mid_name }} {{ $despense->last_name }}</p>
                </div>
                <div class="col-md-auto text-md-end ">
                    <p class="m-0"><strong>Quantity :</strong> <br> {{ $despense->quantity }}</p>
                </div>
                <div class="col-12">
                    <small class="text-muted">Date: {{ $despense->created_at }}</small>
                </div>
            </div>

        @empty
            <p>Not despensed yet.</p>
        @endforelse
    </div>
</div>
