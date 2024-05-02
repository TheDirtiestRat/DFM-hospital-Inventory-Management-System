@extends('layouts.app')

@section('link')
    @vite(['resources/js/pieChart.js'])
@endsection

@section('content')
    <h1 class="text-center">Dashboard</h1>
    <hr>

    {{-- overview --}}
    <div class="row gap-2 m-0">
        {{-- total patient --}}
        <div class="col p-0 ">
            <h2>Daily Overview</h2>
        </div>
        <div class="col p-0 text-end">
            <p class=""><strong>Date : </strong> {{ date('m-d-Y') }}</p>
        </div>

        <div class="col-12 p-0 ">
            <div class="row gap-0 m-0">
                <div class="col-md-8 p-2">
                    <div class="row gap-0 m-0 h-100 ">
                        <div class="col-md p-2">
                            <div class="card rounded-4 h-100">
                                <div class="row g-0 h-100">
                                    <div
                                        class="col-4 bg-primary rounded-start-4 d-flex justify-content-center align-items-center">
                                        <i class="bi  bi-capsule  text-light m-0" style="font-size: 3.5rem"></i>
                                    </div>
                                    <div class="col-8">
                                        <div class="card-body h-100 d-flex align-items-center">
                                            <div>
                                                <p class="m-0">Total Medicine</p>
                                                <h1 class="m-0">{{ $total_medicine }}</h1>
                                                <p class="card-text m-0"><small class="text-muted">Quantity :
                                                        {{ $total_quantity }}</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="card m-0 rounded-4 shadow text-center h-100 ">
                                <div class="card-body d-flex align-items-center justify-content-center h-100 ">
                                    <div>
                                        <p class="card-text m-1 ">Total Medicines</p>
                                        <h1 class="display-3 m-0">{{ $total_medicine }}</h1>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        <div class="col-md p-2">
                            <div class="card rounded-4 h-100">
                                <div class="row g-0 h-100">
                                    <div
                                        class="col-4 bg-primary rounded-start-4 d-flex justify-content-center align-items-center">
                                        <i class="bi  bi-capsule  text-light m-0" style="font-size: 3.5rem"></i>
                                    </div>
                                    <div class="col-8">
                                        <div class="card-body h-100 d-flex align-items-center">
                                            <div>
                                                <p class="m-0">Total Despensed</p>
                                                <h1 class="m-0">{{ $total_despensed }}</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="card m-0 rounded-4 shadow text-center h-100 ">
                                <div class="card-body d-flex align-items-center justify-content-center h-100 ">
                                    <div>
                                        <p class="card-text m-1 ">Total Despensed</p>
                                        <h1 class="display-3 m-0">{{ $total_despensed }}</h1>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        <div class="col-12 p-2 pb-0 ">
                            <div class="card rounded-4 h-100">
                                <div class="row g-0 h-100">
                                    <div
                                        class="col-4 bg-primary rounded-start-4 d-flex justify-content-center align-items-center">
                                        <i class="bi  bi-capsule  text-light m-0" style="font-size: 3.5rem"></i>
                                    </div>
                                    <div class="col-8">
                                        <div class="card-body h-100 d-flex align-items-center">
                                            <div>
                                                <p class="m-0">Total Quantity</p>
                                                <h1 class="m-0">{{ $total_quantity }}</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="card m-0 rounded-4 h-100 ">
                                <div class="row g-0 h-100 ">
                                    <div
                                        class="col-md-4 bg-primary rounded-start-4 d-flex justify-content-center align-items-center">
                                        <i class="bi bi-database text-light m-0" style="font-size: 2rem"></i>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <p class="card-text m-1 ">Total Quantity</p>
                                            <h1 class="display-3 m-0">{{ $total_quantity }}</h1>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-4 p-2">
                    <div class="card m-0 rounded-4 shadow text-center h-100 ">
                        <div class="card-body d-flex align-items-center justify-content-center h-100">
                            {{-- pie chart --}}
                            <canvas width="100%" height="100%" id="pieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 p-0 ">
            <div class="row gap-2 m-0">
                <div class="col-12 p-0">
                    <h5 class="">Top Medicines Despensed</h5>
                </div>

                {{-- medicine list --}}
                <div class="row g-2">
                    @forelse ($medicines as $medicine)
                        {{-- card --}}
                        <div class="col-md-3 ">
                            <div class="card">
                                <div class="card-header">
                                    @php
                                        // shows when the quantity is low
                                        $class = '';
                                        $tooltip = 'Normal Quantity';
                                        $style = '';

                                        if ($medicine->quantity <= 15) {
                                            $class = 'text-bg-danger rounded-3';
                                            $tooltip = 'Low Quantity of Items Needs to replenish';
                                            $style = ' fw-bold text-danger ';
                                        } elseif ($medicine->quantity <= 50) {
                                            $class = 'text-bg-warning rounded-3';
                                            $tooltip = 'Quantity of Items Almost Low';
                                        }
                                    @endphp
                                    <div class="text-center {{ $class }}" data-bs-toggle="tooltip"
                                        data-bs-title="{{ $tooltip }}">
                                        Id<strong>: {{ $medicine->medicine_id }}</strong></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row gap-1 m-0">
                                        <div class="col-10 p-0">
                                            <h5 class="card-title text-truncate m-0 ">{{ $medicine->name }}</h5>
                                            <p class="card-text m-0 ">Remaining : {{ $medicine->quantity }}</p>
                                            <p class="card-text m-0"><small class="text-muted">Updated:
                                                    {{ $medicine->updated_at }}</small></p>
                                        </div>
                                        <div class="col-auto p-0 d-flex flex-column gap-2 ">
                                            {{-- buttons --}}
                                            <form>
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-primary btn_pnt{{ $medicine->id }}"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModal" id="click_btn"
                                                    value="{{ $medicine->id }}">
                                                    <i class="bi bi-person-lines-fill"></i>
                                                </button>
                                            </form>
                                            <a href="{{ route('medicine.edit', $medicine->id) }}"
                                                class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                                data-bs-title="Update Details">
                                                <i class="bi bi-file-earmark-text-fill"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- if no Medicine --}}
                        <div class="col-12 text-center text-muted">
                            <h1 class="m-0">No Medicine Listed With that info</h1>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-12">
            <hr>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-bg-primary">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Medicine Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal_show_medicine_details">
                    <div class="row">
                        <div class="col-12">
                            <h3>Medicine Information</h3>
                            <hr>
                        </div>
                        <div class="col-md-6">
                            <p>
                                <strong>Name : </strong>
                                Full name of the medicine
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Quantity :</strong> 99</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- script tooltip --}}
    <script type="module">
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    </script>
    {{-- search ajax script --}}
    <script type="module">
        // call from start
        get_btn_list()

        $('#searchbar').on('keyup', function() {
            var $value = $(this).val();
            // console.log($value)
            search_medicine($value);
        });

        // ajax search function
        function search_medicine(key) {
            var $search_key = key
            // console.log($search_key)
            $.ajax({
                url: "{{ url('search_medicine') }}",
                type: "GET",
                data: {
                    'key': $search_key
                },
                primary: function(data) {
                    $('#Medicine_list_area').html(data);
                    get_btn_list();
                }
            })
        }

        // ajax for getting medicine info
        function get_btn_list() {
            var $btn_list = document.querySelectorAll('#click_btn');
            // console.log($btn_list);
            for (var i = 0; i < $btn_list.length; i++) {
                var id = $btn_list[i].value;

                $('.btn_pnt' + id).on('click', function() {
                    // console.log(this.value);
                    get_medicine_details(this.value);
                });
            }
        };

        // ajax data GET
        function get_medicine_details(id) {
            var $medicine_id = id
            $.ajax({
                url: "{{ url('medicine_details') }}",
                type: "GET",
                data: {
                    'id': $medicine_id
                },
                primary: function(data) {
                    $('#modal_show_medicine_details').html(data);
                }
            })
        };
    </script>
    {{-- chart data insert --}}
    <script>
        const pie_label = "Quantity Status";
        const pie_data = [{
                type: 'Good',
                total: {{ $good_stock }}
            },
            {
                type: 'Low Storage',
                total: {{ $low_stock }}
            },
            {
                type: 'Out of Stock',
                total: {{ $out_of_stock }}
            },
        ];
    </script>
@endsection
