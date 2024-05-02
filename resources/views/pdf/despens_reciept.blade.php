@extends('pdf.layout')

@section('content')
    <h1 class="no_margin" style="margin: 4px;">Despense Medicine Reciept</h1>
    <table class="no-borders no_margin">
        <tr>
            <td>
                <h4 class="no_margin" style="margin: 4px;">Case Number : {{ $patient->case_no }}</h4>
            </td>
            <td style="width: 25%;">
                <p class="no_margin float-end">Date today : {{ date('Y-m-d') }}</p>
            </td>
        </tr>
    </table>

    <table class="pad-3" style="width: 100%;">
        <thead>
            <tr>
                <th colspan="2" class="text-start radius-left radius-right">
                    Patient Information <span class="">Age: ({{ $patient->age }})</span>
                </th>
                <th colspan="2" class="text-start radius-left radius-right">Patient Diagnosis</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width: 30%" colspan="2"><strong>Name :</strong>
                    {{ $patient->first_name . ' ' . $patient->mid_name . ' ' . $patient->last_name }}</td>
                    <td><strong>Diagnosis :</strong> {{ $patient_case->diagnosis }}</td>
                <td><strong>Treatment :</strong> {{ $patient_case->treatment }}</td>
            </tr>
        </tbody>
    </table>

    <table class="pad-3">
        <thead>
            <tr>
                <th colspan="3" class="text-start radius-left radius-right">Despensed Medicine</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="" style="width: 10%"><strong>No.</strong></td>
                <td class="" style="width: 70%"><strong>Medicine Name</strong></td>
                <td class="" style="width: 10%"><strong>Quantity</strong></td>
            </tr>
            @foreach ($despensed_medicines as $medicine)
                <tr>
                    <td style="padding: 6px">{{ $medicine['id'] }}</td>
                    <td>{{ $medicine['medicine'] }}</td>
                    <td>{{ $medicine['quantity'] }}</td>
                </tr>
            @endforeach
            {{-- @for ($i = 1; $i < count($despensed_medicines); $i++)
                <tr>
                    <td style="padding: 6px">{{ $i }}</td>
                    <td></td>
                    <td></td>
                </tr>
            @endfor --}}
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="text-end"><strong>Total :</strong></td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    {{-- signatures --}}
    <table class="no-borders no_margin">
        <tr>
            <td class="text-center" style="width: 30%; height: 100px;">
                <hr>
                <p>Doctor's Signature</p>
            </td>
            {{-- <td></td>
            <td class="text-center" style="width: 30%; height: 100px;">
                <hr>
                <p>Patient's Signature</p>
            </td> --}}
        </tr>
    </table>
@endsection
