@extends('layouts.app')

@section('content')
    <h1 class="text-center">Import Data Medicine</h1>
    <hr>

    {{-- alert --}}
    @include('components.alert')



    <div class="row gap-2 m-0">
        <div class="col-sm col-12 p-0">
            <div class="row g-2 m-2">
                <div class="col-12">
                    <h3>Medicine Information</h3>
                </div>
                <div class="col-md">

                    <form action="{{ url('importMedsData') }}" method="post" class="needs-validations row g-2"
                        enctype="multipart/form-data" novalidat>
                        {{-- for validation --}}
                        @csrf
                        <div class="input-group col-md">
                            <input type="file" class="form-control" name="file" accept=".csv" id="inputGroupFile02"
                                required>
                            <label class="input-group-text" for="inputGroupFile02">Upload CSV File</label>
                        </div>
                        <div class="col-md-auto">
                            {{-- <label for="batch_title" class="form-label"><span class="ra">*</span>Batch Title</label> --}}
                            <input type="number" class="form-control" placeholder="" name="batch_no"
                                id="batch_no" value="" required>
                        </div>
                        <div class="col-md-auto">
                            <button class="btn btn-primary w-100" type="submit">
                                Import
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-12">
                    <div class="alert alert-warning rounded-3" role="alert">
                        <h4 class="alert-heading">Note *</h4>
                        <p>When Import CSV data from excel make sure that the column squence is the same as these.</p>
                        <ol>
                            <li>Medicine Id (a number type ex. 1234)</li>

                            <li>Name (Name of the Medicine ex. Biogesic)</li>
                            <li>Manufacturer (Name of the Manufacturer ex. Generics)</li>
                            <li>Medicine Type (The type of the Medicine ex. Digestive System)</li>

                            {{-- <li>Package Type (The package of the medicine ex. Tablets or Capsule)</li> --}}
                            {{-- <li>Mesure Value (A number value mesurement ex. 8000)</li> --}}
                            {{-- <li>Mesurement (Mesurement used ex. ml, mm, grams, liter)</li> --}}

                            {{-- <li>Description (Brief description of the medicine)</li> --}}
                            <li>Batch No. (ex. 2342)</li>

                            <li>Expiration Date (format (yyyy-mm-dd) ex. 2024-12-1)</li>
                        </ol>
                        <hr>
                        <p class="mb-0">Having the Columns not the same as the database may lead to errors in importing
                            the data. template example <a href="{{ url('exportData') }}" class="btn btn-sm btn-primary"
                                target="_blank">
                                Template
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <hr class="mb-4"> --}}

    {{-- <div class="row">
        <div class="col">
            <button class="btn btn-lg btn-primary rounded-3 float-end " type="submit">
                Import
            </button>
        </div>
    </div> --}}
@endsection
