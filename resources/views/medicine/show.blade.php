@extends('layouts.app')

@section('content')
    <h1 class="text-center">Patient Records</h1>
    <hr>

    <div class="row gap-2 m-0">
        <div class="col-12">
            <h4>
                <strong>Case Number : </strong>
                {{ $patient->case_no }}
            </h4>
            <hr>
        </div>
        <div class="col-md col-12">
            <div class="row">
                <div class="col-12">
                    <h3>Personal Information</h3>
                </div>
                <div class="col-md-6">
                    <p>
                        <strong>Name : </strong>
                        {{ $patient->first_name }} {{ $patient->mid_name }} {{ $patient->last_name }}
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>Birth Date :</strong> {{ $patient->birth_date }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Gender :</strong> {{ $patient->gender }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Blood Type :</strong> {{ $patient->blood_type }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Religion :</strong> {{ $patient->religion }}</p>
                </div>
                <div class="col-12">
                    <p><strong>Place of Birth :</strong> {{ $patient->birth_place }}</p>
                </div>
                <div class="col-12">
                    <hr>
                </div>
                <div class="col-md-6">
                    <p><strong>Contact No. :</strong> 0{{ $patient->contact_no }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Citizenship :</strong> {{ $patient->citizenship }}</p>
                </div>
                <div class="col-12">
                    <p><strong>Address :</strong> {{ $patient->address }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-bg-primary rounded-3 p-2 mb-3">
                <h4 class="text-center m-0">Patient Diagnosis</h4>
            </div>
            <div class="row">
                <div class="col-12">
                    <h3>Patient Case</h3>
                </div>
                <div class="col-md-6">
                    <p><strong>Admission Date :</strong> {{ $patient_case->admit_date }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Time Arrival :</strong> {{ $patient_case->arrive_time }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Diagnosis :</strong> {{ $patient_case->diagnosis }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Treatment :</strong> {{ $patient_case->treatment }}</p>
                </div>
                <div class="col-12">
                    <hr>
                </div>
                <div class="col-12">
                    <p><strong>Remarks :</strong> {{ $patient_case->remarks }}</p>
                </div>
            </div>
        </div>
        <div class="col-12">
            <hr class="mb-0">
        </div>
        <div class="col-12">
            <h3>Assistance Requests</h3>
        </div>
        {{-- requests list --}}
        @forelse ($patient_assistances as $request)
            <div class="col-12">
                <div class="row">
                    <div class="col">
                        <p class="m-0"><strong>{{ $request->request_type }} :</strong></p>
                    </div>
                    <div class="col">
                        <p class="m-0">{{ $request->status }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted">No request yet.</p>
            </div>
        @endforelse
        <div class="col-12">
            <a href="{{ route('patient.edit', $patient->id) }}" class="text-decoration-none float-md-end">
                <button type="button" class="btn btn-lg btn-primary">Update Records</button>
            </a>
        </div>
    </div>
@endsection
