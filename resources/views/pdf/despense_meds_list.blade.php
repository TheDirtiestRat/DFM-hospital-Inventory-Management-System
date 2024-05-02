@extends('pdf.layout')

@section('content')
    <h1 class="no_margin" style="margin: 4px;">Medicine Despense List ({{ $despensed_meds->count() }})</h1>
    
    <table>
        <thead>
            <tr>
                <th class="text-start radius-left">ID No.</th>
                <th class="text-start">Medicine</th>
                <th class="text-start">Despenser</th>
                <th class="text-start">Patient</th>
                <th class="text-start">Quantity</th>
                <th class="text-start radius-right">Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($despensed_meds as $medicine)
                <tr>
                    <td>{{ $medicine->medicine_id }}</td>
                    <td>{{ $medicine->name }}</td>
                    <td>{{ $medicine->despenser }}</td>
                    <td>({{ $medicine->case_no }})
                        {{ $medicine->first_name }} {{ $medicine->mid_name }} {{ $medicine->last_name }}</td>
                    <td class="text-center">{{ $medicine->quantity }}</td>
                    <td>{{ $medicine->created_at }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class=" text-muted ">No Medicine</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
