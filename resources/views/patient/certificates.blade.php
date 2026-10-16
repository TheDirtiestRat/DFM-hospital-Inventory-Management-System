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
                        <a href="{{ route('certificates.prepare', $patient) }}"
                            class="btn btn-primary mt-auto">
                            <i class="bi bi-printer"></i> Choose certificate
                        </a>
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

@endsection
