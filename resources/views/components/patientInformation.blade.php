{{-- if no patient found with case_no then output --}}
@if (empty($patient['case_no']))
    <div class="col-12">
        <h2 class="text-danger text-center m-0">No Patient exist with that Case Number</h2>
        <hr>
    </div>
@endif
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
    <div class="text-bg-primary rounded-3 p-2 mb-3">
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
