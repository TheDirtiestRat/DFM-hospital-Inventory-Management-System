@extends('layouts.app')

@section('content')
    <h1 class="text-center">Update Patient Records</h1>
    <hr>

    {{-- alert --}}
    @include('components.alert')

    <form action="{{ route('patient.update', $patient->id) }}" method="post" class="needs-validations" enctype="multipart/form-data" novalidat>
        {{-- for validation --}}
        @csrf
        @method('PUT')

        {{-- input details --}}
        <div class="row justify-content-between gap-2 m-0">
            <div class="col-auto">
                <label for="case_number" class="form-label">Case Number</label>
                <input type="number" class="form-control" placeholder="MRN: 09999" name="case_number" id="case_number"
                    value="{{ $patient->case_no }}" required readonly>
            </div>
            <div class="col-auto">
                <div class="row gap-2">
                    <div class="col-auto">
                        <label for="brought_by" class="form-label">Brought By</label>
                        <input type="text" class="form-control" placeholder="Example" name="brought_by" id="brought_by"
                            value="{{ $patient_case->brought_by }}">
                    </div>
                    <div class="col-auto">
                        <label for="time_arrival" class="form-label">Time of Arrival</label>
                        <input type="time" class="form-control" name="time_arrival" id="time_arrival" value="{{ $patient_case->arrive_time }}">
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row gap-2 m-0">
            <div class="col-sm col-12 p-0">
                <div class="row g-2 m-2">
                    <div class="col-12">
                        <h3>Personal Information</h3>
                    </div>
                    <div class="col-md col-12">
                        <label for="lastname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" placeholder="Last Name" name="last_name" id="lastname"
                            value="{{ $patient->last_name }}" required>
                    </div>
                    <div class="col">
                        <label for="firstname" class="form-label">First Name</label>
                        <input type="text" class="form-control" placeholder="First Name" name="first_name" id="firstname"
                            value="{{ $patient->first_name }}" required>
                    </div>
                    <div class="col">
                        <label for="middlename" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" placeholder="Middle Name" name="mid_name"
                            id="middlename" value="{{ $patient->mid_name }}">
                    </div>
                </div>

                <div class="row g-2 m-2">
                    <div class="col-md col-12">
                        <label for="birth_date" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" name="birthDate" id="birth_date" value="{{ $patient->birth_date }}">
                    </div>
                    <div class="col-md-auto">
                        <label for="age" class="form-label">* Age</label>
                        <input type="number" class="form-control" placeholder="18" name="age" id="age"
                            min="0" max="200" step="1" value="{{ $patient->age }}" required>
                    </div>
                    <div class="col-md col-12">
                        <label for="blood_type" class="form-label">Blood Type</label>
                        <select class="form-select" name="blood_type" id="blood_type" required>
                            <option selected disabled value>Select Blood Type</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                        </select>
                    </div>
                    <div class="col-md col-12">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select" name="gender" id="gender" required>
                            <option selected disabled value>Select Gender</option>
                            <option value="Female">Female</option>
                            <option value="Male">Male</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                </div>

                <div class="row g-2 m-2">
                    <div class="col-md col-12">
                        <label for="birth_place" class="form-label">Place of Birth</label>
                        <input type="text" class="form-control" placeholder="BRGY. MACALIPAY PASTRANA LEYTE"
                            name="birth_place" id="birth_place" value="{{ $patient->birth_place }}" required>
                    </div>
                    <div class="col">
                        <label for="religion" class="form-label">Religion</label>
                        <input type="text" class="form-control" placeholder="Religion" name="religion"
                            id="religion" value="{{ $patient->religion }}">
                    </div>
                </div>

                <div class="row g-2 m-2">
                    <div class="col">
                        <label for="contact_number" class="form-label">Contact No.</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">63+</span>
                            <input type="text" class="form-control" placeholder="09298568072" aria-label="Username"
                                name="contact_number" id="contact_number" aria-describedby="basic-addon1" value="{{ $patient->contact_no }}">
                        </div>
                    </div>
                    <div class="col">
                        <label for="citizenship" class="form-label">Citizenship</label>
                        <input type="text" class="form-control" placeholder="FILIPINO" name="citizenship"
                            id="citizenship" value="{{ $patient->citizenship }}">
                    </div>
                    <div class="col-12">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" placeholder="BRGY. MACALIPAY PASTRANA LEYTE"
                            name="address" id="address" value="{{ $patient->address }}">
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-4 p-0">
                <div class="row g-2 m-2">
                    <div class="col-12">
                        <h3>Patient Case</h3>
                    </div>
                    <div class="col-12">
                        <label for="diagnosis" class="form-label">Diagnosis</label>
                        <input type="text" class="form-control" placeholder="Example" name="diagnosis"
                            id="diagnosis" value="{{ $patient_case->diagnosis }}">
                    </div>
                    <div class="col-12">
                        <label for="treatment" class="form-label">Treatment</label>
                        <input type="text" class="form-control" placeholder="Example" name="treatment"
                            id="treatment" value="{{ $patient_case->treatment }}">
                    </div>
                    <div class="col-12">
                        <label for="admit_date" class="form-label">Date</label>
                        <input type="date" class="form-control" name="admit_date" id="admit_date" value="{{ $patient_case->admit_date }}">
                    </div>
                    <div class="col-12">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea class="form-control" name="remarks" id="remarks" rows="3">{{ $patient_case->remarks }}</textarea>
                    </div>
                </div>
            </div> --}}
        </div>

        {{-- submit button --}}
        <div class="row g-2">
            <div class="col-12">
                <hr class="m-3">
            </div>
            <div class="col">
                <button class="btn btn-lg btn-primary rounded-3 float-end" type="submit">
                    Update
                </button>
            </div>
        </div>
    </form>

    {{-- for the select input values --}}
    <script>
        document.getElementById('blood_type').value = '{{ $patient->blood_type }}';
        document.getElementById('gender').value = '{{ $patient->gender }}';
    </script>
@endsection
