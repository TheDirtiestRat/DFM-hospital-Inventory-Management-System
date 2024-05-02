@extends('pdf.layout')

@section('content')
    <h1 class="no_margin" style="margin: 4px;">Patient Info Sheet</h1>
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
                <td class="no-border_bot" style="width: 30%"><strong>Name :</strong>
                    {{ $patient->first_name . ' ' . $patient->mid_name . ' ' . $patient->last_name }}</td>
                <td class="no-border_bot" style="width: 30%"><strong>Birth Date :</strong> {{ $patient->birth_date }}</td>
                <td class="no-border_bot"><strong>Admission Date</strong></td>
                <td class="no-border_bot"><strong>Time Arrival</strong></td>
            </tr>
            <tr>
                <td class="no-border_bot"><strong>Gender :</strong> {{ $patient->gender }}</td>
                <td class="no-border_bot"><strong>Blood Type :</strong> {{ $patient->blood_type }}</td>
                <td> {{ $patient_case->admit_date }}</td>
                <td> {{ $patient_case->arrive_time }}</td>
            </tr>
            <tr>
                <td><strong>Religion :</strong> {{ $patient->religion }}</td>
                <td><strong>Birth Place :</strong> {{ $patient->birth_place }}</td>
                <td class="no-border_bot"><strong>Diagnosis</strong></td>
                <td class="no-border_bot"><strong>Treatment</strong></td>
            </tr>
            <tr>
                <td class=""><strong>Contact No. :</strong> {{ $patient->contact_no }}</td>
                <td class=""><strong>Citizenship :</strong> {{ $patient->citizenship }}</td>
                <td> {{ $patient_case->diagnosis }}</td>
                <td> {{ $patient_case->treatment }}</td>
            </tr>
            <tr>
                <td colspan="4"><strong>Address :</strong> {{ $patient->address }}</td>
            </tr>
            <tr>
                <td colspan="2" style="height: 80px;vertical-align: top;"><strong>Remarks :</strong> {{ $patient_case->remarks }}</td>
                <td colspan="2" style="height: 40px;"></td>
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
            @for ($i = 1; $i <= 8; $i++)
                <tr>
                    <td style="padding: 6px">{{ $i }}</td>
                    <td></td>
                    <td></td>
                </tr>
            @endfor
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
            <td></td>
            <td class="text-center" style="width: 30%; height: 100px;">
                <hr>
                <p>Patient's Signature</p>
            </td>
        </tr>
    </table>
@endsection
