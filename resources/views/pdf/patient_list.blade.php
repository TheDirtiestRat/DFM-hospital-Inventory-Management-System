@extends('pdf.layout')

@section('content')
    <h1 class="no_margin" style="margin: 4px;">Patients List</h1>

    <table>
        <thead>
            <tr>
                <th class="text-start radius-left">ID</th>
                <th class="text-start">Patient</th>
                <th class="text-start">Diagnosis</th>
                <th class="text-start radius-right">Record At</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($patients as $patient)
                <tr>
                    <td>{{ $patient->case_no }}</td>
                    <td>{{ $patient->first_name }} {{ $patient->mid_name }} {{ $patient->last_name }}</td>
                    <td>{{ $patient->diagnosis }}</td>
                    <td>{{ $patient->created_at }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class=" text-muted ">No Patients</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
