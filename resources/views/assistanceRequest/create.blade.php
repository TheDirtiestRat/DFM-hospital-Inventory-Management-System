@extends('layouts.app')

@section('content')
    <h1 class="text-center">Apply Assistance Request</h1>
    <hr>

    {{-- alert --}}
    @include('components.alert')

    <form action="{{ route('assistanceRequest.store') }}" method="post" class="needs-validations" enctype="multipart/form-data" novalidat>
        {{-- for validation --}}
        @csrf

        <div class="row justify-content-between gap-2 m-0">
            <div class="col-auto">
                <label for="case_number" class="form-label">* Case Number</label>
                <input type="number" class="form-control" placeholder="MRN: 09999" name="case_number" id="case_number"
                    value="{{ $patient['case_no'] }}" required>
            </div>
            <div class="col-auto">
                <div class="row gap-2">
                    <div class="col-auto">
                        <label for="blood_type" class="form-label">* Request Assistance Type</label>
                        <select class="form-select" name="assistance_type" id="assistance_type" required>
                            <option selected disabled value>Select Request Assistance</option>
                            <option value="Medicine">Medicine Request</option>
                            <option value="Medical_Hemodialysis">Medical (Hemodialysis) Request</option>
                            <option value="Burial">Burial Request</option>
                            <option value="Laboratory">Laboratory/Xray/Ct-scan Request</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <label for="date_applyied" class="form-label">* Date</label>
                        <input type="date" class="form-control" name="date_applyied" id="date_applyied" required>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        {{-- request content --}}
        <div class="row p-3" id="patient_information">
            <div class="col">
                <div class="row">
                    <div class="col-12">
                        <h3>Personal Information</h3>
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

        <div class="row justify-content-center">
            <div class="col-auto">
                <button class="btn btn-lg btn-success rounded-3" type="submit">
                    Apply
                </button>
            </div>
        </div>
    </form>

    <script type="module">
        // case_no input
        $('#case_number').on('keyup', function() {
            get_patient_details($(this).val());
        });
        // ajax GET patient information
        function get_patient_details(value) {
            var $case_no = value
            $.ajax({
                url: "{{ url('getPatientInformation') }}",
                type: "GET",
                data: {
                    'case_no': $case_no
                },
                success: function(data) {
                    $('#patient_information').html(data);
                }
            })
        };
    </script>
@endsection
