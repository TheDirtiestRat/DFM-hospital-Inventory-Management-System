@extends('layouts.single')

@section('title')
    Add by Batch
@endsection

@section('link')
    <style>
        .ra {
            color: red;
        }
    </style>
@endsection

@section('content')
    <h1 class="text-center">Add Medicine By Batch</h1>
    <hr>

    <form action="{{ url('storeByBatch') }}" method="post" class="needs-validations" enctype="multipart/form-data"
        novalidat>
        {{-- for validation --}}
        @csrf

        <div class="row justify-content-between g-2">
            <div class="col-md-auto">
                <div class="row g-2">

                    <div class="col-md-auto">
                        <label for="stock_date" class="form-label"><span class="ra">*</span> Stock Date</label>
                        <input type="date" class="form-control" name="stock_date" id="stock_date"
                            min="{{ date('Y-m-d') }}" value="{{ $date_today }}" required readonly>
                    </div>
                </div>

            </div>


            <div class="col-md-auto">
                <div class="row g-2">
                    <div class="col-md-auto">
                        <label for="batch_no" class="form-label"><span class="ra">*</span> Batch No.</label>
                        <input type="number" class="form-control" placeholder="0000" min="1" step="1"
                            name="batch_no" id="batch_no" value="" required>
                    </div>
                    <div class="col-md-auto">
                        <label for="batch_title" class="form-label"><span class="ra">*</span> Batch Title.</label>
                        <input type="text" class="form-control" placeholder="ABCD" name="batch_title" id="batch_title"
                            value="" required>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="d-flex justify-content-center">
            <button type="button" class="btn btn-primary btn-lg mb-3" id="add_med_btn" onclick='insert_new_meds()'>
                Add Medicine
            </button>
        </div>

        {{-- list of medicines to add --}}

        <div id="meds_list_area">
            {{-- <div class="row g-2 pb-3">

            </div> --}}
        </div>

        <hr class="mb-4">

        <div class="row justify-content-center">
            <div class="col-auto">
                <button class="btn btn-lg btn-primary rounded-3" type="submit">
                    Add Batch
                </button>
            </div>
        </div>
    </form>

    {{-- add meds script --}}
    <script>
        let index = 0;

        function insert_new_meds() {
            index++;
            let i = '';

            if (index < 10) {
                i = '0' + index;
            }

            const meds = document.createElement("div");
            meds.id = "med" + i;
            meds.classList.add('row');
            meds.classList.add('g-2');
            meds.innerHTML =
                `
            <div class="col-md-1 d-flex align-items-center justify-content-center">
                <h2 class="text-center m-0 p-1 ">${i}</h2>
            </div>
            <div class="col-md-3">
                <label for="name${i}" class="form-label"><span class="ra">*</span> Name</label>
                <input type="text" class="form-control" placeholder="Medicine Name" name="name[]" id="name${i}"
                    value="" required>
            </div>
            <div class="col-md-3">
                <label for="manufacturer${i}" class="form-label"><span class="ra">*</span> Manufacturer</label>
                <input type="text" class="form-control" placeholder="Medicine Manufacturer" name="manufacturer[]"
                    id="manufacturer${i}" value="" required>
            </div>
            <div class="col-md-2">
                <label for="package_count${i}" class="form-label"><span class="ra">*</span> Packages received</label>
                <input type="number" class="form-control" min="1" step="1"
                    name="package_count[]" id="package_count${i}" value="1" oninput="updateBatchStockTotal('${i}')" required>
            </div>
            <div class="col-md-3">
                <label for="expired_date${i}" class="form-label"><span class="ra">*</span> Expiration Date</label>
                <input type="date" class="form-control" name="expired_date[]" id="expired_date${i}"
                    min="{{ date('Y-m-d') }}" value="" required>
            </div>
            <div class="col-md-4">
                <label for="package_type${i}" class="form-label"><span class="ra">*</span> Supplier package</label>
                <select class="form-select" name="package_type[]" id="package_type${i}" required>
                    <option selected disabled value>Select package</option>
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
            <div class="col-md-2">
                <label for="units_per_package${i}" class="form-label"><span class="ra">*</span> Units/package</label>
                <input type="number" class="form-control" min="1" step="1" name="units_per_package[]"
                    id="units_per_package${i}" value="1" oninput="updateBatchStockTotal('${i}')" required>
            </div>
            <div class="col-md-2">
                <label for="dispensing_unit${i}" class="form-label"><span class="ra">*</span> Dispensing unit</label>
                <select class="form-select" name="dispensing_unit[]" id="dispensing_unit${i}" onchange="updateBatchStockTotal('${i}')" required>
                    <option selected disabled value>Select unit</option>
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
            </div>
            <div class="col-md-4">
                <label for="medicine_type${i}" class="form-label"><span class="ra">*</span> Medicine Type</label>
                <select class="form-select" name="medicine_type[]" id="medicine_type${i}" required>
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
            <div class="col-md-4">
                <label for="strength_value${i}" class="form-label"><span class="ra">*</span> Strength/content</label>
                <div class="row gap-0 m-0">
                    <div class="col-6 p-0 pe-1 ">
                        <input type="number" class="form-control" placeholder="e.g. 500" min="0.001" step="0.001"
                            name="strength_value[]" id="strength_value${i}" value="" required>
                    </div>
                    <div class="col-4 p-0 ">
                        <select class="form-select w-100 " name="strength_unit[]" id="strength_unit${i}" required>
                            <option selected disabled value="">Unit</option>
                            <option value="mcg">mcg</option>
                            <option value="mg">mg</option>
                            <option value="g">g</option>
                            <option value="mL">mL</option>
                            <option value="L">L</option>
                            <option value="IU">IU</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-danger w-100" onclick='remove_insert("med${i}")'>
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
                <small class="text-muted">Total stock = packages × units per package.</small>
                <div>Total available: <strong><output id="total_units${i}">1</output></strong> <span id="total_unit_label${i}">unit</span></div>
            </div>
            <div class="col-12">
                <hr>
            </div>
            `;
            // add to the list element
            document.getElementById("meds_list_area").appendChild(meds);
            updateBatchStockTotal(i);
        }

        function updateBatchStockTotal(row) {
            const packages = Number(document.getElementById(`package_count${row}`).value) || 0;
            const unitsPerPackage = Number(document.getElementById(`units_per_package${row}`).value) || 0;
            const unit = document.getElementById(`dispensing_unit${row}`).value || 'unit';
            document.getElementById(`total_units${row}`).textContent = String(packages * unitsPerPackage);
            document.getElementById(`total_unit_label${row}`).textContent = unit;
        }

        function remove_insert(elem_id) {
            const node_to_remove = document.getElementById(elem_id);
            // get the parent and the child node
            const parent = document.getElementById('meds_list_area');

            parent.removeChild(node_to_remove);
        }
    </script>
@endsection
