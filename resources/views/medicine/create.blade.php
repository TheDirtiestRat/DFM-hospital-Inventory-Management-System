@extends('layouts.app')

@php
    // for testing purposes
    $test_value = 'Testing';
    $test_val_num = 10;
@endphp

@section('link')
    <style>
        .ra {
            color: red;
        }
    </style>
@endsection

@section('content')
    <h1 class="text-center">Add Medicine</h1>
    <hr>

    {{-- alert --}}
    @include('components.alert')

    <form action="{{ route('medicine.store') }}" method="post" class="needs-validations" enctype="multipart/form-data"
        novalidat>
        {{-- for validation --}}
        @csrf

        <div class="row justify-content-between gap-2 m-0">
            <div class="col-auto">
                <label for="medicine_id" class="form-label">Medicine Id</label>
                <input type="text" class="form-control" placeholder="999999" name="medicine_id" id="medicine_id"
                    value="{{ $med_id }}" readonly required>
            </div>
            <div class="col-auto">
                <div class="row gap-2">
                    <div class="col-auto">
                        <label for="stock_date" class="form-label"><span class="ra">*</span> Stock Date</label>
                        <input type="date" class="form-control" name="stock_date" id="stock_date"
                        min="{{ date('Y-m-d') }}" value="{{ $date_today }}" required readonly>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        {{-- <fieldset>

        </fieldset> --}}

        <div class="row gap-2 m-0">
            <div class="col-sm col-12 p-0">
                <div class="row g-2 m-2">
                    <div class="col-12">
                        <h3>Medicine Information</h3>
                    </div>
                    <div class="col-md-auto text-center ">
                        <label for="file" class="form-label d-block ">Photo</label>
                        <img src="{{ asset('storage/images/ormoc.png') }}" class="img-fill border rounded-4 shadow "
                            alt="" id="outputImage" width="180px" height="180px">
                    </div>
                    <div class="col-md">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control mb-2 " name="description" id="description" rows="5"></textarea>
                        <input class="form-control" type="file" accept="image/*" name="photo" id="file"
                            onchange="loadFile(event)">
                    </div>
                </div>

                <div class="row g-2 m-2">

                    <div class="col-md">
                        <label for="name" class="form-label"><span class="ra">*</span> Name</label>
                        <input type="text" class="form-control" placeholder="Medicine Name" name="name" id="name"
                            value="" required>
                    </div>
                    <div class="col-md">
                        <label for="quantity" class="form-label"><span class="ra">*</span> Quantity</label>
                        <input type="number" class="form-control" placeholder="00" min="0" step="1"
                            name="quantity" id="quantity" value="" required>
                    </div>
                    <div class="col-md">
                        <label for="expired_date" class="form-label"><span class="ra">*</span> Expiration Date</label>
                        <input type="date" class="form-control" name="expired_date" id="expired_date"
                            min="{{ date('Y-m-d') }}" value="" required>
                    </div>
                </div>

                <div class="row g-2 m-2">
                    <div class="col-md">
                        <label for="manufacturer" class="form-label"><span class="ra">*</span> Manufacturer</label>
                        <input type="text" class="form-control" placeholder="Medicine Manufacturer" name="manufacturer"
                            id="manufacturer" value="" required>
                    </div>
                    <div class="col-md">
                        <label for="pakage_type" class="form-label"><span class="ra">*</span> Package Type</label>
                        <select class="form-select" name="pakage_type" id="pakage_type" required>
                            <option selected disabled value>Select Type</option>
                            <option value="Pads">By Pads</option>
                            <option value="Box">By Box</option>
                            <option value="Bottle">By Bottle</option>
                            <option value="Bags">By Bags</option>
                            <option value="Capstule">By Capstule</option>
                            <option value="Tablets">By Tablets</option>
                        </select>
                    </div>
                    <div class="col-md">
                        <label for="expired_date" class="form-label"><span class="ra">*</span> Mesurement</label>
                        <div class="row gap-0 m-0">
                            <div class="col-8 p-0 pe-1 ">
                                <input type="number" class="form-control" placeholder="00" min="1"
                                    step="1" name="mesurement_value" id="mesurement_value" value=""
                                    required>
                            </div>
                            <div class="col-4 p-0 ">
                                <select class="form-select w-100 " name="mesurement" id="mesurement" required>
                                    <option selected value="l">Liters</option>
                                    <option value="mm">Miligrams</option>
                                    {{-- more mesurements to come --}}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-2 m-2">
                    <div class="col-md">
                        <label for="medicine_type" class="form-label"><span class="ra">*</span> Medicine Type</label>
                        <select class="form-select" name="medicine_type" id="medicine_type" required>
                            <option selected disabled value>Select Type</option>
                            <option value="Digestive System">Digestive System</option>
                            <option value="Cardiovascular System">Cardiovascular System</option>
                            <option value="Central Nervous System">Central Nervous System</option>
                            <option value="Pain">Pain</option>
                            <option value="Musculoskeletal Disorders">Musculoskeletal Disorders</option>
                            <option value="Eyes">Eyes</option>
                            <option value="Senses">Ear, Nose, Oropharynx</option>
                            <option value="Respiratory System">Respiratory System</option>
                            <option value="Endocrine">Endocrine</option>
                            <option value="Urinary System">Urinary System</option>
                            <option value="Contraception">Contraception</option>
                            <option value="Obsterics and Gynecology">Obsterics & Gynecology</option>
                            <option value="Skin">Skin</option>
                            <option value="Infections and Infestations">Infections & Infestations</option>
                            <option value="Immune System">Immune System</option>
                            <option value="Allergies">Allergies</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="batch_no" class="form-label"><span class="ra">*</span> Batch No.</label>
                        <input type="number" class="form-control" placeholder="0000" min="1" step="1"
                            name="batch_no" id="batch_no" value="" required>
                    </div>
                    {{-- <div class="col-md-3">
                        <label for="batch_title" class="form-label"><span class="ra">*</span> Batch Title.</label>
                        <input type="text" class="form-control" placeholder="ABCD" name="batch_title"
                            id="batch_title" value="" required>
                    </div> --}}
                </div>
            </div>
        </div>

        <hr class="mb-4">

        <div class="row justify-content-center">
            <div class="col-auto">
                <button class="btn btn-lg btn-primary rounded-3" type="submit">
                    Add New Medicine
                </button>
            </div>
        </div>
    </form>

    <!-- image display script -->
    <script>
        var loadFile = function(event) {
            var image = document.getElementById('outputImage');
            image.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
@endsection
