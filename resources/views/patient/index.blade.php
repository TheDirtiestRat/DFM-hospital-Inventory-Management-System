@extends('layouts.app')

@section('link')
    @vite(['resources/js/powergrid.js'])
@endsection

@section('content')
    <h1 class="text-center">Patients Records List</h1>
    <hr>

    {{-- alert --}}
    @include('components.alert')

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
        {{-- <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#" id="show_table">
                    <i class="bi bi-card-list"></i> Card
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" id="show_card"><i class="bi bi-card-list"></i> Card</a>
            </li>
        </ul> --}}

        {{-- list of patients --}}

        <div class="" id="patients_list_area">
            {{-- get patients list --}}
            {{-- get Medicine list --}}
            <div class="tabcontent pt-3" id="card">
                <div class="row gap-2 m-0">
                    <div class="col p-0">
                        <input type="search" class="form-control" id="searchbar" name="searchbar"
                            placeholder="Search Patient...">
                    </div>
                    <div class="col-auto p-0">
                        <button class="btn btn-primary" id="searchBtn">Search</button>
                    </div>
                    <div class="col-12 p-0">
                        {{-- tag list --}}
                        <div class="row gap-2 m-0">
                            <div class="col-auto p-0">
                                <!-- Split dropup button -->
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-primary">Gender</button>
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ url('search_patient') }}?key=Male">Male</a>
                                        </li>
                                        <li><a class="dropdown-item"
                                                href="{{ url('search_patient') }}?key=Female">Female</a></li>
                                        <li><a class="dropdown-item"
                                                href="{{ url('search_patient') }}?key=Others">Others</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-auto p-0">
                                <!-- Split dropup button -->
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-primary">Citizenship</button>
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        {{-- show only list of citizen have --}}
                                        @forelse ($patients_by_citizenship as $citizenship)
                                            <li><a class="dropdown-item"
                                                    href="{{ url('search_patient') }}?key={{ $citizenship->citizenship }}">{{ $citizenship->citizenship }}</a>
                                            </li>
                                        @empty
                                            <li>No Patients yet</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                            <div class="col-auto p-0">
                                <!-- Split dropup button -->
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-primary">Blood Type</button>
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        {{-- show only list of blood types have --}}
                                        @forelse ($patients_by_bloodTypes as $bloodType)
                                            <li><a class="dropdown-item"
                                                    href="{{ url('search_patient') }}?key={{ $bloodType->blood_type }}">{{ $bloodType->blood_type }}</a>
                                            </li>
                                        @empty
                                            <li>No Patients yet</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                            <div class="col-auto p-0">
                                <!-- Split dropup button -->
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-primary">Barangay</button>
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        {{-- show only list of blood types have --}}
                                        @forelse ($barangays as $barangay)
                                            <li><a class="dropdown-item"
                                                    href="{{ url('sortPatient') }}?key=brgy&value={{ $barangay->barangay }}">{{ $barangay->barangay }} ({{ $barangay->total }})</a>
                                            </li>
                                        @empty
                                            <li>No Patients added</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                            <div class="col p-0">
                                <a href="{{ url('patientList') }}" class="text-decoration-none float-end" target="_blank">
                                    <button class="btn btn-primary rounded-3">Print list as PDF</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div id="card-list">
                    <div class="row justify-content-center g-2 mt-2">
                        @forelse ($patients as $patient)
                            {{-- card --}}
                            <div class="col-md-4">
                                <div class="card rounded-4 shadow-sm ">
                                    <div class="card-header">
                                        <div class="text-center">
                                            <form>
                                                <button type="button"
                                                    class="btn btn-sm btn-primary w-100 text-start btn_pnt{{ $patient->id }}"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModal" id="click_btn"
                                                    value="{{ $patient->id }}">
                                                    MRN<strong>: {{ $patient->case_no }}</strong></a>
                                                </button>
                                            </form>
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
                                                    {{-- <a href="{{ url('applyAssistanceRequest', $patient->id) }}"
                                                class="text-decoration-none" data-bs-toggle="tooltip"
                                                data-bs-title="Apply for Assistance">
                                                <button type="button" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-file-earmark-text-fill"></i>
                                                </button>
                                            </a> --}}
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
                            <div class="col-12 text-center text-muted">
                                <h1 class="m-0">No Patients Listed</h1>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- pagination --}}
                <div class="row m-0 mt-2 text-bg-primary rounded-4 p-3">
                    {{ $patients->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
            <div class="tabcontent pt-3" id="table" style="display: none">
                <livewire:patient-table />
            </div>
        </div>
    </div>

    {{-- patient id --}}
    @php
        $patient_id = 0;
    @endphp

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-bg-primary">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Patient Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal_show_patient_details">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    {{-- <a href="{{ route('patient.show', $patient_id) }}" class="text-decoration-none">
                        <button type="button" class="btn btn-outline-primary">Details</button>
                    </a>
                    <a href="{{ route('patient.edit', $patient_id) }}" class="text-decoration-none float-md-end">
                        <button type="button" class="btn btn-primary">Update Records</button>
                    </a> --}}
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
            search_patient($value);
        });

        // ajax search function
        function search_patient(key) {
            var $search_key = key
            // console.log($search_key)
            $.ajax({
                url: "{{ url('search_patient') }}",
                type: "GET",
                data: {
                    'key': $search_key
                },
                success: function(data) {
                    $('#card-list').html(data);
                    //$('#patients_list_area').html(data);
                    get_btn_list();
                }
            })
        }

        // ajax for getting patient info
        function get_btn_list() {
            var $btn_list = document.querySelectorAll('#click_btn');
            // console.log($btn_list);
            for (var i = 0; i < $btn_list.length; i++) {
                var id = $btn_list[i].value;

                $('.btn_pnt' + id).on('click', function() {
                    // console.log(this.value);
                    get_patient_details(this.value);
                });
            }
        };

        // ajax data GET
        function get_patient_details(id) {
            var $patient_id = id
            $.ajax({
                url: "{{ url('patient_details') }}",
                type: "GET",
                data: {
                    'id': $patient_id
                },
                success: function(data) {
                    $('#modal_show_patient_details').html(data);
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
