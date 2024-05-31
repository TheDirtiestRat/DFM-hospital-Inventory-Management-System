{{-- overview --}}
<div class="row g-2 text-center ">
    <div class="col-md">
        Today
        <h1>{{ $total_today }}</h1>
    </div>
    <div class="col-md">
        Patients
        <h1>{{ $total_patients }}</h1>
    </div>
    <div class="col-md">
        Despensed
        <h1>{{ $total_despensed }}</h1>
    </div>
</div>

<hr>

<div class="row g-2">
    <div class="col-md">
        {{-- Total by Sex --}}
        <div class=" ">
            <div class="row g-2 text-center">
                <div class="col-12">
                    <h4>Total By Sex</h4>
                </div>
                @foreach ($total_by_gender as $sex)
                    <div class="col-md">
                        <strong>{{ $sex->gender }}:</strong> {{ $sex->total }}
                    </div>
                @endforeach
            </div>
        </div>
        <hr>
        <div class="">
            {{-- by age --}}
            <div class="row g-2 text-center justify-content-around ">
                <div class="col-12">
                    <h4>By Age</h4>
                </div>
                <div class="col-md-4">Baby {{ $baby }}</div>
                <div class="col-md-4">Kids {{ $child }}</div>
                <div class="col-md-4">Teen {{ $teen }}</div>
                <div class="col-md-4">Adult {{ $adult }}</div>
                <div class="col-md-4">Señor Citizen {{ $old }}</div>
            </div>
        </div>
        <hr>
        {{-- By Blood types --}}
        <div class="">
            <div class="row g-2 text-center justify-content-around ">
                <div class="col-12">
                    <h4>Blood Types</h4>
                </div>
                @forelse ($total_by_bloodType as $bt)
                    <div class="col-md-auto">{{ $bt->blood_type . ' ' . $bt->total }}</div>
                @empty
                    <div class="col-md-auto">None Yet</div>
                @endforelse
            </div>
        </div>
        <hr>
        <div class="">
            <div class="row g-2 text-center justify-content-around ">
                <div class="col-12">
                    <h4>By Diagnosis</h4>
                </div>
                @foreach ($total_by_diagnosis as $d)
                    <div class="col-md-auto">{{ $d->diagnosis }} ({{ $d->total }})</div>
                @endforeach
            </div>
        </div>
        <hr>
        <h5 class="text-center">BMI</h5>
        <div class="d-flex flex-wrap justify-content-center gap-2">
            <span class="badge text-bg-secondary">Underweight {{ $Underweight }}</span>
            <span class="badge text-bg-danger">Obesity {{ $Obesity }}</span>
            <span class="badge text-bg-primary">Normal weight {{ $Normal_weight }}</span>
            <span class="badge text-bg-warning">Overweight {{ $Overweight }}</span>
        </div>
    </div>
    <div class="col-md">
        {{-- New patients --}}
        <div class="row g-2">
            <div class="col-12 text-center ">
                <h4>New Patients</h4>
            </div>
            @forelse ($new_patients as $p)
                <div class="col-12">
                    <div class="row g-2">
                        <div class="col-auto"><a href="{{ route('patient.show', $p->id) }}"
                                class="btn btn-outline-secondary w-100 ">Case no:
                                {{ $p->case_no }}</a></div>
                        <div class="col"><a href="http://" class="btn btn-outline-primary w-100 ">
                                {{ $p->first_name . ' ' . $p->mid_name . ' ' . $p->last_name }}
                            </a></div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <h3 class="text-muted">
                        No Patients
                    </h3>
                </div>
            @endforelse

        </div>
    </div>
</div>

<br>

{{-- <div class="row g-2">
    <div class="col-md">
        
    </div>
    <div class="col-md">
        
    </div>
</div> --}}
