@extends('layouts.single')

@section('title')
    Import Batch
@endsection

@section('link')
    <style>
        .ra {
            color: red;
        }
    </style>
@endsection

@section('content')
    <h1 class="text-center">Import By Batch</h1>
    <hr>

    <form action="{{ url('storeByBatch') }}" method="post" class="needs-validations" enctype="multipart/form-data" novalidat>
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
                            name="batch_no" id="batch_no" value="{{ $batch_no }}" required>
                    </div>
                    <div class="col-md-auto">
                        <label for="batch_title" class="form-label"><span class="ra">*</span> Batch Title.</label>
                        <input type="text" class="form-control" placeholder="ABCD" name="batch_title" id="batch_title"
                            value="{{ old('batch_title') }}" required>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <p class="text-muted">Available stock is calculated as packages received multiplied by units per package.</p>

        <div class="d-flex justify-content-center">
            <button type="button" class="btn btn-primary btn-lg mb-3" id="add_med_btn" onclick='insert_new_meds()'>
                Add Medicine
            </button>
        </div>

        {{-- list of medicines to add --}}

        <div class=" overflow-x-auto">
            <table class="table align-middle text-center">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Medicine</th>
                        <th>Manufacturer</th>
                        <th>Packages received</th>
                        <th>Expiration Date</th>
                        <th>Supplier package</th>
                        <th>Units / package</th>
                        <th>Dispensing unit</th>
                        <th>Medicine Type</th>
                        <th>Strength/content</th>
                        <th>Strength unit</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="meds_list_area">
                    {{-- list of imports --}}
                    @php
                        $index = 0;
                    @endphp
                    @foreach ($medicines as $meds)
                        @php
                            $index++;
                            $i = '';

                            if ($index < 10) {
                                $i = '0' . $index;
                            }else {
                                $i = $index;
                            }
                        @endphp
                        <tr>
                            <td>
                                {{ $i }}
                            </td>
                            <td><input type="text" class="form-control" placeholder="Medicine Name" name="name[]"
                                    id="name{{ $i }}" value="{{ $meds['name'] }}" required></td>
                            <td><input type="text" class="form-control" placeholder="Medicine Manufacturer"
                                    name="manufacturer[]" id="manufacturer{{ $i }}" value="{{ $meds['manufacturer'] }}" required></td>
                            <td><input type="number" class="form-control" min="1" step="1"
                                    name="package_count[]" id="package_count{{ $i }}" value="1" required></td>
                            <td><input type="date" class="form-control" name="expired_date[]"
                                    id="expired_date{{ $i }}" min="{{ date('Y-m-d') }}" value="{{ $meds['expired_date'] }}" required>
                            </td>
                            <td><select class="form-select" name="package_type[]" id="package_type{{ $i }}"
                                    required>
                                    <option selected disabled value="">Select package</option>
                                    <option value="box">Box</option>
                                    <option value="bottle">Bottle</option>
                                    <option value="blister_pack">Blister pack</option>
                                    <option value="carton">Carton</option>
                                    <option value="bag">Bag</option>
                                    <option value="vial">Vial</option>
                                    <option value="ampoule">Ampoule</option>
                                    <option value="sachet">Sachet</option>
                                    <option value="strip">Strip</option>
                                </select></td>
                            <td><input type="number" class="form-control" min="1" step="1" name="units_per_package[]"
                                    id="units_per_package{{ $i }}" value="1" required></td>
                            <td><select class="form-select" name="dispensing_unit[]" id="dispensing_unit{{ $i }}" required>
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
                                </select></td>
                            <td><select class="form-select" name="medicine_type[]" id="medicine_type{{ $i }}"
                                    required>
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
                                </select></td>
                            <td><input type="number" class="form-control" placeholder="e.g. 500" min="0.001"
                                    step="0.001" name="strength_value[]" id="strength_value{{ $i }}"
                                    value="" required></td>
                            <td><select class="form-select w-100 " name="strength_unit[]"
                                    id="strength_unit{{ $i }}" required>
                                    <option value="mcg">mcg</option>
                                    <option value="mg">mg</option>
                                    <option value="g">g</option>
                                    <option value="mL">mL</option>
                                    <option value="L">L</option>
                                    <option value="IU">IU</option>
                                </select></td>
                            <td><button type="button" class="btn btn-danger w-100" id="add_med_btn"
                                    onclick='remove_insert("med{{ $i }}")'>
                                    <i class="bi bi-trash"></i>
                                </button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

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

            const meds = document.createElement("tr");
            meds.id = "med" + i;
            // meds.classList.add('row');
            // meds.classList.add('g-2');
            meds.innerHTML =
                `
                <td>
                    ${i}
                </td>
                <td><input type="text" class="form-control" placeholder="Medicine Name" name="name[]"
                        id="name${i}" value="" required></td>
                <td><input type="text" class="form-control" placeholder="Medicine Manufacturer"
                        name="manufacturer[]" id="manufacturer${i}" value="" required></td>
                <td><input type="number" class="form-control" min="1" step="1"
                        name="package_count[]" id="package_count${i}" value="1" required></td>
                <td><input type="date" class="form-control" name="expired_date[]" id="expired_date${i}"
                        min="{{ date('Y-m-d') }}" value="" required></td>
                <td><select class="form-select" name="package_type[]" id="package_type${i}" required>
                        <option selected disabled value="">Select package</option>
                        <option value="box">Box</option>
                        <option value="bottle">Bottle</option>
                        <option value="blister_pack">Blister pack</option>
                        <option value="carton">Carton</option>
                        <option value="bag">Bag</option>
                        <option value="vial">Vial</option>
                        <option value="ampoule">Ampoule</option>
                        <option value="sachet">Sachet</option>
                        <option value="strip">Strip</option>
                    </select></td>
                <td><input type="number" class="form-control" min="1" step="1" name="units_per_package[]"
                        id="units_per_package${i}" value="1" required></td>
                <td><select class="form-select" name="dispensing_unit[]" id="dispensing_unit${i}" required>
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
                    </select></td>
                <td><select class="form-select" name="medicine_type[]" id="medicine_type${i}" required>
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
                    </select></td>
                <td><input type="number" class="form-control" placeholder="e.g. 500" min="0.001" step="0.001"
                        name="strength_value[]" id="strength_value${i}" value="" required></td>
                <td><select class="form-select w-100 " name="strength_unit[]" id="strength_unit${i}" required>
                        <option value="mcg">mcg</option>
                        <option value="mg">mg</option>
                        <option value="g">g</option>
                        <option value="mL">mL</option>
                        <option value="L">L</option>
                        <option value="IU">IU</option>
                    </select></td>
                <td><button type="button" class="btn btn-danger w-100" id="add_med_btn"
                        onclick='remove_insert("med${i}")'>
                        <i class="bi bi-trash"></i>
                    </button></td>
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
