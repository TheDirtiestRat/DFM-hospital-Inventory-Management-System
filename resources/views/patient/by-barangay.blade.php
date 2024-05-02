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

    {{-- barangays --}}
    <div class="row justify-content-center g-2">
        @forelse ($barangays as $barangay)
            {{-- card --}}
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
                            {{-- <button type="button" class="btn btn-light rounded  w-100 text-start" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" id="click_btn">
                                
                                
                                <h5 class="card-title text-truncate m-0 ">{{ $barangay->barangay }}</h5>
                            </button> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-2 align-items-center ">
                            {{-- <div class="col">
                                <form>
                                    <button type="button" class="btn btn-primary w-100 text-start btn_pnt2"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal" id="click_btn" value="1">
                                        {{ $barangay->barangay }}
                                    </button>
                                </form>
                            </div> --}}
                            <div class="col">
                                <div class="d-flex flex-column gap-1">
                                    {{-- buttons --}}
                                    <a href="{{ url('sortPatient') }}?key=brgy&value={{ $barangay->barangay }}"
                                        class="btn btn-outline-primary ps-3 pe-3" data-bs-toggle="tooltip"
                                        data-bs-title="Total">
                                        {{ $barangay->total }} Patients
                                    </a>
                                    {{-- <a href="{{ route('patient.edit', $patient->id) }}" class="text-decoration-none"
                                        data-bs-toggle="tooltip" data-bs-title="Update Patient Case">
                                        <button type="button" class="btn btn-sm btn-primary">
                                            <i class="bi bi-person-fill-gear"></i>
                                        </button>
                                    </a> --}}
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

    {{-- pagination --}}
    <div class="row m-0 mt-2 text-bg-primary rounded-4 p-3">
        {{ $barangays->links('vendor.pagination.bootstrap-5') }}
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Barangay Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal_show_patient_details">
                    {{-- content here --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
