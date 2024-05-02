<table class="table table-hover m-0" style="width: 100%">
    <thead>
        <tr>
            <th scope="col">CASE-NUMBER</th>
            <th scope="col">NAME</th>
            <th scope="col">DIAGNOSIS</th>
            <th scope="col">GENDER</th>
        </tr>
    </thead>
    <tbody>
        @for ($i = 0; $i < 16; $i++)
            <tr>
                <td scope="row" style="width: 20%">
                    {{-- MRN: <strong>0999991</strong> --}}
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        MRN: <strong>0999991</strong>
                    </button>
                </td>
                <td>Mark Jhon Doe</td>
                <td>Mild Fever</td>
                <td>Male</td>
            </tr>
        @endfor
    </tbody>
</table>
