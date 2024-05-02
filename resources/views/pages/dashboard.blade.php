@extends('layouts.app')

@section('link')
    @vite(['resources/js/pieChart.js'])
    @vite(['resources/js/lineChart.js'])
@endsection

@section('content')
    <h1 class="text-center">Dashboard</h1>
    <hr>

    <div class="row g-2">
        <div class="col-12">
            {{-- totals cards --}}
            <div class="row g-1">
                <div class="col-md-3">
                    <div class="card rounded-4 h-100">
                        <div class="row g-0 h-100">
                            <div class="col-4 bg-primary rounded-start-4 d-flex justify-content-center align-items-center">
                                <i class="bi bi-database text-light m-0" style="font-size: 2rem"></i>
                            </div>
                            <div class="col-8">
                                <div class="card-body">
                                    <p class="m-0">Total Patients</p>
                                    <h1 class="m-0">{{ $total_patients }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card rounded-4 h-100">
                        <div class="row g-0 h-100">
                            <div class="col-4 bg-primary rounded-start-4 d-flex justify-content-center align-items-center">
                                <i class="bi bi-person text-light m-0" style="font-size: 2rem"></i>
                            </div>
                            <div class="col-8">
                                <div class="card-body">
                                    <p class="m-0">Total Medicine</p>
                                    <h1 class="m-0">{{ $total_medicine }}</h1>
                                    <p class="card-text m-0"><small class="text-muted">Quantity :
                                            {{ $total_quantity }}</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card rounded-4 h-100">
                        <div class="row g-0 h-100">
                            <div class="col-4 bg-primary rounded-start-4 d-flex justify-content-center align-items-center">
                                <i class="bi bi-capsule text-light m-0" style="font-size: 2rem"></i>
                            </div>
                            <div class="col-8">
                                <div class="card-body">
                                    <p class="m-0">Not Expired</p>
                                    <h1 class="m-0">{{ $not_expired }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card rounded-4 h-100">
                        <div class="row g-0 h-100">
                            <div class="col-4 bg-danger rounded-start-4 d-flex justify-content-center align-items-center">
                                <i class="bi bi-capsule text-light m-0" style="font-size: 2rem"></i>
                            </div>
                            <div class="col-8">
                                <div class="card-body">
                                    <p class="m-0">
                                        <a href="{{ url('getMedicineList') }}?key=get_expired" class=" text-decoration-none text-dark">
                                            Expired
                                        </a>
                                    </p>
                                    <h1 class="m-0">{{ $expired }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card rounded-4 h-100">
                        <div class="row g-0 h-100">
                            <div class="col-4 bg-primary rounded-start-4 d-flex justify-content-center align-items-center">
                                <i class="bi bi-envelope-check text-light m-0" style="font-size: 2rem"></i>
                            </div>
                            <div class="col-8">
                                <div class="card-body">
                                    <p class="m-0">Good Stocks</p>
                                    <h1 class="m-0">{{ $good_stock }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card rounded-4 h-100">
                        <div class="row g-0 h-100">
                            <div class="col-4 bg-warning rounded-start-4 d-flex justify-content-center align-items-center">
                                <i class="bi bi-envelope-exclamation text-light m-0" style="font-size: 3rem"></i>
                            </div>
                            <div class="col-8">
                                <div class="card-body">
                                    <p class="m-0">Low Stocks</p>
                                    <h1 class="m-0">{{ $low_stock }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card rounded-4 h-100">
                        <div class="row g-0 h-100">
                            <div class="col-4 bg-danger rounded-start-4 d-flex justify-content-center align-items-center">
                                <i class="bi bi-envelope-dash text-light m-0" style="font-size: 3rem"></i>
                            </div>
                            <div class="col-8">
                                <div class="card-body">
                                    <p class="m-0">Out of Stocks</p>
                                    <h1 class="m-0">{{ $out_of_stock }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-12">
                    <hr>
                    <h4 class="m-0 text-center">Despensed Medicines</h4>
                    <canvas height="" id="lineChart"></canvas>
                </div> --}}
            </div>
        </div>
        <div class="col-md-8">
            <h4 class="m-0 text-center">Despensed Medicines</h4>
            <canvas height="" id="lineChart"></canvas>
        </div>
        <div class="col-md-4">
            <div class="w-100">
                <h4 class="m-0 text-center">Total By Sex</h4>
                <canvas height="" width="100%" id="pieChart"></canvas>
                <p class="text-center"><strong>Date : </strong> {{ date('m-d-Y') }}</p>
            </div>
        </div>
    </div>

    {{-- charts --}}
    {{-- <div class="row gap-0 m-0">
        <div class="col-12 p-0 ">
            <h2>Charts</h2>
        </div>
        <div class="col-md-4 p-0 ">
            <h4 class="m-0">Total By Sex</h4>
            <canvas width="100%" height="100%" id="pieChart"></canvas>
        </div>
        <div class="col-md-8 p-0 ">
            <canvas height="" id="lineChart"></canvas>
        </div>
        <div class="col-12 p-0 ">
            <hr>
        </div>
    </div> --}}

    {{-- overview --}}
    {{-- <div class="row gap-2 m-0">
        total patient
        <div class="col p-0 ">
            <h2>Total</h2>
        </div>
        <div class="col p-0 text-end">
            <p class=""><strong>Date : </strong> {{ date('m-d-Y') }}</p>
        </div>

        <div class="col-12 p-0 ">
            <div class="row gap-2 m-0">
                <div class="col-md p-0">
                    <div class="card rounded-4 h-100">
                        <div class="row g-0 h-100">
                            <div class="col-4 bg-primary rounded-start-4 d-flex justify-content-center align-items-center">
                                <i class="bi bi-database text-light m-0" style="font-size: 3rem"></i>
                            </div>
                            <div class="col-8">
                                <div class="card-body">
                                    <p class="m-0">Total Patients</p>
                                    <h1 class="m-0">{{ $total_patients }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                total Medicine
                <div class="col-md p-0">
                    <div class="card rounded-4 h-100">
                        <div class="row g-0 h-100">
                            <div class="col-4 bg-primary rounded-start-4 d-flex justify-content-center align-items-center">
                                <i class="bi bi-person text-light m-0" style="font-size: 3rem"></i>
                            </div>
                            <div class="col-8">
                                <div class="card-body">
                                    <p class="m-0">Total Medicine</p>
                                    <h1 class="m-0">{{ $total_medicine }}</h1>
                                    <p class="card-text m-0"><small class="text-muted">Quantity :
                                            {{ $total_quantity }}</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                total request
                <div class="col-md p-0">
                    <div class="card rounded-4 h-100">
                        <div class="row g-0 h-100">
                            <div class="col-4 bg-primary rounded-start-4 d-flex justify-content-center align-items-center">
                                <i class="bi bi-envelope text-light m-0" style="font-size: 3rem"></i>
                            </div>
                            <div class="col-8">
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

    <div class="row gap-2 m-0">
        total Medicine Quantity
        <div class="col-12">
            <h2>Medicine Stock Quantity</h2>
        </div>
        <div class="col-md p-0">
            <div class="card rounded-4 h-100">
                <div class="row g-0 h-100">
                    <div class="col-4 bg-primary rounded-start-4 d-flex justify-content-center align-items-center">
                        <i class="bi bi-envelope-check text-light m-0" style="font-size: 3rem"></i>
                    </div>
                    <div class="col-8">
                        <div class="card-body">
                            <p class="m-0">Good</p>
                            <h1 class="m-0">{{ $good_stock }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        total users
        <div class="col-md p-0">
            <div class="card rounded-4 h-100">
                <div class="row g-0 h-100">
                    <div class="col-4 bg-warning rounded-start-4 d-flex justify-content-center align-items-center">
                        <i class="bi bi-envelope-exclamation text-light m-0" style="font-size: 3rem"></i>
                    </div>
                    <div class="col-8">
                        <div class="card-body">
                            <p class="m-0">Low</p>
                            <h1 class="m-0">{{ $low_stock }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        total request
        <div class="col-md p-0">
            <div class="card rounded-4 h-100">
                <div class="row g-0 h-100">
                    <div class="col-4 bg-danger rounded-start-4 d-flex justify-content-center align-items-center">
                        <i class="bi bi-envelope-dash text-light m-0" style="font-size: 3rem"></i>
                    </div>
                    <div class="col-8">
                        <div class="card-body">
                            <p class="m-0">Out</p>
                            <h1 class="m-0">{{ $out_of_stock }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

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
