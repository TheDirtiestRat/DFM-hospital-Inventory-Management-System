@php
    // variables
    $user_types = ['ADMIN', 'PHARMACIST', 'RECEPTIONIST'];
    // show the dashboard base by user type
    $url = 'dashboard';
    if (Auth::user()->type == 'PHARMACIST') {
        $url = 'dashboardPharmacist';
    } elseif (Auth::user()->type == 'RECEPTIONIST') {
        $url = 'dashboardReceptionist';
    }
@endphp

<div class="d-flex flex-column flex-shrink-0 p-2 sidebar-fixed rounded-4 rounded-start overflow-y-auto shadow"
    id="sidebar-wrapper" style="width: 260px;">
    <div class="text-center">
        <img src="{{ asset('/storage/images/ormoc.png') }}" alt="" width="75px" height="75px">
        <h5>@include('components.title')</h5>
        <hr>
    </div>

    <div class=" overflow-y-auto p-1">
        <ul class="nav nav-pills gap-2 flex-column">

            <div class="nav-item">
                <p class="text-secondary mb-2">
                    <strong>
                        @if (Auth::user()->type == $user_types[0])
                            Admin Management
                        @elseif (Auth::user()->type == $user_types[1])
                            Pharma Management
                        @elseif (Auth::user()->type == $user_types[2])
                            Receptionist Managemnet
                        @endif

                    </strong>
                </p>
            </div>

            <li class="nav-item">
                <a class="btn btn-primary w-100 text-start" href="{{ url($url) }}" role="button">
                    <i class="bi bi-graph-down-arrow"></i>
                    Dashboard
                </a>
            </li>

            {{-- options dashboard --}}
            {{-- <li class="nav-item">
                <a class="btn btn-primary w-100 text-start" href="{{ url($url) }}" role="button">
                    <i class="bi bi-database"></i>
                    Dashboard
                </a>
            </li> --}}

            @if (Auth::user()->type == $user_types[2] || Auth::user()->type == $user_types[0])
                <li class="nav-item">
                    <a class="btn btn-primary w-100 text-start" data-bs-toggle="collapse" href="#collapseExample"
                        role="button" aria-expanded="false" aria-controls="collapseExample">
                        <i class="bi bi-caret-right-fill"></i>
                        Patients
                    </a>
                </li>

                <div class="nav-item">
                    {{-- collapse content --}}
                    <div class="collapse" id="collapseExample">
                        <ul class="nav gap-2  nav-pills flex-column p-1">
                            <li class="nav-item">
                                <a href="{{ route('patient.create') }}" class="btn btn-sm btn-light text-start w-100">
                                    <i class="bi bi-person-add"></i>
                                    Add new Patient
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('patient.index') }}" class="btn btn-sm btn-light text-start w-100">
                                    <i class="bi bi-people"></i>
                                    Patient List
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('patientsByBarangay') }}" class="btn btn-sm btn-light text-start w-100">
                                    <i class="bi bi-house-door"></i>
                                    By Barangay
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- options Patients --}}
                {{-- <li class="nav-item">
                    <a class="btn btn-primary w-100 text-start" href="{{ route('patient.index') }}" role="button">
                        <i class="bi bi-person"></i>
                        Patients Records
                    </a>
                    <div class=" mt-2">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a href="{{ route('patient.create') }}" class="btn btn-sm btn-light text-start w-100"
                                    role="button">
                                    <i class="bi bi-person-add"></i>
                                    Add Patient
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> --}}
            @endif

            @if (Auth::user()->type == $user_types[1] || Auth::user()->type == $user_types[0])
                <li class="nav-item">
                    <a class="btn btn-primary w-100 text-start" data-bs-toggle="collapse" href="#collapseExample2"
                        role="button" aria-expanded="false" aria-controls="collapseExample2">
                        <i class="bi bi-caret-right-fill"></i>
                        Medicines
                    </a>
                </li>

                <div class="nav-item">
                    {{-- collapse content --}}
                    <div class="collapse" id="collapseExample2">
                        <ul class="nav gap-2  nav-pills flex-column p-1">
                            <li class="nav-item">
                                <a href="{{ route('medicine.create') }}" class="btn btn-sm btn-light text-start w-100">
                                    <i class="bi bi-person-add"></i>
                                    Add new Medicine
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('MedicineByBatch') }}" class="btn btn-sm btn-light text-start w-100">
                                    <i class="bi bi-capsule-pill"></i>
                                    Add By Batch
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('despenseMedicine') }}" class="btn btn-sm btn-light text-start w-100">
                                    <i class="bi bi-prescription2"></i>
                                    Despense Medicine
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('medicine.index') }}" class="btn btn-sm btn-light text-start w-100">
                                    <i class="bi bi-capsule"></i>
                                    Medicine List
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('despenseMedicineList') }}"
                                    class="btn btn-sm btn-light text-start w-100">
                                    <i class="bi bi-list"></i>
                                    Despense List
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('importDataMedicines') }}"
                                    class="btn btn-sm btn-light text-start w-100">
                                    <i class="bi bi-upload"></i>
                                    Import
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- options Medicine --}}
                {{-- <li class="nav-item">
                    <a class="btn btn-primary w-100 text-start" href="{{ route('medicine.index') }}" role="button">
                        <i class="bi bi-person"></i>
                        Medicine Records
                    </a>
                    <div class=" mt-2">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a href="{{ route('medicine.create') }}" class="btn btn-sm btn-light text-start w-100"
                                    role="button">
                                    <i class="bi bi-capsule"></i>
                                    Add Medicine
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('despenseMedicine') }}" class="btn btn-sm btn-light text-start w-100 "
                                    role="button">
                                    <i class="bi bi-prescription2"></i>
                                    Despense Medicine
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('despenseMedicineList') }}"
                                    class="btn btn-sm btn-light text-start w-100 " role="button">
                                    <i class="bi bi-list"></i>
                                    Despense List
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('importDataMedicines') }}"
                                    class="btn btn-sm btn-light text-start w-100" role="button">
                                    <i class="bi bi-upload"></i>
                                    Import
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> --}}
            @endif

            @if (Auth::user()->type == $user_types[2] || Auth::user()->type == $user_types[0])
                <li class="nav-item">
                    <a class="btn btn-primary w-100 text-start" data-bs-toggle="collapse" href="#collapseDoctor"
                        role="button" aria-expanded="false" aria-controls="collapseDoctor">
                        <i class="bi bi-caret-right-fill"></i>
                        Doctors
                    </a>
                </li>

                <div class="nav-item">
                    {{-- collapse content --}}
                    <div class="collapse" id="collapseDoctor">
                        <ul class="nav gap-2  nav-pills flex-column p-1">
                            {{-- <li class="nav-item">
                                <a href="{{ route('doctors.create') }}" class="btn btn-sm btn-light text-start w-100">
                                    <i class="bi bi-person-add"></i>
                                    Add new Doctor
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a href="{{ route('doctors.index') }}" class="btn btn-sm btn-light text-start w-100">
                                    <i class="bi bi-people"></i>
                                    List of Doctors
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif

            {{-- accessed by admin --}}
            @if (Auth::user()->type == $user_types[0])
                {{-- options assistance request --}}
                {{-- <li class="nav-item">
                    <a class="btn btn-primary w-100 text-start" href="{{ route('assistanceRequest.index') }}"
                        role="button">
                        <i class="bi bi-receipt"></i>
                        Assistance Request
                    </a>
                    <div class=" mt-2">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a href="{{ url('applyAssistanceRequest', 0) }}" class="btn btn-sm btn-light text-start w-100"
                                    role="button">
                                    <i class="bi bi-file-text"></i>
                                    Apply Request
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('assistanceRequest.edit', 0) }}"
                                    class="btn btn-sm btn-light text-start w-100" role="button">
                                    <i class="bi bi-file-check"></i>
                                    Approve Request
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> --}}
            @endif

            <li class="nav-item">
                <a class="btn btn-primary w-100 text-start" data-bs-toggle="collapse" href="#collapseExample3"
                    role="button" aria-expanded="false" aria-controls="collapseExample3">
                    <i class="bi bi-caret-right-fill"></i>
                    Reports
                </a>
            </li>

            <div class="nav-item">
                {{-- collapse content --}}
                <div class="collapse" id="collapseExample3">
                    <ul class="nav gap-2  nav-pills flex-column p-1">
                        @if (Auth::user()->type == $user_types[0])
                            <li class="nav-item">
                                <a href="{{ url('reports') }}" class="btn btn-sm btn-light text-start w-100">
                                    <i class="bi bi-receipt"></i>
                                    Overall Reports
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->type == $user_types[1] || Auth::user()->type == $user_types[0])
                            <li class="nav-item">
                                <a href="{{ url('medicineRecordsReport') }}"
                                    class="btn btn-sm btn-light text-start w-100">
                                    <i class="bi bi-calendar-month"></i>
                                    Medicine Reports
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->type == $user_types[2] || Auth::user()->type == $user_types[0])
                            <li class="nav-item">
                                <a href="{{ url('patientRecordsReport') }}"
                                    class="btn btn-sm btn-light text-start w-100">
                                    <i class="bi bi-calendar-week"></i>
                                    Patient Reports
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->type == $user_types[0])
                            <li class="nav-item">
                                <a href="{{ url('ReportsPDF') }}" class="btn btn-sm btn-light text-start w-100">
                                    <i class="bi bi-printer"></i>
                                    Print Reports
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            {{-- options reports --}}
            {{-- <li class="nav-item">
                <a class="btn btn-primary w-100 text-start " href="{{ url('reports') }}" role="button">
                    <i class="bi bi-receipt"></i>
                    Reports
                </a>
                <div class=" mt-2">
                    <ul class="nav nav-pills flex-column">
                        users and admin can access
                        @if (Auth::user()->type == $user_types[1] || Auth::user()->type == $user_types[0])
                            <li class="nav-item">
                                <a href="{{ url('medicineRecordsReport') }}"
                                    class="btn btn-sm btn-light text-start w-100 " role="button">
                                    <i class="bi bi-calendar-month"></i>
                                    Medicine Reports
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->type == $user_types[2] || Auth::user()->type == $user_types[0])
                            <li class="nav-item">
                                <a href="{{ url('patientRecordsReport') }}"
                                    class="btn btn-sm btn-light text-start w-100 " role="button">
                                    <i class="bi bi-calendar-week"></i>
                                    Patient Reports
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->type == $user_types[0])
                            <li class="nav-item">
                                <a href="{{ url('ReportsPDF') }}" class="btn btn-sm btn-light text-start w-100"
                                    role="button">
                                    <i class="bi bi-printer"></i>
                                    Print Reports
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </li> --}}

            {{-- <li class="nav-item">
                <hr class=" mt-0">
            </li> --}}

            <div class="nav-item">
                <p class="text-secondary mb-2"><strong>Utilities</strong></p>
            </div>

            <li class="nav-item">
                <a class="btn btn-primary w-100 text-start" data-bs-toggle="collapse" href="#collapseExample4"
                    role="button" aria-expanded="false" aria-controls="collapseExample4">
                    <i class="bi bi-caret-right-fill"></i>
                    User Management
                </a>
            </li>

            <div class="nav-item">
                {{-- collapse content --}}
                <div class="collapse" id="collapseExample4">
                    <ul class="nav gap-2  nav-pills flex-column p-1">
                        @if (Auth::user()->type == $user_types[0])
                            <li class="nav-item">
                                <a href="{{ route('user.index') }}" class="btn btn-sm btn-light text-start w-100">
                                    <i class="bi bi-people"></i>
                                    Users
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('user.show', Auth::user()->id) }}"
                                class="btn btn-sm btn-light text-start w-100">
                                <i class="bi bi-person"></i>
                                User Profile
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- options Utilities --}}
            {{-- <li class="nav-item">
                <a class="btn btn-primary w-100 text-start" href="#" role="button">
                    <i class="bi bi-search"></i>
                    Utilities
                </a>
                <div class=" mt-2">
                    <ul class="nav nav-pills flex-column">
                        admin only
                        @if (Auth::user()->type == $user_types[0])
                            <li class="nav-item">
                                <a href="{{ route('user.index') }}" class="btn btn-sm btn-light text-start w-100"
                                    role="button">
                                    <i class="bi bi-person"></i>
                                    Users
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('user.show', Auth::user()->id) }}"
                                class="btn btn-sm btn-light text-start w-100" role="button">
                                <i class="bi bi-person"></i>
                                Profile
                            </a>
                        </li>
                    </ul>
                </div>
            </li> --}}
        </ul>
    </div>

    <div class="flex-column mt-auto">
        <hr>
        @include('components.copyright')
    </div>
</div>
