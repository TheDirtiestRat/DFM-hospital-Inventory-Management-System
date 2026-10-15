@extends('pdf.layout')

@section('content')
    <div class="text-center" style="margin: 24px 0;">
        <h1 style="font-size: 24px;">MEDICAL CERTIFICATE</h1>
        <p style="font-size: 12px;">For review and signature by an authorized healthcare professional</p>
    </div>

    <table>
        <tbody>
            <tr>
                <td style="width: 35%;"><strong>Certificate date</strong></td>
                <td>{{ $issuedAt->format('F j, Y') }}</td>
            </tr>
            <tr>
                <td><strong>Patient case number</strong></td>
                <td>{{ $patient->case_no }}</td>
            </tr>
            <tr>
                <td><strong>Patient name</strong></td>
                <td>{{ $patient->first_name }} {{ $patient->mid_name }} {{ $patient->last_name }}</td>
            </tr>
            <tr>
                <td><strong>Date of birth / Age</strong></td>
                <td>{{ $patient->birth_date }} / {{ $patient->age }}</td>
            </tr>
            <tr>
                <td><strong>Gender</strong></td>
                <td>{{ $patient->gender }}</td>
            </tr>
            <tr>
                <td><strong>Address</strong></td>
                <td>{{ $patient->address }}</td>
            </tr>
            <tr>
                <td><strong>Recorded diagnosis</strong></td>
                <td>{{ $patientCase?->diagnosis ?: 'No diagnosis recorded' }}</td>
            </tr>
            <tr>
                <td><strong>Purpose</strong></td>
                <td>{{ $certificateData['purpose'] }}</td>
            </tr>
        </tbody>
    </table>

    <p style="margin: 28px 4px;">
        This certificate is prepared from the patient information and recorded case details shown above.
        The issuing healthcare professional must verify the information and determine whether to certify it.
    </p>

    <table class="no-borders" style="margin-top: 100px;">
        <tr>
            <td class="text-center" style="width: 55%;"></td>
            <td class="text-center" style="width: 45%; padding-top: 36px;">
                <hr>
                <strong>Authorized Healthcare Professional</strong><br>
                Signature and license number
            </td>
        </tr>
    </table>
@endsection
