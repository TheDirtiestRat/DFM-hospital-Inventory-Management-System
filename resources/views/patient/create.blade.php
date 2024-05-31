@extends('layouts.app')

@php
    // for testing purposes
    $test_value = '';
    $test_val_num = 0;
@endphp

@section('link')
    <style>
        .ra {
            color: red;
        }

        /* datalist {
                                            display: block;
                                        } */
    </style>
@endsection

@section('content')
    <h1 class="text-center">Add Patient</h1>
    <hr>

    {{-- alert --}}
    @include('components.alert')

    <form action="{{ route('patient.store') }}" method="post" class="needs-validations" enctype="multipart/form-data"
        novalidat>
        {{-- for validation --}}
        @csrf

        <div class="row justify-content-between gap-2 m-0">
            <div class="col-auto">
                <label for="case_number" class="form-label">Case Number</label>
                <input type="number" class="form-control" placeholder="MRN: 999999" name="case_number" id="case_number"
                    value="{{ $generated_case_no }}" readonly required>
            </div>
            <div class="col-auto">
                <div class="row gap-2">
                    <div class="col-auto">
                        <label for="brought_by" class="form-label"> Brought By</label>
                        <input type="text" class="form-control" placeholder="Example" name="brought_by" id="brought_by"
                            value="{{ $test_value }}">
                    </div>
                    <div class="col-auto">
                        <label for="time_arrival" class="form-label">Time of Arrival</label>
                        <input type="time" class="form-control" name="time_arrival" id="time_arrival"
                            value="{{ $arrival_time }}">
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
                        <label for="last_name" class="form-label"><span class="ra"><span class="ra">*</span></span>
                            Last Name</label>
                        <input type="text" class="form-control" placeholder="Last Name" name="last_name" id="last_name"
                            value="{{ $test_value }}" required>
                    </div>
                    <div class="col">
                        <label for="firstname" class="form-label"><span class="ra"><span class="ra">*</span></span>
                            First Name</label>
                        <input type="text" class="form-control" placeholder="First Name" name="first_name" id="firstname"
                            value="{{ $test_value }}" autocomplete="true" required>
                    </div>
                    <div class="col">
                        <label for="middlename" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" placeholder="Middle Name" name="mid_name" id="middlename"
                            value="">
                    </div>
                </div>

                <div class="row g-2 m-2">
                    <div class="col-md col-12">
                        <label for="birth_date" class="form-label"><span class="ra"><span class="ra">*</span></span>
                            Date of Birth</label>
                        <input type="date" class="form-control" name="birthDate" id="birth_date"
                            max="{{ $date_today }}" value="" onchange="set_age()" required>
                    </div>
                    <div class="col-md-auto">
                        <label for="age" class="form-label"><span class="ra">*</span> Age by year <span
                                id="age_mean"></span></label>
                        <input type="number" class="form-control" placeholder="18" name="age" id="age"
                            min="0" max="200" step="1" value="" readonly>
                    </div>
                    <div class="col-md col-12">
                        <label for="blood_type" class="form-label"><span class="ra">*</span> Blood Type</label>
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
                        <label for="gender" class="form-label"><span class="ra">*</span> Sex</label>
                        <select class="form-select" name="gender" id="gender" required>
                            <option selected disabled value>Select Gender</option>
                            <option value="Female">Female</option>
                            <option value="Male">Male</option>
                            {{-- <option value="Others">Others</option> --}}
                        </select>
                    </div>
                </div>

                {{-- Physical info --}}
                <div class="row g-2 m-2">
                    <div class="col-md">
                        <label for="height" class="form-label"><span class="ra"><span
                                    class="ra">*</span></span>
                            Height</label>
                        <input type="number" class="form-control" onkeyup="cal_bmi()" name="height" id="height"
                            value="" required>
                    </div>
                    <div class="col-md">
                        <label for="weight" class="form-label"><span class="ra"><span
                                    class="ra">*</span></span>
                            Weight</label>
                        <input type="number" class="form-control" onkeyup="cal_bmi()" name="weight" id="weight"
                            value="" autocomplete="true" required>
                    </div>
                    <div class="col-md">
                        <label for="BMI" class="form-label">BMI <span id="bmi_cat"></span></label>
                        <input type="number" class="form-control" placeholder="" name="BMI" id="BMI"
                            value="" readonly>
                    </div>
                </div>

                <div class="row g-2 m-2">
                    <div class="col-md col-12">
                        <label for="birth_place" class="form-label"><span class="ra">*</span> Place of Birth</label>
                        <input type="text" class="form-control" placeholder="BRGY. MACALIPAY PASTRANA LEYTE"
                            name="birth_place" id="birth_place" value="{{ $test_value }}" required>
                    </div>
                    <div class="col">
                        <label for="religion" class="form-label"><span class="ra">*</span> Religion</label>
                        <input type="text" class="form-control" placeholder="CATHOLIC" name="religion"
                            id="religion" value="" required>
                    </div>
                </div>

                <div class="row g-2 m-2">
                    <div class="col-md-6">
                        <label for="contact_number" class="form-label"><span class="ra">*</span> Contact No.</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">63+</span>
                            <input type="tel" class="form-control" placeholder="09XXXXXXXX" pattern="[0-9]{10}"
                                aria-label="contact_number" name="contact_number" id="contact_number" value=""
                                aria-describedby="basic-addon1" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="citizenship" class="form-label"><span class="ra">*</span> Citizenship</label>
                        <input type="text" class="form-control" placeholder="FILIPINO" name="citizenship"
                            id="citizenship" value="FILIPINO" required>
                    </div>
                    <div class="col-4">
                        <label for="barangay" class="form-label"><span class="ra">*</span> Barangay</label>
                        <input type="text" class="form-control" placeholder="Brgy." name="barangay"
                            list="barangay_list" id="barangay" value="" required>
                        <datalist id="barangay_list">
                            {{-- list of barangays --}}
                            @foreach ($barangays as $brgy)
                                <option value="{{ $brgy->barangay }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div class="col-8">
                        <label for="address" class="form-label"><span class="ra">*</span> Address</label>
                        <input type="text" class="form-control" placeholder="Address" name="address" id="address"
                            value="{{ $test_value }}" autocomplete="true" required>
                    </div>
                </div>
            </div>
            <div class="col-md-4 p-0">
                <div class="row g-2 m-2">
                    <div class="col-12">
                        <h3>Patient Case</h3>
                    </div>
                    <div class="col-12">
                        <label for="diagnosis_number" class="form-label">Diagnosis Number</label>
                        <input type="text" class="form-control" placeholder="" name="diagnosis_number"
                            id="diagnosis_number" value="{{ $diagnosis_no }}" readonly required>
                    </div>
                    <div class="col-12">
                        <label for="diagnosis" class="form-label"><span class="ra">*</span> Diagnosis</label>
                        <input type="text" class="form-control" placeholder="Example" name="diagnosis"
                            id="diagnosis" value="{{ $test_value }}" required>
                    </div>
                    <div class="col-12">
                        <label for="treatment" class="form-label"><span class="ra">*</span> Treatment</label>
                        <input type="text" class="form-control" placeholder="Example" name="treatment"
                            id="treatment" value="{{ $test_value }}" required>
                    </div>
                    <div class="col-12">
                        <label for="admit_date" class="form-label">Date</label>
                        <input type="date" class="form-control" name="admit_date" id="admit_date"
                            value="{{ $date_today }}">
                    </div>
                    <div class="col-12">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea class="form-control" name="remarks" id="remarks" rows="3"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <hr class="mb-4">

        <div class="row justify-content-center">
            <div class="col-auto">
                <button class="btn btn-lg btn-primary rounded-3" type="submit">
                    Add New Patient
                </button>
            </div>
        </div>
    </form>

    {{-- calculate age --}}
    <script>
        b_date = document.getElementById('birth_date');
        age_input = document.getElementById('age');
        age_output = document.getElementById('age_mean');

        function set_age() {
            // get the age by subtracting years then inputing it in the age value
            const d = new Date(b_date.value);
            const d_now = new Date();
            let year = d.getFullYear();
            let y_now = d_now.getFullYear();
            console.log(d_now.getDate() - d.getDate());
            let age = (y_now - year);
            age_input.value = age;

            if (age <= 1) {
                age_output.innerHTML = "(It's a Baby)";
            } else {
                age_output.innerHTML = "";
            }
        }
    </script>

    {{-- calculate BMI body mas index --}}
    <script>
        const height_input = document.getElementById('height');
        const weight_input = document.getElementById('weight');
        const bmi_output = document.getElementById('BMI');
        const bmi_cat_output = document.getElementById('bmi_cat');

        function cal_bmi() {
            var h_m = height_input.value / 100;
            var h_s = (h_m * h_m);
            var bmi = (weight_input.value / h_s);
            bmi_output.value = bmi.toFixed(2);

            // give bmi category
            var bmi_category = '';
            if (bmi <= 18.5) {
                bmi_category = '<span class="badge text-bg-secondary">Underweight</span>';
            }
            if ((bmi >= 30)) {
                bmi_category = '<span class="badge text-bg-danger">Obesity</span>';
            }
            if ((bmi >= 18.6) && (bmi <= 24.9)) {
                bmi_category = '<span class="badge text-bg-primary">Normal weight</span>';
            }
            if ((bmi >= 25) && (bmi <= 29.9)) {
                bmi_category = '<span class="badge text-bg-warning">Overweight</span>';
            }

            bmi_cat_output.innerHTML = bmi_category;
        }
    </script>

    <script type="module">
        // $('#time_arrival').on('change', function() {
        //     var $value = $(this).val();
        //     window.alert($value);
        // });
    </script>

    {{-- primary message when we add new data --}}
    {{-- @if ($message = Session::get('patient_id'))
        opens new page script
        <script>
            window.location.href = "{{ route('patientPDFDownload', $message) }}";
        </script>
    @endif --}}
@endsection
