@extends('layouts.printables')

@section('title')
    Despense Medicine Reciept
@endsection

@section('content')
    <div class="container pt-3 pb-3" style="width: 460px">
        <div class="text-center">
            <img src="{{ asset('/storage/images/ormoc.png') }}" alt="" width="75px" height="75px">
            <h1 class="text-center">@include('components.title')</h1>
        </div>
        <h3 class="text-center">Despense Medicine Reciept</h3>
        <h4 class="text-center"></h4>

        <hr>

        <h6>Patient Case No : {{ $patient->case_no }}</h6>
        <h5>{{ strtoupper($patient->first_name . ' ' . $patient->mid_name . ' ' . $patient->last_name) }}</h5>
        <div class="">
            <h6>Age : {{ $patient->age }}</h6>
            <h6>Sex : {{ $patient->gender }}</h6>
        </div>
        <h6>Patient Diagnosis : {{ $patient->diagnosis }}</h6>

        <hr>

        <h5>Despensed Date : {{ $data_today }}</h5>
        <h5>Despenser : {{ $request->despenser }}</h5>

        <hr>

        <h1 class="text-center">Medicine's Despensed</h1>
        <p>Despensed Medicine to the patient.</p>
        <div class="d-flex flex-column gap-1">
            {{-- list of medicines dispensed --}}
            @for ($i = 0; $i < $medicines->count(); $i++)
                <div class="row g-2 d-flex align-items-center">
                    <div class="col-auto">
                        <h6><strong>{{ $medicines[$i]->medicine_id }}</strong></h6>
                    </div>
                    <div class="col-auto">
                        <h6>{{ $medicines[$i]->name }}</h6>
                    </div>
                    <div class="col">
                        <hr>
                    </div>
                    <div class="col-auto">
                        <h6>{{ $medicines[$i]->mesurement }} {{ $request->quantity[$i] }}</h6>
                    </div>
                </div>
            @endfor
        </div>

        <hr>

        <div class="row g-2 d-flex alighn-items-center">
            <div class="col-auto">
                <h3 class="m-0">TOTAL PROCURED :</h3>
            </div>
            <div class="col"></div>
            <div class="col-auto">
                <h3>{{ $medicines->count() }}</h3>
            </div>
        </div>

        <hr>

        {{-- <p class=" text-justify w-100 mb-3">Note: This reciept serve as a copy of the medicines depenesed for the patient. Please keep this reciept as copy
            of proof
            that the patient is given the listed medicines in this set date {{ $data_today }} if any mistake in
            pocurement of the medicine
            or any missed despensed medicine please contact the pharmacy responsible of despensing this listed medicines.
            This reciept only
            shows the poccured medicines and not the previous ones.
        </p> --}}

        <div class="d-flex justify-content-center">
            <div class="w-75 row g-2 mt-4">
                <div class="col">
                    <p class="m-0">
                        <strong>{{ strtoupper($doctor->full_name) }}</strong>
                    </p>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <div class="row w-75 g-2">
                <div class="col-auto">
                    <p>License No.</p>
                </div>
                <div class="col">
                    <p>{{ $doctor->license_no }}</p>
                </div>
            </div>
        </div>

        <hr>

        {{-- <div class="text-center text-muted">
            <p>** PLEASE PRESENT THIS TO THE DOCTOR IF GOING IN FOR A SECOND DIAGNOSIS **
            </p>
        </div> --}}

        <div class="text-center">
            @include('components.copyright')
        </div>
    </div>

    <form action="{{ url('recordDespenseMedicine') }}" method="post" class="needs-validations text-center" novalidat>
        {{-- for validation --}}
        @csrf
        <div class="visually-hidden">
            <input type="text" class="visually-hidden " name="despenser" value="{{ $request->despenser }}">
            <input type="number" class="form-control mb-2" placeholder="999999" name="doc_license_no"
                            id="doc_license_no" value="{{ $request->doc_license_no }}" required>
            <input type="number" class="form-control" placeholder="999999" name="patient_case_id"
                value="{{ $request->patient_case_id }}" required>
                {{-- diagnosis no --}}
                <input type="text" class=" visually-hidden" name="diagnosis" value="{{ $request->diagnosis }}" id="diagnosis">
            @for ($i = 0; $i < count($request->medicine); $i++)
                <input type="text" name="medicine[]" value="{{ $request->medicine[$i] }}">
                <input type="number" name="quantity[]" value="{{ $request->quantity[$i] }}">
            @endfor
        </div>
        <button class="btn btn-primary rounded-3 noprint" type="submit">
            Continue
        </button>
    </form>
@endsection
