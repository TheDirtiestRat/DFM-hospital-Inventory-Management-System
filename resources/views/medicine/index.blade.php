@extends('layouts.app')

@section('content')
    <h1 class="text-center">Medicine Records List</h1>
    <hr>

    {{-- alert --}}
    @include('components.alert')

    {{-- search bar --}}
    <div class="row gap-2 m-0">
        <div class="col p-0">
            <input type="search" class="form-control" id="searchbar" name="searchbar" placeholder="Search medicine...">
        </div>
        <div class="col-auto p-0">
            <button class="btn btn-primary" id="searchBtn">Search</button>
        </div>
        <div class="col-12 p-0">
            {{-- tag list --}}
            <div class="row gap-2 m-0">
                <div class="col-auto p-0">
                    <a href="{{ route('medicine.create') }}" class="btn btn-primary rounded-3">
                        Add New Medicine
                    </a>
                </div>
                <div class="col-auto p-0">
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
                </div>

                <div class="col-auto p-0">
                    <!-- Split dropup button -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-primary">Expirations</button>
                        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('getMedicineList') }}?key=get_not_expired">Not
                                    Expired</a></li>
                            <li><a class="dropdown-item" href="{{ url('getMedicineList') }}?key=get_expired">Expired</a>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- sort by batch --}}
                <div class="col-auto p-0">
                    <!-- Split dropup button -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-primary">By Batch</button>
                        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            @forelse ($batches as $batch)
                                <li><a class="dropdown-item" href="{{ url('getMedicineList') }}?key=get_by_batch&batch={{ $batch->batch_no }}">batch {{ $batch->batch_no }} - total ({{ $batch->total }})</a></li>
                            @empty
                                <li>Empty yet ;D</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div class="col-md p-0">
                    {{-- <a href="{{ url('medicineList') }}" class="text-decoration-none float-md-end" target="_blank">
                        <button class="btn btn-primary rounded-3">Print list as PDF</button>
                    </a> --}}

                    <div class="dropdown float-md-end">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Export
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ url('medicineList') }}" class="dropdown-item" target="_blank">
                                    As PDF
                                </a>
                            </li>
                            <li><a href="{{ url('exportData') }}" class="dropdown-item" target="_blank">
                                    As CSV
                                </a></li>
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
                <a class="nav-link nv-ls-s active" onclick="show_list_style(event, 'card')" href="#" id="show_card">
                    <i class="bi bi-card-list"></i> Card
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link nv-ls-s" onclick="show_list_style(event, 'table')" href="#" id="show_table"><i
                        class="bi bi-table"></i> Table</a>
            </li>
        </ul>

        {{-- list of Medicine --}}

        <div class="table-responsive" id="Medicine_list_area">
            {{-- get Medicine list --}}
            <div class="tabcontent" id="card">
                @include('components.medicineCardList')
            </div>
            <div class="tabcontent" id="table" style="display: none">
                @include('components.medicineTableList')
            </div>
        </div>
    </div>

    {{-- pagination --}}
    <div class="row m-0 text-bg-primary rounded-4 p-3">
        {{ $medicines->links('vendor.pagination.bootstrap-5') }}
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
                    {{-- <div class="row">
                        <div class="col-12">
                            <h3>Medicine Information</h3>
                            <hr>
                        </div>
                        <div class="col-md-6">
                            <p>
                                <strong>Name : </strong>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Quantity :</strong> </p>
                        </div>
                        <div class="col-md-12">
                            <p><strong>Expiration Date :</strong> </p>
                        </div>
                    </div> --}}
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
                success: function(data) {
                    // $('#Medicine_list_area').html(data);
                    $('#card').html(data);
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
    {{-- show list style card or table --}}
    <script>
        // const table_elem = document.getElementById('table');
        // table_elem.style.display = "none";

        function show_list_style(evt, listStyle) {
            // elements
            // const card_elem = document.getElementById('show_card');

            // Declare all variables
            var i, tabcontent, tablinks;

            // Get all elements with class="tabcontent" and hide them
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Get all elements with class="tablinks" and remove the class "active"
            tablinks = document.getElementsByClassName("nv-ls-s");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            // Show the current tab, and add an "active" class to the button that opened the tab
            document.getElementById(listStyle).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>
@endsection
