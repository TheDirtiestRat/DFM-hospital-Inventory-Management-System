@extends('layouts.app')

@section('content')
    <h1 class="text-center">Doctor Details</h1>
    <h2>{{ $doctor->full_name }}</h2>
    <p>LICENSE NO. {{ $doctor->license_no }}</p>
    <hr>

    {{-- alert --}}
    @include('components.alert')

    <h2>Patients Despensed</h2>
    <hr>
    {{-- list of patients despensed by this doctor --}}
    @forelse ($despensed_medicines as $des)
        <div class="row g-3 d-flex align-items-center mb-2">
            <div class="col-md-auto">
                <button class="btn btn-outline-primary">
                    {{ $des->case_no }}
                </button>
            </div>
            <div class="col-md-auto">
                <a href="{{ route('patient.show', $des->p_id) }}" class="btn btn-primary w">{{ $des->first_name }} {{ $des->mid_name }}
                    {{ $des->last_name }}</a>
            </div>
            <div class="col">
                <hr>
            </div>
            <div class="col-md-auto">
                {{ $des->name }}
            </div>
            <div class="col-md-auto">
                <button class="btn btn-secondary">{{ $des->dm_q }}</button>
            </div>
        </div>
    @empty
        <div class="text-center text-muted">
            <h1>No Patients Yet</h1>
        </div>
    @endforelse
@endsection
