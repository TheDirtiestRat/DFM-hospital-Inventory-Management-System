@extends('layouts.app')

@section('link')
    @vite(['resources/js/pieChart.js'])
    @vite(['resources/js/lineChart.js'])
@endsection

@section('content')
    <h1 class="text-center">Reports</h1>
    <hr>

    {{-- charts --}}
    <div class="row gap-2 m-0">
        <div class="col-12">
            <h2>Charts</h2>
        </div>
        <div class="col-md-4 col-12">
            <canvas width="100%" height="100%" id="pieChart"></canvas>
        </div>
        <div class="col-md col-12">
            <canvas id="lineChart"></canvas>
        </div>
        <div class="col-12">
            <hr>
        </div>
    </div>

    {{-- overview --}}
    <div class="row gap-2 m-0">
        {{-- total patient --}}
        <div class="col-12">
            <h2>Overview</h2>
        </div>

        <div class="col-md col-12">
            <div class="row gap-2 m-0">
                <div class="col-md p-0">
                    <div class="card rounded-4">
                        <div class="row g-0">
                            <div
                                class="col-md-4 bg-primary rounded-start-4 d-flex justify-content-center align-items-center">
                                <i class="bi bi-database text-light m-0" style="font-size: 3rem"></i>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <p class="m-0">Total Patients</p>
                                    <h1 class="m-0">{{ $total_patients }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- total request --}}
                <div class="col-md p-0">
                    <div class="card rounded-4">
                        <div class="row g-0">
                            <div
                                class="col-md-4 bg-primary rounded-start-4 d-flex justify-content-center align-items-center">
                                <i class="bi bi-envelope text-light m-0" style="font-size: 3rem"></i>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <p class="m-0">Total Despensed</p>
                                    <h1 class="m-0">{{ $total_despensed }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- total users --}}
                <div class="col-md p-0">
                    <div class="card rounded-4">
                        <div class="row g-0">
                            <div
                                class="col-md-4 bg-primary rounded-start-4 d-flex justify-content-center align-items-center">
                                <i class="bi bi-table text-light m-0" style="font-size: 3rem"></i>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <p class="m-0">Total Medicine</p>
                                    <h1 class="m-0">{{ $total_medicine }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md p-0">
                    <div class="card rounded-4">
                        <div class="row g-0">
                            <div
                                class="col-md-4 bg-primary rounded-start-4 d-flex justify-content-center align-items-center">
                                <i class="bi bi-person text-light m-0" style="font-size: 3rem"></i>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <p class="m-0">Total Users</p>
                                    <h1 class="m-0">{{ $total_users }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <hr>
        </div>
    </div>

    {{-- chart data insert --}}
    <script>
        const pie_label = 'Sex';
        const pie_data = [
            // get patient by genders
            @foreach ($total_by_gender as $genderT)
                {
                    type: '{{ $genderT->gender }}',
                    total: {{ $genderT->total }}
                },
            @endforeach
        ];

        const line_label = 'Despensed Medicine';
        const line_data = [
            @foreach ($total_despense_meds as $despense)
            {
                label: '{{ $despense->day }}',
                value: {{ $despense->total }},
            },
            @endforeach
        ];
    </script>
@endsection
