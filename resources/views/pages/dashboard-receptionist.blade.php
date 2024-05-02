@extends('layouts.app')

@section('link')
    @vite(['resources/js/pieChart.js'])
    @vite(['resources/js/barChart.js'])
@endsection

@section('content')
    <h1 class="text-center">Dashboard</h1>
    <hr>

    {{-- overview --}}
    <div class="row gap-2 m-0">
        {{-- total patient --}}
        {{-- <div class="col-4 p-0 d-flex w-100">
            <h5 class="m-0">Overview</h5>
            <p class="m-0 float-end"><strong>Date : </strong> {{ date('m-d-Y') }}</p>
        </div>
        <div class="col-8 p-0">
            <h5 class="m-0">Diagnosis</h5>
        </div> --}}

        <div class="col-12 p-0 ">
            <div class="row gap-3 m-0">
                <div class="col-md-4 p-0">
                    <h5 class="m-1">Overview</h5>
                    {{-- <h4 class="">Overview</h4> --}}
                    <div class="card rounded-4">
                        <div class="row g-0">
                            <div class="col-4 bg-primary rounded-start-4 d-flex justify-content-center align-items-center">
                                <i class="bi bi-database text-light m-0" style="font-size: 3.5rem"></i>
                            </div>
                            <div class="col-8">
                                <div class="card-body h-100 d-flex align-items-center">
                                    <div>
                                        <p class="m-0">Total Patients</p>
                                        <h1 class="m-0">{{ $total_patients }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="card rounded-4 text-center mb-3">
                        <div class="card-body d-flex align-items-center justify-content-center ">
                            <div>
                                <p class="card-text m-2 ">Total Patients</p>
                                <h1 class="display-1 ">{{ $total_patients }}</h1>
                            </div>
                        </div>
                    </div> --}}
                </div>
                {{-- total users --}}
                <div class="col p-0 ">
                    <h5 class="m-1">Diagnosis</h5>
                    {{-- <h4 class="">Top Diagnosis</h4> --}}
                    <div class="row g-1 overflow-x-auto ">
                        @forelse ($total_by_diagnosis as $diagnosis)
                            <div class="col-md-4">
                                <button class="btn btn-primary rounded-3 w-100" style="height: 4rem">
                                    <div class="row align-items-center ">
                                        <div class="col-8">
                                            {{ $diagnosis->diagnosis }}
                                        </div>
                                        <div class="col">
                                            <h5 class="m-0">{{ $diagnosis->total }}</h5>
                                        </div>
                                    </div>
                                </button>
                            </div>
                        @empty
                            <div class="col-12 p-1 ">
                                <button class="btn btn-secondary rounded-3 w-100" style="height: 4rem">
                                    No Diagnosis listed
                                </button>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <hr>
        </div>

        <div class="col-12 p-0 ">
            <div class="row g-2">
                <div class="col-md-4">
                    <div class="card rounded-4 text-center h-100">
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <div class="w-100">
                                <h4 class="m-0">Total By Sex</h4>
                                <canvas height="" width="100%" id="pieChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md h-100 ">
                    <div class="card rounded-4 text-center mb-1 h-100 ">
                        <div class="card-body ">
                            <canvas height="" id="barChart"></canvas>
                        </div>
                    </div>
                </div>
                {{-- total users --}}
                <div class="col-12 p-0">
                    <h4 class="">New Patients</h4>
                    <div class="row g-2">
                        {{-- list of new patients --}}
                        @forelse ($patients as $patient)
                            {{-- card --}}
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="text-center">
                                            MRN<strong>: {{ $patient->case_no }}</strong>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row gap-1 m-0">
                                            <div class="col-10 p-0">
                                                <h5 class="card-title text-truncate m-0 ">{{ $patient->first_name }}
                                                    {{ $patient->mid_name }}
                                                    {{ $patient->last_name }}</h5>
                                                <p class="card-text m-0 ">{{ $patient->diagnosis }}</p>
                                                <p class="card-text m-0"><small class="text-muted">Admission Date:
                                                        {{ $patient->created_at }}</small></p>
                                            </div>
                                            <div class="col-auto p-0">
                                                <div class="d-flex flex-column gap-1">
                                                    {{-- buttons --}}
                                                    <a href="{{ route('patient.show', $patient->id) }}"
                                                        class="text-decoration-none" data-bs-toggle="tooltip"
                                                        data-bs-title="Go to Patient Case">
                                                        <button type="button" class="btn btn-sm btn-outline-primary">
                                                            <i class="bi bi-person-lines-fill"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ route('patient.edit', $patient->id) }}"
                                                        class="text-decoration-none" data-bs-toggle="tooltip"
                                                        data-bs-title="Update Patient Case">
                                                        <button type="button" class="btn btn-sm btn-primary">
                                                            <i class="bi bi-person-fill-gear"></i>
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            {{-- if no patients --}}
                            <div class="col-12 text-center text-body-emphasis ">
                                <h1 class="m-0">No Patients Listed With that Name</h1>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- chart data insert --}}
    <script>
        const pie_label = "Sex";
        const pie_data = [
            // get patient by genders
            @foreach ($total_by_gender as $genderT)
                {
                    type: '{{ $genderT->gender }}',
                    total: {{ $genderT->total }}
                },
            @endforeach
        ];

        const bar_label = "Total By Age";
        const bar_data = [{
                type: 'Child',
                count: {{ $child }}
            },
            {
                type: 'Teen',
                count: {{ $teen }}
            },
            {
                type: 'Adult',
                count: {{ $adult }}
            },
            {
                type: 'Señor Citizen',
                count: {{ $old }}
            },
        ];
    </script>
    {{-- script tooltip --}}
    <script type="module">
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    </script>
@endsection
