@extends('pdf.layout')

@section('content')
    <div class="text-center" style="margin: 16px 0;">
        <p style="color: #b02a37; font-weight: bold; letter-spacing: 1px;">DRAFT — FOR PHYSICIAN REVIEW</p>
        <h1 style="font-size: 24px;">DEATH CERTIFICATE</h1>
        <p style="font-size: 11px;">Draft for clinical review; not an official government death certificate.</p>
    </div>

    <table>
        <tbody>
            <tr>
                <td style="width: 35%;"><strong>Patient case number</strong></td>
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
                <td><strong>Date of death</strong></td>
                <td>{{ \Illuminate\Support\Carbon::parse($certificateData['death_date'])->format('F j, Y') }}</td>
            </tr>
            <tr>
                <td><strong>Time of death</strong></td>
                <td>{{ \Illuminate\Support\Carbon::createFromFormat('H:i', $certificateData['death_time'])->format('g:i A') }}</td>
            </tr>
            <tr>
                <td><strong>Place of death</strong></td>
                <td>{{ $certificateData['death_place'] }}</td>
            </tr>
            <tr>
                <td><strong>Reported cause of death</strong></td>
                <td>{{ $certificateData['cause_of_death'] }}</td>
            </tr>
            <tr>
                <td><strong>Certifying physician</strong></td>
                <td>{{ $certificateData['certifier_name'] }}</td>
            </tr>
            <tr>
                <td><strong>Professional license number</strong></td>
                <td>{{ $certificateData['certifier_license'] }}</td>
            </tr>
        </tbody>
    </table>

    <p style="margin: 20px 4px; font-size: 11px;">
        All reported death information and patient details must be reviewed and verified by the certifying physician.
        This draft does not establish or independently determine a cause of death and is not valid without
        the certifier's review and signature.
    </p>

    <table class="no-borders" style="margin-top: 48px;">
        <tr>
            <td class="text-center" style="width: 55%;"></td>
            <td class="text-center" style="width: 45%; padding-top: 36px;">
                <hr>
                <strong>{{ $certificateData['certifier_name'] }}</strong><br>
                Certifying Physician<br>
                License No. {{ $certificateData['certifier_license'] }}<br>
                Signature
            </td>
        </tr>
    </table>
@endsection
