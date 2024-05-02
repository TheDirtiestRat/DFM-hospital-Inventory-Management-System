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
                <label for="quantity${i}" class="form-label"><span class="ra">*</span> Quantity</label>
                <input type="number" class="form-control" placeholder="00" min="0" step="1"
                    name="quantity[]" id="quantity${i}" value="" required>
            </div>
            <div class="col-md-3">
                <label for="expired_date${i}" class="form-label"><span class="ra">*</span> Expiration Date</label>
                <input type="date" class="form-control" name="expired_date[]" id="expired_date${i}"
                    min="{{ date('Y-m-d') }}" value="" required>
            </div>
            <div class="col-md-4">
                <label for="pakage_type${i}" class="form-label"><span class="ra">*</span> Package Type</label>
                <select class="form-select" name="pakage_type[]" id="pakage_type${i}" required>
                    <option selected disabled value>Select Type</option>
                    <option value="Pads">By Pads</option>
                    <option value="Box">By Box</option>
                    <option value="Bottle">By Bottle</option>
                    <option value="Bags">By Bags</option>
                    <option value="Capstule">By Capstule</option>
                    <option value="Tablets">By Tablets</option>
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
                <label for="mesurement_value${i}" class="form-label"><span class="ra">*</span> Mesurement</label>
                <div class="row gap-0 m-0">
                    <div class="col-6 p-0 pe-1 ">
                        <input type="number" class="form-control" placeholder="00" min="1" step="1"
                            name="mesurement_value[]" id="mesurement_value${i}" value="" required>
                    </div>
                    <div class="col-4 p-0 ">
                        <select class="form-select w-100 " name="mesurement[]" id="mesurement${i}" required>
                            <option selected value="l">Liters</option>
                            <option value="mm">Miligrams</option>
                            {{-- more mesurements to come --}}
                        </select>
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-danger w-100" id="add_med_btn" onclick='remove_insert("med${i}")'>
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <hr>
            </div>
            `;
            // add to the list element
            document.getElementById("meds_list_area").appendChild(meds);
        }

        function remove_insert(elem_id) {
            const node_to_remove = document.getElementById(elem_id);
            // get the parent and the child node
            const parent = document.getElementById('meds_list_area');

            parent.removeChild(node_to_remove);
        }
    </script>
@endsection
