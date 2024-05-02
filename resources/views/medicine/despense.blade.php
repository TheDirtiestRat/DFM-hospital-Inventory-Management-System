@extends('layouts.app')

@section('content')
    <h1 class="text-center">Despense Medicine</h1>
    <hr>

    {{-- alert --}}
    @include('components.alert')

    <form action="{{ url('recordDespenseMedicine') }}" method="post" class="needs-validations" enctype="multipart/form-data"
        novalidat>
        {{-- for validation --}}
        @csrf

        <div class="row g-2">
            <div class="col-md-4 d-flex flex-column">
                <div class="">
                    <div class="row gap-2">
                        <div class="col-12">
                            {{-- despenser (the one who gives the medicines) --}}
                            <input type="text" class="visually-hidden " name="despenser" value="{{ Auth::user()->name }}"
                                id="">
                            {{-- patient --}}
                            <label for="patient_case_id" class="form-label">* Patient Case Id</label>
                            <input type="number" class="form-control mb-3" placeholder="999999" name="patient_case_id"
                                id="patient_case_id" value="" required>
                        </div>
                        <div class="col-12" id="patient_info_area">
                            {{-- patient information --}}
                            <div class="text-bg-primary rounded-3 p-3">
                                <p class="m-0 text-center">
                                    Patient Info show here
                                </p>
                            </div>

                        </div>
                    </div>

                    <hr>

                    <div class="row g-1">
                        <div class="col-12">
                            <h4 class="m-0 mb-2">Medicines</h4>
                        </div>
                        {{-- list of medicines to record --}}
                        <div class="col-12 table-responsive">
                            {{-- list of medicines selected goes --}}
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Medicine</th>
                                        <th class="text-end">Quantity</th>
                                        <th class=""></th>
                                    </tr>
                                </thead>
                                <tbody id="selected_medicine_area">
                                    {{-- meds list area --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <hr class="mb-4">

                <div class="row justify-content-center">
                    <div class="col">
                        <button class="btn btn-primary rounded-3 w-100 " type="submit">
                            Despense
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-8 h-100">

                {{-- search bar --}}
                <label for="searchbar" class="form-label">Search Medicines</label>
                <div class="row gap-2 m-0">
                    <div class="col p-0">

                        <input type="search" class="form-control" id="searchbar" name="searchbar"
                            placeholder="Search medicine...">
                    </div>
                    <div class="col-auto p-0">
                        <button class="btn btn-primary" id="searchBtn">Search</button>
                    </div>
                </div>
                {{-- get the list of medicines --}}
                <div class=" overflow-y-auto" id="Medicine_list_area" style="">
                    {{-- get Medicine list --}}
                    @include('components.medicineDespenseList')
                </div>
            </div>
        </div>
    </form>

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
                const quantity_elem = document.querySelector('#' + elem_id + ' #quantity');
                const quantity_input = document.querySelector('#' + elem_id + ' #quantity_input');
                var quantity = parseInt(quantity_elem.innerHTML);
                quantity += 1
                quantity_elem.innerHTML = quantity;
                quantity_input.value = quantity;
                // console.log(document.querySelector('#' + elem_id + ' #quantity'));
                return;
            }

            // create the element
            const para = document.createElement("tr");
            para.id = "med" + id;
            para.innerHTML = `
                                <td>${name}</td>
                                <td class="text-end" id="quantity">1</td>
                                <td class="">
                                    <button class="btn btn-sm btn-danger rounded-3 w-100" type="button" onclick="remove_medicine('med${id}', 'remaining${med_id}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <div class="d-none">
                                        <input type="text" name="medicine[]" value="${med_id}" id="medicines_input">
                                        <input type="number" name="quantity[]" value="1" id="quantity_input">
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
@endsection
