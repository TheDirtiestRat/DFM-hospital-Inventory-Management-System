@extends('layouts.app')

@section('content')
    <h1 class="text-center">Approve Request Assistance</h1>
    <hr>


    {{-- request content --}}
    <div class="row p-3" id="patient_information">
        <div class="col">
            <div class="row">
                <div class="col-12">
                    <h3>Personal Information</h3>
                </div>
                <div class="col-12">
                    <p><strong>Case_no :</strong> {{ $patient['case_no'] }}</p>
                    <hr>
                </div>
                <div class="col-md-6">
                    <p>
                        <strong>Name : </strong>
                        {{ $patient['first_name'] }} {{ $patient['mid_name'] }} {{ $patient['last_name'] }}
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>Birth Date :</strong> {{ $patient['birth_date'] }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Gender :</strong> {{ $patient['gender'] }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Blood Type :</strong> {{ $patient['blood_type'] }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Religion :</strong> {{ $patient['religion'] }}</p>
                </div>
                <div class="col-12">
                    <p><strong>Place of Birth :</strong> {{ $patient['birth_place'] }}</p>
                </div>
                <div class="col-12">
                    <hr>
                </div>
                <div class="col-md-6">
                    <p><strong>Contact No. :</strong> 0{{ $patient['contact_no'] }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Citizenship :</strong> {{ $patient['citizenship'] }}</p>
                </div>
                <div class="col-12">
                    <p><strong>Address :</strong> {{ $patient['address'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-bg-success rounded-3 p-2 mb-3">
                <h4 class="text-center m-0">Patient Diagnosis</h4>
            </div>
            <div class="row">
                <div class="col-12">
                    <h3>Patient Case</h3>
                </div>
                <div class="col-12">
                    <p><strong>Appication Date :</strong> {{ $patient['request_date'] }}</p>
                    <p><strong>Assistance type :</strong> {{ $patient['request_type'] }}</p>
                    <hr>
                </div>
                <div class="col-md-6">
                    <p><strong>Admission Date :</strong> {{ $patient['admit_date'] }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Time Arrival :</strong> {{ $patient['arrive_time'] }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Diagnosis :</strong> {{ $patient['diagnosis'] }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Treatment :</strong> {{ $patient['treatment'] }}</p>
                </div>
                <div class="col-12">
                    <hr>
                </div>
                <div class="col-12">
                    <p><strong>Remarks :</strong> {{ $patient['remarks'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <hr class="mb-4">

    {{-- form --}}
    <form action="{{ route('assistanceRequest.update', $patient['id']) }}" method="post" class="needs-validations"
        enctype="multipart/form-data" novalidat>
        {{-- for validation --}}
        @csrf
        @method('PUT')

        {{-- hidden input --}}
        <div class="visually-hidden">
            <label for="id" class="form-label">* Id</label>
            <input type="number" class="form-control" name="id" id="id" value="{{ $patient['id'] }}">
        </div>

        {{-- disable the buttons if no inputs is added --}}
        @php
            $directive = '';
            if (empty($patient['id'])) {
                $directive = 'disabled';
            }
        @endphp

        <div class="row justify-content-center">
            <div class="col-auto">
                <button class="btn btn-lg btn-success rounded-3" type="submit" name="status" value="APPROVE" {{ $directive }}>
                    Approve Request
                </button>
            </div>
            <div class="col-auto">
                <button class="btn btn-lg btn-danger rounded-3" type="submit" name="status" value="REJECT" {{ $directive }}>
                    Reject Request
                </button>
            </div>
        </div>
    </form>
@endsection
