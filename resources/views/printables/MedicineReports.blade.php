<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Medicine Reports</title>

    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="{{ url('bootstrap-icons/font/bootstrap-icons.css') }}">
</head>

<body>

    {{-- content to print --}}
    <div class="container-fluid">
        <h1 class="text-center">Medicine Reports</h1>
        <hr>

        {{-- overview --}}
        <div class="row gap-2 m-0">
            {{-- total patient --}}
            <div class="col-12 p-0 ">
                <div class="row">
                    <div class="col">
                        <h2>Overview</h2>
                    </div>
                    {{-- <div class="col-auto">
                        <a href="{{ url('medicineReportsPDF') }}" class="text-decoration-none float-end"
                            target="_blank">
                            <button class="btn btn-primary rounded-3"><i class="bi bi-printer"></i> Print</button>
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ url('medicineReportsPDF') }}" class="text-decoration-none float-end"
                            target="_blank">
                            <button class="btn btn-primary rounded-3"><i class="bi bi-printer"></i> Print Report as
                                PDF</button>
                        </a>
                    </div> --}}
                </div>
            </div>

            <div class="col-12 p-0 ">
                <div class="row gap-0 m-0">
                    <div class="col-md-4 p-2">
                        <div class="card rounded-4">
                            <div class="row g-0">
                                <div
                                    class="col-4 bg-primary rounded-start-4 d-flex justify-content-center align-items-center">
                                    <i class="bi bi-database text-light m-0" style="font-size: 3rem"></i>
                                </div>
                                <div class="col-8">
                                    <div class="card-body">
                                        <p class="m-0">Total Medicines</p>
                                        <h1 class="m-0">{{ $total_medicine }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- total request --}}
                    <div class="col-md-4 p-2">
                        <div class="card rounded-4">
                            <div class="row g-0">
                                <div
                                    class="col-4 bg-primary rounded-start-4 d-flex justify-content-center align-items-center">
                                    <i class="bi bi-database-fill text-light m-0" style="font-size: 3rem"></i>
                                </div>
                                <div class="col-8">
                                    <div class="card-body">
                                        <p class="m-0">Total Quantity</p>
                                        <h1 class="m-0">{{ $total_quantity }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- total users --}}
                    <div class="col-md-4 p-2">
                        {{-- card list --}}
                        <div class="card rounded-4">
                            <div class="row g-0">
                                <div
                                    class="col-4 bg-primary rounded-start-4 d-flex justify-content-center align-items-center">
                                    <i class="bi bi-table text-light m-0" style="font-size: 3rem"></i>
                                </div>
                                <div class="col-8">
                                    <div class="card-body">
                                        <p class="m-0">Despensed Meds</p>
                                        <h1 class="m-0">{{ $total_despensed }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-12 p-0">
                <div class="col-12">
                    <h2>Medicine Expirations</h2>
                </div>
            </div>

            <div class="col-12 p-0">
                <div class="row gap-2 m-0">
                    {{-- total Medicine Quantity --}}

                    <div class="col-md p-0">
                        <div class="card rounded-4">
                            <div class="row g-0">
                                <div
                                    class="col-4 bg-primary rounded-start-4 d-flex justify-content-center align-items-center">
                                    <i class="bi bi-capsule text-light m-0" style="font-size: 3rem"></i>
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
                    <div class="col-md p-0">
                        <div class="card rounded-4">
                            <div class="row g-0">
                                <div
                                    class="col-4 bg-warning rounded-start-4 d-flex justify-content-center align-items-center">
                                    <i class="bi bi-capsule text-light m-0" style="font-size: 3rem"></i>
                                </div>
                                <div class="col-8">
                                    <div class="card-body">
                                        <p class="m-0">To Expire (with in 30 days)</p>
                                        <h1 class="m-0">{{ $to_expired }}</h1>
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
                                    class="col-4 bg-danger rounded-start-4 d-flex justify-content-center align-items-center">
                                    <i class="bi bi-capsule text-light m-0" style="font-size: 3rem"></i>
                                </div>
                                <div class="col-8">
                                    <div class="card-body">
                                        <p class="m-0">Expired</p>
                                        <h1 class="m-0">{{ $expired }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 p-0 ">
                <h2>Stocks</h2>
            </div>

            <div class="col-12 p-0 ">
                <div class="row g-2">
                    <div class="col-md-12">
                        {{-- By Sex --}}
                        <div class="card rounded-3 mb-2">
                            <div class="card-header">
                                <h5 class="m-0">Quantity</h5>
                            </div>
                            <div class="card-body rounded-4">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title text-truncate m-0 text-muted">
                                                    Good
                                                </h5>
                                            </div>
                                            <div class="col-auto">
                                                <p class="card-text m-0">{{ $good_stock }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title text-truncate m-0 text-muted">
                                                    Low on Stocks
                                                </h5>
                                            </div>
                                            <div class="col-auto">
                                                <p class="card-text m-0">{{ $low_stock }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title text-truncate m-0 text-muted">
                                                    Out of Stocks
                                                </h5>
                                            </div>
                                            <div class="col-auto">
                                                <p class="card-text m-0">{{ $out_of_stock }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow">
                            <div class="card-header text-bg-warning ">
                                Out of Stocks
                            </div>
                            <div class="card-body">
                                @forelse ($out_of_stock_meds as $med)
                                    <div class="row mb-3 " >
                                        <div class="col">
                                            <h5 class="card-title text-truncate m-0 ">
                                                {{ $med->name }}
                                            </h5>
                                        </div>
                                        <div class="col-auto">
                                            <p class="card-text m-0"><small class="text-muted">Quantity:
                                                    {{ $med->quantity }}</small></p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="row mb-3 ">
                                        <div class="col">
                                            <p class="card-text m-0"><small class="text-muted">No out of stock</small>
                                            </p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card shadow  mb-2">
                            <div class="card-header text-bg-primary ">
                                Despensed Medicine
                            </div>
                            <div class="card-body">
                                @forelse ($despensed_med as $med)
                                    <div class="row mb-3 ">
                                        <div class="col">
                                            <h5 class="card-title text-truncate m-0 ">
                                                {{ $med->medicine }}
                                            </h5>
                                        </div>
                                        <div class="col-auto">
                                            <p class="card-text m-0"><small class="text-muted">Quantity:
                                                    {{ $med->quantity }}</small></p>
                                        </div>
                                        <div class="col-12">
                                            <p class="card-text m-0"><small
                                                    class="text-muted">{{ $med->created_at }}</small>
                                            </p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="row mb-3 ">
                                        <div class="col-auto">
                                            <p class="card-text m-0"><small class="text-muted">No Despensed Medicine
                                                    Yet.</small></p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-12 p-0 ">
                <hr>
            </div>
        </div>
    </div>

    {{-- script to print quickly --}}
    <script>
        window.print();
    </script>
</body>

</html>
