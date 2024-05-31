@extends('layouts.app')

@section('link')
    <style>
        .ra {
            color: red;
        }
    </style>
@endsection

@section('content')
    <h1 class="text-center">Patients By Barangay</h1>
    <hr>

    {{-- alert --}}
    @include('components.alert')

    {{-- tabs --}}
    <ul class="nav nav-pills nav-fill" id="myTab" role="tablist">
        @forelse ($regions as $reg)
            @if ($loop->first)
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="{{ $reg->region }}-tab" data-bs-toggle="tab"
                        data-bs-target="#{{ $reg->region }}" type="button" role="tab"
                        aria-controls="{{ $reg->region }}" aria-selected="true">{{ $reg->region }}</button>
                </li>
            @else
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="{{ $reg->region }}-tab" data-bs-toggle="tab"
                        data-bs-target="#{{ $reg->region }}" type="button" role="tab"
                        aria-controls="{{ $reg->region }}" aria-selected="false">{{ $reg->region }}</button>
                </li>
            @endif
        @empty
            {{-- if theres none --}}
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="no-tab" data-bs-toggle="tab" data-bs-target="#no" type="button"
                    role="tab" aria-controls="no" aria-selected="false">Not Yet</button>
            </li>
        @endforelse
    </ul>
    <div class="tab-content mt-3" id="myTabContent">
        @forelse ($regions as $reg)
            @if ($loop->first)
                <div class="tab-pane fade show active" id="{{ $reg->region }}" role="tabpanel"
                    aria-labelledby="{{ $reg->region }}-tab">
                    {{-- list of barangays --}}
                    <div class="container">
                        <div class="row g-3">
                            @include('components.barangay-row')
                        </div>
                    </div>
                </div>
            @else
                <div class="tab-pane fade" id="{{ $reg->region }}" role="tabpanel"
                    aria-labelledby="{{ $reg->region }}-tab">
                    {{-- list of barangays --}}
                    <div class="container">
                        <div class="row g-3">
                            @include('components.barangay-row')
                        </div>
                    </div>
                </div>
            @endif
        @empty
            {{-- if theres none --}}
            <div class="tab-pane fade" id="no" role="tabpanel" aria-labelledby="no-tab">
                <h1 class="text-center">There is not yet</h1>
            </div>
        @endforelse
    </div>


    {{-- barangays --}}
    {{-- <div class="row justify-content-center g-2">
        @forelse ($barangays as $barangay)
            card
            <div class="col-md-6">
                <div class="card rounded-4 shadow-sm ">
                    <div class="card-header">
                        <div class="row g-2 align-items-center ">
                            <div class="col-auto">
                                Brangay
                            </div>
                            <div class="col-auto">
                                <form>
                                    <button type="button" class="btn btn-light   w-100 text-start btn_pnt2"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal" id="click_btn" value="1">
                                        <h5 class="card-title text-truncate m-0 ">{{ $barangay->barangay }}</h5>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-2 align-items-center ">

                            <div class="col">
                                <div class="d-flex flex-column gap-1">
                                    buttons
                                    <a href="{{ url('sortPatient') }}?key=brgy&value={{ $barangay->barangay }}"
                                        class="btn btn-outline-primary ps-3 pe-3" data-bs-toggle="tooltip"
                                        data-bs-title="Total">
                                        {{ $barangay->total }} Patients
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            if no patients
            <div class="col-12 text-center text-muted">
                <h1 class="m-0">No Patients Listed</h1>
            </div>
        @endforelse
    </div> --}}

    {{-- pagination --}}
    {{-- <div class="row m-0 mt-2 text-bg-primary rounded-4 p-3">
        {{ $barangays->links('vendor.pagination.bootstrap-5') }}
    </div> --}}

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Barangay Details of <strong><span id="brgy-name"></span></strong></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal_show_patient_details">
                    {{-- content here --}}
                    {{-- @include('components.barangay-details') --}}
                </div>
                <div class="modal-footer">
                    <a href="http://" target="_blank" id="print_summary_brgy" class="btn btn-outline-primary">Print</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <script type="module">
        // call from start
        get_btn_list();
        const print_btn = document.getElementById('print_summary_brgy');
        const brgy_n = document.getElementById('brgy-name');

        // ajax for getting patient info
        function get_btn_list() {
            var $btn_list = document.querySelectorAll('#click_btn');
            // console.log($btn_list);
            for (var i = 0; i < $btn_list.length; i++) {
                var id = $btn_list[i];
                // console.log(id.value);
                $(id).on('click', function() {
                    // console.log(this.value);
                    get_barangay_details(this.value);
                });
            }
        };

        // ajax data GET
        function get_barangay_details(id) {
            var $brgy = id

            // give the print btn data
            brgy_n.innerHTML = $brgy;
            print_btn.href = "{{ url('printBarangayReports') }}?brgy=" + $brgy;
            // console.log(print_btn.href);

            $.ajax({
                url: "{{ url('barangay_details') }}",
                type: "GET",
                data: {
                    'brgy': $brgy
                },
                success: function(data) {
                    $('#modal_show_patient_details').html(data);
                }
            })
        };
    </script>
@endsection
