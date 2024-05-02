@extends('pdf.layout')

@section('content')
    <h1 class="no_margin" style="margin: 4px;">Medicine Reports</h1>

    <table>
        <thead>
            <tr>
                <th class="text-start radius-left radius-right">Medicines</th>
                <th class="text-start radius-left radius-right">Quantity</th>
                <th class="text-start radius-left radius-right">Despensed</th>
            </tr>
        </thead>
        <tbody>
            <tr class="text-center">
                <td>
                    <p class="no_margin" style="">{{ $added_medicine }}+</p>
                    <h1 class="no_margin" style="font-size: 50px;padding:0px">{{ $total_medicine }}</h1>
                </td>
                <td>
                    <p class="no_margin" style="">{{ $added_quantity }}+</p>
                    <h1 class="no_margin" style="font-size: 50px;padding:0px">{{ $total_quantity }}</h1>
                </td>
                <td>
                    <p class="no_margin" style="">{{ $added_despensed }}+</p>
                    <h1 class="no_margin" style="font-size: 50px;padding:0px">{{ $total_despensed }}</h1>
                </td>
            </tr>
        </tbody>
    </table>

    {{-- available in stock --}}
    <table>
        <thead>
            <tr>
                <th class="text-start radius-left" colspan="2">In Stock (Greater than 100)</th>
                <th class="text-end radius-right" colspan="1" style="width: 15%">Total : {{ $good_stock }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($good_stock_meds as $med)
                <tr>
                    <td style="width: 10%">{{ $med->medicine_id }}</td>
                    <td>{{ $med->name }}</td>
                    <td class="text-center">{{ $med->quantity }}</td>
                </tr>
            @empty
                <tr>
                    <td>
                        <h1 class="text-muted">No medicine yet</h1>
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>

    {{-- low on stock --}}
    <table>
        <thead>
            <tr>
                <th class="text-start radius-left" colspan="2" style="background-color: #ffc107">Low In Stock (Less than 100)</th>
                <th class="text-end radius-right" colspan="1" style="background-color: #ffc107;width: 15%">Total : {{ $low_stock }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($low_stock_meds as $med)
                <tr>
                    <td style="width: 10%">{{ $med->medicine_id }}</td>
                    <td>{{ $med->name }}</td>
                    <td class="text-center">{{ $med->quantity }}</td>
                </tr>
            @empty
                <tr>
                    <td>
                        <h1 class="text-muted">No medicine yet</h1>
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>

    {{-- out of stock --}}
    <table>
        <thead>
            <tr>
                <th class="text-start radius-left" colspan="2" style="background-color: #dc3545">Out of Stock (Equals to 0)</th>
                <th class="text-end radius-right" colspan="1" style="background-color: #dc3545;width: 15%">Total : {{ $out_of_stock }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($out_of_stock_meds as $med)
                <tr>
                    <td style="width: 10%">{{ $med->medicine_id }}</td>
                    <td>{{ $med->name }}</td>
                    <td class="text-center">{{ $med->quantity }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">
                        <h1 class="text-center no_margin" style="color: #6c757d">No medicine yet</h1>
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>
@endsection
