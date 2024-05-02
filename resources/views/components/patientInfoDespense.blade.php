@if (!empty($patient))
    <div class="text-bg-primary rounded-3 p-3">
        {{-- patient information --}}
        <div class="row g-2">
            <div class="col-12">
                <p class="m-0">
                    <strong>Name: </strong>{{ $patient->first_name . ' ' . $patient->mid_name . ' ' . $patient->last_name }}
                </p>
            </div>
            <div class="col-12">
                <p class="m-0">
                    <strong>Gender: </strong>{{ $patient->gender }}
                </p>
            </div>
            <div class="col-12">
                <p class="m-0">
                    <strong>Age: </strong>{{ $patient->age }}
                </p>
            </div>
            <div class="col-12">
                <p class="m-0">
                    <strong>Blood Type: </strong>{{ $patient->blood_type }}
                </p>
            </div>
            {{-- <div class="col-auto">
                {{ $patient->first_name . ' ' . $patient->mid_name . ' ' . $patient->last_name }}
            </div> --}}
            <div class="col-12">
                <p class="m-0">
                    <strong>Diagnosis: </strong>{{ $patient->diagnosis }}
                </p>
                {{-- diagnosis no --}}
                <input type="text" class=" visually-hidden" name="diagnosis" value="{{ $patient->diagnosis_no }}" id="diagnosis" readonly>
            </div>
            {{-- <div class="col-4">
                {{ $patient->diagnosis }}
            </div> --}}
        </div>
    </div>
@else
    <div class="text-bg-primary rounded-3 p-3">
        {{-- patient information --}}
        <div class="row g-2">
            <div class="col">
                <p class="m-0 text-center ">
                    <strong>No patient exist with that.</strong>
                </p>
            </div>
        </div>
    </div>
@endif
