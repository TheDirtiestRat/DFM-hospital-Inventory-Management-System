@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
        <div>
            <h1 class="mb-1">Prepare Patient Certificate</h1>
            <p class="text-muted mb-0">
                {{ $patient->first_name }} {{ $patient->mid_name }} {{ $patient->last_name }}
                · Case {{ $patient->case_no }}
            </p>
        </div>
        <a href="{{ route('certificates.index', ['search' => $patient->case_no]) }}" class="btn btn-outline-secondary">
            Back to patients
        </a>
    </div>

    @include('components.alert')

    <form action="{{ route('certificates.print', $patient) }}" method="post" target="_blank"
        class="card shadow-sm" id="certificateForm">
        @csrf
        <div class="card-body">
            <div class="mb-3">
                <label for="certificateType" class="form-label">Certificate type</label>
                <select class="form-select @error('type') is-invalid @enderror" id="certificateType" name="type" required>
                    <option value="" disabled @selected(old('type', '') === '')>Select a certificate</option>
                    <option value="medical" @selected(old('type') === 'medical')>Medical Certificate</option>
                    <option value="death" @selected(old('type') === 'death')>Death Certificate (draft)</option>
                </select>
                @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <fieldset id="medicalFields" class="border rounded-3 p-3 mb-3">
                <legend class="float-none w-auto px-2 fs-6">Medical certificate</legend>
                <div class="alert alert-info py-2">
                    The latest recorded diagnosis will be included. Verify the certificate before signing.
                </div>
                <label for="medicalPurpose" class="form-label">Purpose of certificate</label>
                <textarea class="form-control @error('purpose') is-invalid @enderror" id="medicalPurpose" name="purpose"
                    rows="3" maxlength="500" placeholder="Enter the purpose for issuing this certificate">{{ old('purpose') }}</textarea>
                @error('purpose')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </fieldset>

            <fieldset id="deathFields" class="border rounded-3 p-3">
                <legend class="float-none w-auto px-2 fs-6">Death certificate (draft)</legend>
                <div class="alert alert-warning py-2">
                    The PDF is a draft for licensed-physician review, not an official government death certificate.
                    These details are used for this print only and are not saved to the patient record.
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="deathDate" class="form-label">Date of death</label>
                        <input class="form-control @error('death_date') is-invalid @enderror" type="date" id="deathDate"
                            name="death_date" max="{{ now()->toDateString() }}" value="{{ old('death_date') }}">
                        @error('death_date')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="deathTime" class="form-label">Time of death</label>
                        <input class="form-control @error('death_time') is-invalid @enderror" type="time" id="deathTime"
                            name="death_time" value="{{ old('death_time') }}">
                        @error('death_time')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="deathPlace" class="form-label">Place of death</label>
                        <input class="form-control @error('death_place') is-invalid @enderror" type="text" id="deathPlace"
                            name="death_place" maxlength="255" value="{{ old('death_place') }}">
                        @error('death_place')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="causeOfDeath" class="form-label">Reported cause of death</label>
                        <textarea class="form-control @error('cause_of_death') is-invalid @enderror" id="causeOfDeath"
                            name="cause_of_death" rows="3" maxlength="500">{{ old('cause_of_death') }}</textarea>
                        @error('cause_of_death')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="certifierName" class="form-label">Certifying physician</label>
                        <input class="form-control @error('certifier_name') is-invalid @enderror" type="text"
                            id="certifierName" name="certifier_name" maxlength="255" value="{{ old('certifier_name') }}">
                        @error('certifier_name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="certifierLicense" class="form-label">Professional license number</label>
                        <input class="form-control @error('certifier_license') is-invalid @enderror" type="text"
                            id="certifierLicense" name="certifier_license" maxlength="100"
                            value="{{ old('certifier_license') }}">
                        @error('certifier_license')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="card-footer d-flex justify-content-end gap-2">
            <a href="{{ route('certificates.index', ['search' => $patient->case_no]) }}"
                class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-printer"></i> Generate PDF
            </button>
        </div>
    </form>

    <script>
        const certificateType = document.getElementById('certificateType');
        const medicalFields = document.getElementById('medicalFields');
        const deathFields = document.getElementById('deathFields');
        const certificateForm = document.getElementById('certificateForm');

        function updateCertificateFields() {
            const isMedical = certificateType.value === 'medical';
            const isDeath = certificateType.value === 'death';

            medicalFields.disabled = !isMedical;
            deathFields.disabled = !isDeath;
            medicalFields.classList.toggle('d-none', !isMedical);
            deathFields.classList.toggle('d-none', !isDeath);

            certificateForm.querySelectorAll('[data-certificate-required]').forEach(input => {
                input.required = input.closest('fieldset') === (isMedical ? medicalFields : deathFields);
            });
        }

        medicalFields.querySelectorAll('textarea').forEach(input => input.dataset.certificateRequired = 'true');
        deathFields.querySelectorAll('input, textarea').forEach(input => input.dataset.certificateRequired = 'true');
        certificateType.addEventListener('change', updateCertificateFields);
        updateCertificateFields();
    </script>
@endsection
