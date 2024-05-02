@extends('layouts.app')

@section('link')
    @vite(['resources/js/powergrid.js'])
@endsection

@section('content')
    <h1 class="text-center">Medicine Despensed List</h1>
    <hr>

    {{-- alert --}}
    @include('components.alert')

    {{-- search bar --}}
    <div class="row gap-2 m-0">
        {{-- <div class="col p-0">
            <input type="search" class="form-control" id="searchbar" name="searchbar" placeholder="Search medicine...">
        </div>
        <div class="col-auto p-0">
            <button class="btn btn-primary" id="">Search</button>
        </div> --}}
        <div class="col-12 p-0">
            {{-- tag list --}}
            <div class="row gap-2 m-0">
                <div class="col-auto p-0">
                    <a href="{{ url('despenseMedicine') }}" class="btn btn-primary rounded-3">
                        Despensed Medicine
                    </a>
                </div>
                {{-- <div class="col-auto p-0">
                    <!-- Split dropup button -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-primary">Quantity</button>
                        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('search_medicine') }}?key=100">more than 100</a></li>
                            <li><a class="dropdown-item" href="{{ url('search_medicine') }}?key=50">less than 50</a></li>
                            <li><a class="dropdown-item" href="{{ url('search_medicine') }}?key=10">less than 10</a></li>
                        </ul>
                    </div>
                </div> --}}

                <div class="col-md p-0">
                    <div class="dropdown float-md-end">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Export
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ url('despenseList') }}" class="dropdown-item" target="_blank">
                                    As PDF
                                </a>
                            </li>
                            {{-- <li><a href="{{ url('exportData') }}" class="dropdown-item" target="_blank">
                                    As CSV
                                </a></li> --}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="m-3">
        {{-- content nav tab --}}
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link nv-ls-s active" onclick="" href="#" id="show_table"><i class="bi bi-table"></i>
                    Table</a>
            </li>
        </ul>

        {{-- list of Medicine --}}

        <div class="table-responsive pt-3 " id="Medicine_list_area">
            <livewire:despensed-medicine-table/>

            {{-- <div class="tabcontent" id="table">
                <table class="table table-striped table-hover" id="mytable" style="width:100%">
                    <thead class="">
                        <tr>
                            <th scope="col" class="text-center" style="width: 5%">Id</th>
                            <th scope="col" style="width: 20%">Medicine</th>
                            <th scope="col" style="width: 20%">Despenser</th>
                            <th scope="col" style="width: 20">Patient</th>
                            <th scope="col" style="width: 5%">Quantity</th>
                            <th scope="col" class="text-end" style="width: 10">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($despensed_meds as $medicine)
                            <tr>
                                <th>
                                    <div class="text-center">{{ $medicine->medicine_id }}</a>
                                    </div>
                                </th>
                                <td>{{ $medicine->medicine }}</td>
                                <td>{{ $medicine->despenser }}</td>
                                <td></strong> ({{ $medicine->case_no }})
                                    {{ $medicine->first_name }} {{ $medicine->mid_name }} {{ $medicine->last_name }}</td>
                                <td class="text-center">{{ $medicine->quantity }}</td>
                                <td class="text-center">
                                    <small class="text-muted float-end">
                                        {{ $medicine->created_at }}</small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <th colspan="6">No despensed Medicine yet</th>
                            </tr>
                        @endforelse
                    </tbody>
                    <caption>List of Despensed</caption>
                </table>
            </div> --}}
        </div>
    </div>

    {{-- pagination --}}
    <div class="row m-0 text-bg-primary rounded-4 p-3">
        {{ $despensed_meds->links('vendor.pagination.bootstrap-5') }}
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
                success: function(data) {
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
                success: function(data) {
                    $('#modal_show_medicine_details').html(data);
                }
            })
        };
    </script>

    {{-- @livewireStyles
    @powerGridStyles --}}
@endsection
