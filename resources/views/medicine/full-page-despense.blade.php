<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Despense Medicines</title>

    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="{{ url('bootstrap-icons/font/bootstrap-icons.css') }}">
    {{-- additional header links --}}
    <style>
        body {
            height: 100vh;
        }

        .h-full {
            height: 300px;
        }
    </style>
</head>

<body class="">
    <div class="d-flex flex-column gap-3 h-100 p-3 table-responsive">
        {{-- <div class=" d-flex align-items-center gap-3 flex-row text-bg-primary shadow rounded-3 p-3">
            <a href="{{ route('medicine.index') }}" class="btn btn-light rounded-3">
                <i class="bi bi-card-list"></i>
            </a>
            <h1 class="m-0">Despense Medicine</h1>
        </div> --}}
        <div class="d-flex flex-column flex-md-row gap-3 h-100">
            <div class="d-flex flex-column gap-3 w-100">
                <div class="d-flex flex-row align-items-center gap-3">
                    <a href="{{ route('medicine.index') }}" class="btn btn-secondary shadow rounded-3">
                        <i class="bi bi-card-list"></i>
                    </a>
                    <div class="d-flex p-1 w-100">
                        <h2 class="text-center m-0">Despense Medicines</h2>
                    </div>
                    <div class="w-100">
                        <input type="search" class="form-control h-100" id="searchbar" name="searchbar"
                            placeholder="Search medicine...">
                    </div>
                    <button class="btn btn-primary" id="searchBtn">Search</button>
                </div>

                {{-- alert --}}
                @include('components.alert')

                <div class="text-bg-secondary shadow rounded-3 p-3 w-100 h-100 overflow-y-scroll"
                    id="Medicine_list_area">
                    {{-- list of medicines area --}}
                    @include('components.medicineDespenseList')
                </div>
            </div>


            <form action="{{ url('despenseMedicineReciept') }}" method="post" class="needs-validations"
                enctype="multipart/form-data" novalidat>
                {{-- for validation --}}
                @csrf
                <div class="d-flex flex-column flex-shrink-0 gap-3 h-100" style="width: 300px">
                    <div class="text-bg-primary shadow rounded p-3">
                        <h3>Despense Info</h3>
                        {{-- despenser (the one who gives the medicines) --}}
                        <input type="text" class="visually-hidden " name="despenser" value="{{ Auth::user()->name }}"
                            id="">
                        {{-- doctor --}}
                        {{-- patient --}}
                        <label for="doc_license_no" class="form-label">Doctor License No.</label>
                        <input type="number" class="form-control mb-2" placeholder="999999" name="doc_license_no"
                            id="doc_license_no" list="doctor_list" value="" required>
                        <datalist id="doctor_list">
                            {{-- list of barangays --}}
                            @foreach ($doctors as $doc)
                                <option value="{{ $doc->license_no }}">{{ $doc->full_name }}</option>
                            @endforeach
                        </datalist>
                        {{-- patient --}}
                        <label for="patient_case_id" class="form-label">Patient Case Id</label>
                        <input type="number" class="form-control" placeholder="999999" name="patient_case_id"
                            id="patient_case_id" list="patient_list" value="" required>
                        <datalist id="patient_list">
                            {{-- list of barangays --}}
                            @include('components.patient_case_no-despense-datalist')
                        </datalist>
                        <div class="" id="patient_info_area">
                            {{-- patient information --}}
                        </div>
                    </div>
                    <div class="text-bg-light shadow rounded p-3 h-100 table-responsive">
                        <h3>Medicine List</h3>
                        {{-- list of medicines selected goes --}}
                        <table class="table">
                            <thead>
                                <tr class=" text-light">
                                    <th>Medicine</th>
                                    <th class="text-end">Qnt</th>
                                    <th class="text-end">Del</th>
                                </tr>
                            </thead>
                            <tbody id="selected_medicine_area">
                                {{-- meds list area --}}
                            </tbody>
                        </table>
                    </div>
                    <button class="btn btn-primary rounded-3 w-100 mt-auto flex-col" type="submit">
                        Despense
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-bg-danger">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Error</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal_show_medicine_details">
                    Out of Stock.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- insert new input script --}}
    <script>
        function add_medicine(id, name, med_id, remaining) {
            // reduce the quantity
            const remElem = document.getElementById(remaining);
            let return_quan = 0;

            // check if ther is still remaining
            if (remElem.innerHTML <= 0) {
                // call the modal
                const myModal = new bootstrap.Modal('#warningModal');
                const modalToggle = document.getElementById('warningModal');
                myModal.show(modalToggle);
                return;
            } else {
                var rem = remElem.innerHTML;
                rem -= 1;
                return_quan += 1;
                remElem.innerHTML = rem;
                // console.log(remElem.innerHTML);
            }

            // check if that element exist then add to that element only
            const exist_elem = document.getElementById("med" + id);
            if (exist_elem) {
                // console.log("is Exist");
                var elem_id = "med" + id;
                // const quantity_output = document.
                // var quantity_elem = document.querySelector('#' + elem_id + ' #quantity');
                // var quantity_input = document.querySelector('#quantity_input'+med_id);
                var quantity_input = document.getElementById('quantity_input' + med_id);
                var quantity = parseInt(quantity_input.value);
                quantity += 1
                // quantity_elem.innerHTML = quantity;
                quantity_input.value = quantity;
                console.log(quantity_input.value);
                // console.log(document.querySelector('#' + elem_id + ' #quantity'));
                return;
            }

            // create the element
            const para = document.createElement("tr");
            para.id = "med" + id;
            para.innerHTML = `
                                <td>${name}</td>
                                <td class="text-end" id="quantity"><input type="number" class="form-control w-100" name="quantity[]" value="1" id="quantity_input${med_id}"></td>
                                <td class="">
                                    <button class="btn btn-sm btn-danger rounded-3 w-100" type="button" onclick="remove_medicine('med${id}', 'remaining${med_id}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    
                                    <div class="visually-hidden">
                                        <input type="text" name="medicine[]" value="${med_id}" id="medicines_input">
                                        
                                    </div>
                                </td>
                            `;

            // add to the list element
            document.getElementById("selected_medicine_area").appendChild(para);

            // update
            // get_data_inputs();
        }

        function remove_medicine(elem_id, return_elem) {
            const quantity_elem = document.querySelector('#' + elem_id + ' #quantity');

            // get the parent and the child node
            const parent = document.getElementById('selected_medicine_area');
            const node_to_return = document.getElementById(return_elem);
            const node_to_remove = document.getElementById(elem_id);

            if (node_to_return != null) {
                // return the quantity
                let return_amount = parseInt(node_to_return.innerHTML) + parseInt(quantity_elem.innerHTML);
                node_to_return.innerHTML = return_amount;
            }

            // remove the element
            parent.removeChild(node_to_remove);

            // update
            // get_data_inputs();
        }
    </script>
    {{-- search ajax script --}}
    <script type="module">
        $('#searchbar').on('keyup', function() {
            var $value = $(this).val();
            // search_medicine($value);
            search_form({
                'key': $value,
                'despensed_list': true,
            }, "{{ url('search_medicine') }}", '#Medicine_list_area');
        });

        // case_no input
        $('#patient_case_id').on('keyup', function() {
            // get_patient_details($(this).val());
            search_form({
                'case_no': $(this).val()
            }, "{{ url('getPatientToDespense') }}", '#patient_info_area');
            search_form({
                'case_no': $(this).val()
            }, "{{ url('getPatientDatalist') }}", '#patient_list');
            // update
            // get_data_inputs();
        });

        // ajax function
        function search_form(_data, _url, output) {
            // console.log($search_key)
            $.ajax({
                url: _url,
                type: "GET",
                data: _data,
                success: function(data) {
                    $(output).html(data);
                }
            })
        }
    </script>
</body>

</html>
