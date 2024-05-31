@extends('layouts.printables')

@section('title')
    Patient Records
@endsection

@section('content')
    <h1 class="text-center">Patient Records Reports</h1>
    <hr>

    {{-- overview --}}
    <div class="row gap-2 m-0">
        {{-- total patient --}}
        <div class="col-12 p-0 ">
            <div class="row">
                <div class="col">
                    <h2>Overview</h2>
                </div>

            </div>
        </div>

        <div class="col-12 p-0 ">
            <div class="row gap-0 m-0">
                <div class="col-md-4 p-2">
                    <div class="card rounded-4">
                        <div class="row g-0">
                            <div class="col-4 bg-primary rounded-start-4 d-flex justify-content-center align-items-center">
                                <i class="bi bi-person text-light m-0" style="font-size: 3rem"></i>
                            </div>
                            <div class="col-8">
                                <div class="card-body">
                                    <p class="m-0">Total Patients</p>
                                    <h1 class="m-0">{{ $total_patients }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- total request --}}
                <div class="col-md-4 p-2">
                    <div class="card rounded-4">
                        <div class="row g-0">
                            <div class="col-4 bg-primary rounded-start-4 d-flex justify-content-center align-items-center">
                                <i class="bi bi-person-add text-light m-0" style="font-size: 3rem"></i>
                            </div>
                            <div class="col-8">
                                <div class="card-body">
                                    <p class="m-0">Total today</p>
                                    <h1 class="m-0">{{ $total_today }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- total users --}}
                <div class="col-md-4 p-2">
                    {{-- card list --}}
                    <div class="card rounded-4">
                        <div class="row g-0">
                            <div class="col-4 bg-primary rounded-start-4 d-flex justify-content-center align-items-center">
                                <i class="bi bi-table text-light m-0" style="font-size: 3rem"></i>
                            </div>
                            <div class="col-8">
                                <div class="card-body">
                                    <p class="m-0">Despensed</p>
                                    <h1 class="m-0">{{ $total_despensed }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- <div class="col-12 p-0 ">
            <h2>Stats</h2>
        </div> --}}

        <div class="col-12 p-0 ">
            <div class="row g-2">
                <div class="col-md-12">
                    <h3>Stats</h3>
                    {{-- By Sex --}}
                    <div class="card rounded-3 mb-2">
                        <div class="card-header">
                            <h5 class="m-0">Sex</h5>
                        </div>
                        <div class="card-body rounded-4">
                            <div class="row">
                                @foreach ($total_by_gender as $gender)
                                    <div class="col">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title text-truncate m-0 text-muted">{{ $gender->gender }}
                                                </h5>
                                            </div>
                                            <div class="col-auto">
                                                <p class="card-text m-0">{{ $gender->total }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    {{-- By Blood Type --}}
                    <div class="card rounded-3 mb-2">
                        <div class="card-header">
                            <h5 class="m-0">Blood Type</h5>
                        </div>
                        <div class="card-body rounded-4">
                            <div class="row">
                                @foreach ($total_by_bloodType as $type)
                                    <div class="col-4">
                                        <div class="row mb-2 ">
                                            <div class="col">
                                                <h5 class="card-title text-truncate m-0 text-muted">{{ $type->blood_type }}
                                                </h5>
                                            </div>
                                            <div class="col-auto">
                                                <p class="card-text m-0">{{ $type->total }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    {{-- By diagnosis --}}
                    <div class="card rounded-3 mb-2">
                        <div class="card-header">
                            <h5 class="m-0">Diagnosis</h5>
                        </div>
                        <div class="card-body rounded-4">
                            <div class="row">
                                @foreach ($total_by_diagnosis as $diagnosis)
                                    <div class="col-md-4">
                                        <div class="row mb-2 ">
                                            <div class="col">
                                                <h5 class="card-title text-truncate m-0 text-muted">
                                                    {{ $diagnosis->diagnosis }}</h5>
                                            </div>
                                            <div class="col-auto">
                                                <p class="card-text m-0">{{ $diagnosis->total }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    {{-- By Age --}}
                    <div class="card rounded-3 mb-2">
                        <div class="card-header">
                            <h5 class="m-0">Ages</h5>
                        </div>
                        <div class="card-body rounded-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row mb-2 ">
                                        <div class="col">
                                            <h5 class="card-title text-truncate m-0 text-muted">
                                                Kids</h5>
                                        </div>
                                        <div class="col-auto">
                                            <p class="card-text m-0">{{ $child }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row mb-2 ">
                                        <div class="col">
                                            <h5 class="card-title text-truncate m-0 text-muted">
                                                Teen</h5>
                                        </div>
                                        <div class="col-auto">
                                            <p class="card-text m-0">{{ $teen }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row mb-2 ">
                                        <div class="col">
                                            <h5 class="card-title text-truncate m-0 text-muted">
                                                Adult</h5>
                                        </div>
                                        <div class="col-auto">
                                            <p class="card-text m-0">{{ $adult }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row mb-2 ">
                                        <div class="col">
                                            <h5 class="card-title text-truncate m-0 text-muted">
                                                Señor Citizen</h5>
                                        </div>
                                        <div class="col-auto">
                                            <p class="card-text m-0">{{ $old }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- by bmi category --}}
                    <div class="card rounded-3 mb-2">
                        <div class="card-header">
                            <h5 class="m-0">Body Mas Index</h5>
                        </div>
                        <div class="card-body rounded-4">
                            <div class="d-flex flex-wrap gap-2">
                                <button class="btn btn-secondary">Underweight ({{ $underweight }})</button>
                                <button class="btn btn-primary">Normal Weight ({{ $normal_weight }})</button>
                                <button class="btn btn-warning">Overweight ({{ $overweight }})</button>
                                <button class="btn btn-danger">Obesity ({{ $obesity }})</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <h3>New Patients</h3>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Case No.</th>
                                <th>Patient Name</th>
                                {{-- <th>Diagnosis</th> --}}
                                <th>Added At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($new_patients as $patient)
                                <tr>
                                    <td>
                                        {{ $patient->case_no }}
                                    </td>
                                    <td>{{ $patient->first_name . ' ' . $patient->mid_name . ' ' . $patient->last_name }}
                                    </td>
                                    <td><small class="text-muted">Date:
                                            {{ $patient->created_at }}</small></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" class="text-center">New Patients</td>
                            </tr>
                        </tbody>
                    </table>

                    {{-- @foreach ($new_patients as $patient)
                        <div class="card mb-2">
                            <div class="card-header text-bg-primary ">
                                Case No. {{ $patient->case_no }}
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <a href="{{ route('patient.show', $patient->id) }}"
                                            class="btn btn-light text-start w-100 m-0 p-0 " role="button">
                                            <h5 class="card-title text-truncate m-0 ">
                                                {{ $patient->first_name . ' ' . $patient->mid_name . ' ' . $patient->last_name }}
                                            </h5>
                                        </a>

                                    </div>
                                    <div class="col-auto">
                                        <p class="card-text m-0"><small class="text-muted">Date:
                                                {{ $patient->created_at }}</small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach --}}
                </div>
            </div>
        </div>

        <div class="col-12 p-0 ">
            <hr>
        </div>
    </div>
@endsection
