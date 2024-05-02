@extends('layouts.app')

@section('content')
    <h1 class="text-center">Patient Records</h1>
    <hr>

    {{-- alert --}}
    @include('components.alert')

    <div class="row gap-2 m-0">
        <div class="col-12">
            <div class="row m-0 gap-0">
                <div class="col p-0">
                    <h4>
                        <strong>Case Number : </strong>
                        {{ $patient->case_no }}
                    </h4>
                </div>
                <div class="col p-0 text-end">
                    <a href="{{ route('patientPDFInfo', $patient->id) }}" class="text-decoration-none" target="_blank">
                        <button type="button" class="btn btn-primary">Pdf Details</button>
                    </a>
                </div>
            </div>

            <hr>
        </div>
        <div class="col-md col-12">
            <div class="row">
                <div class="col-12">
                    <h3>Personal Information</h3>
                </div>
                <div class="col-md-6">
                    <p>
                        <strong>Name : </strong>
                        {{ $patient->first_name }} {{ $patient->mid_name }} {{ $patient->last_name }}
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>Age :</strong> {{ $patient->age }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Birth Date :</strong> {{ $patient->birth_date }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Gender :</strong> {{ $patient->gender }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Blood Type :</strong> {{ $patient->blood_type }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Religion :</strong> {{ $patient->religion }}</p>
                </div>
                <div class="col-12">
                    <p><strong>Place of Birth :</strong> {{ $patient->birth_place }}</p>
                </div>
                <div class="col-12">
                    <hr>
                </div>
                <div class="col-md-6">
                    <p><strong>Contact No. :</strong> 0{{ $patient->contact_no }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Citizenship :</strong> {{ $patient->citizenship }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Barangay :</strong> {{ $patient->barangay }}</p>
                </div>
                <div class="col-md-8">
                    <p><strong>Address :</strong> {{ $patient->address }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-bg-primary rounded-3 p-2 mb-1">
                <h4 class="text-center m-0">Current Diagnosis</h4>
            </div>
            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#AddModal"><i
                    class="bi bi-prescription2"></i> New Diagnosis</button>
            <div class="row">
                <div class="col-12">
                    <h3>Patient Case</h3>
                </div>
                <div class="col-md-6">
                    <p><strong>Admission Date :</strong> {{ $patient_case->admit_date }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Time Arrival :</strong> {{ $patient_case->arrive_time }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Diagnosis :</strong> {{ $patient_case->diagnosis }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Treatment :</strong> {{ $patient_case->treatment }}</p>
                </div>
                <div class="col-12">
                    <hr>
                </div>
                <div class="col-12">
                    <p><strong>Remarks :</strong> {{ $patient_case->remarks }}</p>
                </div>
            </div>
        </div>
        <div class="col-12">
            <hr class="mb-0">
        </div>
        <div class="col-12">
            <div class="row g-2 m-0">
                <div class="col-md overflow-y-auto" style="height: 50vh">
                    <div class="row w-100">
                        <div class="col-12">
                            <h3>Despense Medicine</h3>
                        </div>
                        {{-- requests list --}}
                        <div class="col-12">
                            {{-- table --}}
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Medicine</th>
                                        <th class="text-end">Quantity</th>
                                        <th class="text-end">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($despensed_medicines as $medicine)
                                        <tr>
                                            <td>{{ $medicine->name }}</td>
                                            <td class="text-end">{{ $medicine->total }}</td>
                                            <td class="text-end">{{ $medicine->created_at }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">
                                                Not Despense Yet
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md overflow-y-auto" style="height: 50vh">
                    <div class="row w-100">
                        <div class="col-12">
                            <h3>Diagnosis History</h3>
                        </div>
                        {{-- list --}}
                        <div class="col-12">
                            @forelse ($diagnosis_list as $diagnosis)
                                <div class="row g-2 align-items-center mb-1">
                                    <div class="col-auto">
                                        <form>
                                            <button type="button"
                                                class="btn btn-sm btn-primary btn_pnt{{ $diagnosis->diagnosis_no }}"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal" id="click_btn"
                                                value="{{ $diagnosis->diagnosis_no }}">
                                                {{ $diagnosis->created_at }}</a>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col">
                                        <hr>
                                    </div>
                                    <div class="col-auto text-end">
                                        <strong>{{ $diagnosis->diagnosis_no }}</strong>
                                    </div>
                                    <div class="col-auto text-end">
                                        {{ $diagnosis->diagnosis }}
                                    </div>
                                </div>
                            @empty
                                <div class="row">
                                    <div class="col text-center">
                                        No diagnosis
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md p-2 overflow-scroll" style="height: 35vh">
                    <div class="row">
                        <div class="col-12">
                            <h3>Assistance Requests</h3>
                        </div>
                        @forelse ($patient_assistances as $request)
                            <div class="col-12">
                                <div class="row mb-2 ">
                                    <div class="col">
                                        <p class="m-0"><strong>Request Type : </strong>{{ $request->request_type }}</p>
                                    </div>
                                    <div class="col-auto">
                                        <p class="m-0"><strong>Status : </strong>{{ $request->status }}</p>
                                    </div>
                                    <div class="col-12">
                                        <small class="text-muted">Date: {{ $request->created_at }}</small>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-muted">No request yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div> --}}
            </div>
        </div>

        <div class="col-12">
            <hr>
            <a href="{{ route('patient.edit', $patient->id) }}" class="text-decoration-none float-md-end">
                <button type="button" class="btn btn-lg btn-primary">Update Records</button>
            </a>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="AddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form action="{{ url('addNewDiagnosis') }}" method="post" class="needs-validations" novalidat>
                {{-- for validation --}}
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">New Diagnosis</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="">
                        {{-- patient case number --}}
                        <input type="text" class=" d-none" name="case_number" id=""
                            value="{{ $patient->case_no }}">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label for="diagnosis_number" class="form-label">Diagnosis Number</label>
                                <input type="text" class="form-control" placeholder="" name="diagnosis_number"
                                    id="diagnosis_number" value="{{ $diagnosis_no }}" readonly required>
                            </div>
                            <div class="col-md-6">
                                <label for="diagnosis" class="form-label">Diagnosis</label>
                                <input type="text" class="form-control" placeholder="Example" name="diagnosis"
                                    id="diagnosis" value="">
                            </div>
                            <div class="col-md-6">
                                <label for="treatment" class="form-label">Treatment</label>
                                <input type="text" class="form-control" placeholder="Example" name="treatment"
                                    id="treatment" value="">
                            </div>
                            <div class="col-md-6">
                                <label for="brought_by" class="form-label"> Brought By</label>
                                <input type="text" class="form-control" placeholder="Example" name="brought_by" id="brought_by"
                                    value="">
                            </div>
                            <div class="col-md-6">
                                <label for="time_arrival" class="form-label">Time of Arrival</label>
                                <input type="time" class="form-control" name="time_arrival" id="time_arrival"
                                    value="">
                            </div>
                            <div class="col-md-6">
                                <label for="admit_date" class="form-label">Date</label>
                                <input type="date" class="form-control" name="admit_date" id="admit_date"
                                    value="">
                            </div>
                            <div class="col-12">
                                <label for="remarks" class="form-label">Remarks</label>
                                <textarea class="form-control" name="remarks" id="remarks" rows="6"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Add</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-bg-primary">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Patient Diagnosis Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal_show_patient_diagnosis_details">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    {{-- scripts --}}
    <script type="module">
        // call from start
        get_btn_list();

        // ajax for getting patient info
        function get_btn_list() {
            var $btn_list = document.querySelectorAll('#click_btn');
            // console.log($btn_list);
            for (var i = 0; i < $btn_list.length; i++) {
                var id = $btn_list[i].value;

                $('.btn_pnt' + id).on('click', function() {
                    // console.log(this.value);
                    get_diagnosis_details(this.value);
                });
            }
        };

        // ajax data GET
        function get_diagnosis_details(id) {
            var $patient_id = '{{ $patient->case_no }}';
            var $diagnosis_no = id;
            $.ajax({
                url: "{{ url('diagnosis_details') }}",
                type: "GET",
                data: {
                    'pid': $patient_id,
                    'no': $diagnosis_no
                },
                success: function(data) {
                    $('#modal_show_patient_diagnosis_details').html(data);
                }
            })
        };
    </script>
@endsection
