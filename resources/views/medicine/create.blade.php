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
                <label for="medicine_id" class="form-label">PO No.</label>
                {{-- <label for="medicine_id" class="form-label">Medicine Id</label> --}}
                <input type="text" class="form-control" placeholder="999999" name="medicine_id" id="medicine_id"
                    value="{{ $med_id }}" required>
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
                        <label for="package_count" class="form-label"><span class="ra">*</span> Packages received</label>
                        <input type="number" class="form-control stock-package-count" placeholder="Number of packages"
                            min="1" step="1" name="package_count" id="package_count" value="1" required>
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
                        <label for="package_type" class="form-label"><span class="ra">*</span> Supplier package</label>
                        <select class="form-select" name="package_type" id="package_type" required>
                            <option value="" selected disabled>Select package</option>
                            <option value="box">Box</option>
                            <option value="bottle">Bottle</option>
                            <option value="blister_pack">Blister pack</option>
                            <option value="carton">Carton</option>
                            <option value="bag">Bag</option>
                            <option value="vial">Vial</option>
                            <option value="ampoule">Ampoule</option>
                            <option value="sachet">Sachet</option>
                            <option value="strip">Strip</option>
                        </select>
                    </div>
                    <div class="col-md">
                        <label for="units_per_package" class="form-label"><span class="ra">*</span> Medicine units per package</label>
                        <input type="number" class="form-control stock-units-per-package" min="1" step="1"
                            name="units_per_package" id="units_per_package" value="1" required>
                    </div>
                </div>

                <div class="row g-2 m-2">
                    <div class="col-md">
                        <label for="dispensing_unit" class="form-label"><span class="ra">*</span> Dispensing unit</label>
                        <select class="form-select" name="dispensing_unit" id="dispensing_unit" required>
                            <option value="" selected disabled>Select unit</option>
                            <option value="tablet">Tablet</option>
                            <option value="capsule">Capsule</option>
                            <option value="mL">mL</option>
                            <option value="bottle">Bottle</option>
                            <option value="vial">Vial</option>
                            <option value="ampoule">Ampoule</option>
                            <option value="sachet">Sachet</option>
                            <option value="patch">Patch</option>
                            <option value="inhaler">Inhaler</option>
                            <option value="drop">Drop</option>
                            <option value="unit">Other unit</option>
                        </select>
                        <small class="text-muted">For liquid dispensed by volume, choose mL and enter the mL per bottle as the package size.</small>
                    </div>
                    <div class="col-md">
                        <label for="strength_value" class="form-label"><span class="ra">*</span> Strength/content per dispensing unit</label>
                        <input type="number" class="form-control" placeholder="e.g. 500" min="0.001"
                            max="9999999.999" step="0.001" name="strength_value" id="strength_value" required>
                    </div>
                    <div class="col-md">
                        <label for="strength_unit" class="form-label"><span class="ra">*</span> Standard strength unit</label>
                        <select class="form-select" name="strength_unit" id="strength_unit" required>
                            <option value="" selected disabled>Select unit</option>
                            <option value="mcg">mcg (microgram)</option>
                            <option value="mg">mg (milligram)</option>
                            <option value="g">g (gram)</option>
                            <option value="mL">mL (milliliter)</option>
                            <option value="L">L (liter)</option>
                            <option value="IU">IU (international unit)</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <div class="alert alert-info py-2 mb-0">
                            Total available stock:
                            <strong><span id="total_stock_units">1</span> <span id="total_stock_unit_label">unit</span></strong>
                            <span class="text-muted">(packages received × medicine units per package)</span>
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
        const stockPackageCount = document.getElementById('package_count');
        const stockUnitsPerPackage = document.getElementById('units_per_package');
        const dispensingUnit = document.getElementById('dispensing_unit');
        const totalStockUnits = document.getElementById('total_stock_units');
        const totalStockUnitLabel = document.getElementById('total_stock_unit_label');

        function updateStockTotal() {
            const packageCount = Number(stockPackageCount.value) || 0;
            const unitsPerPackage = Number(stockUnitsPerPackage.value) || 0;
            totalStockUnits.textContent = String(packageCount * unitsPerPackage);
            totalStockUnitLabel.textContent = dispensingUnit.value || 'unit';
        }

        [stockPackageCount, stockUnitsPerPackage, dispensingUnit].forEach(input => {
            input.addEventListener('input', updateStockTotal);
            input.addEventListener('change', updateStockTotal);
        });
        updateStockTotal();

        var loadFile = function(event) {
            var image = document.getElementById('outputImage');
            image.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
@endsection
