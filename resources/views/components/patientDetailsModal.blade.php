{{-- imported data --}}
@php
    $patient_id = $patient->id;
@endphp

<div class="row">
    <div class="col-12">
        <h3>Personal Information Case Id : ({{  $patient->case_no }})</h3>
    </div>
    <div class="col-md-6">
        <p>
            <strong>Name : </strong>
            {{ $patient->first_name }} {{ $patient->mid_name }} {{ $patient->last_name }}
        </p>
    </div>
    <div class="col-md-6">
        <p><strong>Age :</strong>  {{ $patient->age }}</p>
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
        <hr>
    </div>
    <div class="col-12">
        <p><strong>Place of Birth :</strong> {{ $patient->birth_place }}</p>
    </div>
    <div class="col-md-6">
        <p><strong>Contact No. :</strong> {{ $patient->contact_no }}</p>
    </div>
    <div class="col-md-6">
        <p><strong>Citizenship :</strong> {{ $patient->citizenship }}</p>
    </div>
    <div class="col-md-4">
        <p><strong>Barangay :</strong> {{ $patient->barangay }}</p>
    </div>
    <div class="col-md-8">
        <p><strong>Address :</strong> {{ $patient->address }}</p>
    </div>
</div>
{{-- <div class="modal-footer">
    <div class="row">
        <div class="col-auto">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        <div class="col-auto">
            <a href="{{ route('patient.show', $patient->id) }}" class="text-decoration-none">
                <button type="button" class="btn btn-outline-success">Details</button>
            </a>
            <a href="{{ route('patient.edit', $patient->id) }}" class="text-decoration-none float-md-end">
                <button type="button" class="btn btn-success">Update Records</button>
            </a>
        </div>
    </div>
</div> --}}
