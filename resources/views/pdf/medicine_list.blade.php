@extends('pdf.layout')

@section('content')
    <h1 class="no_margin" style="margin: 4px;">Medicine List</h1>

    <table>
        <thead>
            <tr>
                <th class="text-start radius-left">ID No.</th>
                <th class="text-start">Medicine</th>
                <th class="text-start">Quantity</th>
                <th class="text-start radius-right">Record At</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($medicines as $medicine)
                <tr>
                    <td>{{ $medicine->medicine_id }}</td>
                    <td>{{ $medicine->name }}</td>
                    <td>{{ $medicine->quantity }}</td>
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
