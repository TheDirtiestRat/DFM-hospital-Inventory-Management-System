@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
        <div>
            <h1 class="mb-1">Print Patient Certificates</h1>
            <p class="text-muted mb-0">Find a patient and choose the certificate to prepare.</p>
        </div>
    </div>

    @include('components.alert')

    <form action="{{ route('certificates.index') }}" method="get" class="row g-2 mb-3">
        <div class="col">
            <label for="certificate-patient-search" class="visually-hidden">Search patients</label>
            <input type="search" class="form-control" id="certificate-patient-search" name="search"
                value="{{ $search }}" placeholder="Search by patient name or case number">
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" type="submit">
                <i class="bi bi-search"></i> Search
            </button>
        </div>
        @if ($search !== '')
            <div class="col-auto">
                <a class="btn btn-outline-secondary" href="{{ route('certificates.index') }}">Clear</a>
            </div>
        @endif
    </form>

    <div class="row g-3">
        @forelse ($patients as $patient)
            <div class="col-12 col-md-6 col-xl-4">
                <article class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                            <h2 class="h5 mb-0">{{ $patient->first_name }} {{ $patient->mid_name }} {{ $patient->last_name }}</h2>
                            <span class="badge text-bg-light">Case {{ $patient->case_no }}</span>
                        </div>
                        <p class="mb-1"><strong>Age:</strong> {{ $patient->age }} &middot; {{ $patient->gender }}</p>
                        <p class="text-muted mb-3">
                            <strong>Latest diagnosis:</strong>
                            {{ $patient->latest_diagnosis ?: 'No diagnosis recorded' }}
                        </p>
                        <button type="button" class="btn btn-primary mt-auto certificate-patient-select"
                            data-patient-id="{{ $patient->id }}"
                            data-patient-name="{{ $patient->first_name }} {{ $patient->mid_name }} {{ $patient->last_name }}"
                            data-patient-case="{{ $patient->case_no }}">
                            <i class="bi bi-printer"></i> Choose certificate
                        </button>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-light border text-center mb-0">
                    {{ $search !== '' ? 'No patients match your search.' : 'No patients are available.' }}
                </div>
            </div>
        @endforelse
    </div>

    @if ($patients->hasPages())
        <div class="row mt-3 text-bg-primary rounded-4 p-3">
            {{ $patients->links('vendor.pagination.bootstrap-5') }}
        </div>
    @endif

    <div class="modal fade" id="certificateModal" tabindex="-1" aria-labelledby="certificateModalLabel"
        aria-hidden="true" data-selected-patient-id="{{ $selectedPatientId }}">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form id="certificateForm" method="post" target="_blank"
                data-print-url-template="{{ route('certificates.print', ['patient' => '__PATIENT_ID__']) }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header text-bg-primary">
                        <div>
                            <h2 class="modal-title fs-5" id="certificateModalLabel">Prepare certificate</h2>
                            <p class="small mb-0" id="selectedPatientSummary"></p>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="certificateType" class="form-label">Certificate type</label>
                        <select class="form-select mb-3" id="certificateType" name="type" required>
                            <option value="" selected disabled>Select a certificate</option>
                            <option value="medical">Medical Certificate</option>
                            <option value="death">Death Certificate</option>
                            <option value="" disabled>Other certificates (coming soon)</option>
                        </select>

                        <fieldset class="certificate-fields d-none" data-certificate-type="medical" disabled>
                            <div class="alert alert-info py-2">
                                The latest recorded diagnosis will be included. Verify the certificate before signing.
                            </div>
                            <label for="medicalPurpose" class="form-label">Purpose of certificate</label>
                            <textarea class="form-control" id="medicalPurpose" name="purpose" rows="3" maxlength="500"
                                placeholder="Enter the purpose for issuing this certificate" required></textarea>
                        </fieldset>

                        <fieldset class="certificate-fields d-none" data-certificate-type="death" disabled>
                            <div class="alert alert-warning py-2">
                                These details are used for this print only and are not saved to the patient record.
                                The PDF is a draft for licensed-physician review and is not an official government death certificate.
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="deathDate" class="form-label">Date of death</label>
                                    <input class="form-control" type="date" id="deathDate" name="death_date"
                                        max="{{ now()->toDateString() }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="deathTime" class="form-label">Time of death</label>
                                    <input class="form-control" type="time" id="deathTime" name="death_time" required>
                                </div>
                                <div class="col-12">
                                    <label for="deathPlace" class="form-label">Place of death</label>
                                    <input class="form-control" type="text" id="deathPlace" name="death_place"
                                        maxlength="255" required>
                                </div>
                                <div class="col-12">
                                    <label for="causeOfDeath" class="form-label">Reported cause of death</label>
                                    <textarea class="form-control" id="causeOfDeath" name="cause_of_death" rows="3"
                                        maxlength="500" required></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="certifierName" class="form-label">Certifying physician</label>
                                    <input class="form-control" type="text" id="certifierName" name="certifier_name"
                                        maxlength="255" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="certifierLicense" class="form-label">Professional license number</label>
                                    <input class="form-control" type="text" id="certifierLicense" name="certifier_license"
                                        maxlength="100" required>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="printCertificateButton" disabled>
                            <i class="bi bi-printer"></i> Generate PDF
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
