@extends('pdf.layout')

@section('content')
    <h1 class="no_margin" style="margin: 4px;">Overall Reports</h1>

    {{-- totals patients--}}
    <table>
        <thead>
            <tr>
                <th class="text-start radius-left radius-right">Patients</th>
                <th class="text-start radius-left radius-right">Today</th>
                <th class="text-start radius-left radius-right">Despensed</th>
            </tr>
        </thead>
        <tbody>
            <tr class="text-center">
                <td>
                    <p class="no_margin" style="">{{ $total_today }}+</p>
                    <h1 class="no_margin" style="font-size: 50px;padding:0px">{{ $total_patient }}</h1>
                </td>
                <td>
                    {{-- <p class="no_margin" style="">{{ $added_quantity }}+</p> --}}
                    <h1 class="no_margin" style="font-size: 50px;padding:0px">{{ $total_today }}</h1>
                </td>
                <td>
                    <p class="no_margin" style="">{{ $added_despensed }}+</p>
                    <h1 class="no_margin" style="font-size: 50px;padding:0px">{{ $total_despensed }}</h1>
                </td>
            </tr>
        </tbody>
    </table>

    {{-- stats --}}
    <table>
        <thead>
            <tr>
                <th class="text-start radius-left ">Sex</th>
                <th class="text-start ">Blood Types</th>
                <th class="text-start radius-right">Diagnosis</th>
            </tr>
        </thead>
        <tbody>
            <tr class="text-center">
                <td style="width: 25%;vertical-align: top;">
                    <table>
                        @foreach ($total_by_gender as $gender)
                            <tr>
                                <td class="no-borders">{{ $gender->gender }}</td>
                                <td class="text-center no-borders"><strong>{{ $gender->total }}</strong></td>
                            </tr>
                        @endforeach
                    </table>
                </td>
                <td style="width: 30%;vertical-align: top;">
                    <table>
                        @for ($i = 0, $n = 0; $i < 3; $i++)
                            <tr>
                                @for ($j = 0; $j < 2; $j++, $n++)
                                    @if ($n < $total_by_bloodType->count())
                                        <td class="no-borders">{{ $total_by_bloodType[$n]->blood_type }}</td>
                                        <td class="text-center no-borders">
                                            <strong>{{ $total_by_bloodType[$n]->total }}</strong>
                                        </td>
                                    @endif
                                @endfor
                            </tr>
                        @endfor
                    </table>
                </td>
                <td style="vertical-align: top;">
                    <table>
                        @for ($i = 0, $n = 0; $i < $total_by_diagnosis->count() - 3 ; $i++)
                            <tr>
                                @for ($j = 0; $j < 2; $j++, $n++)
                                    @if ($n < $total_by_diagnosis->count())
                                        <td class="no-borders">{{ $total_by_diagnosis[$n]->diagnosis }}</td>
                                        <td class="text-center no-borders">
                                            <strong>{{ $total_by_diagnosis[$n]->total }}</strong>
                                        </td>
                                    @endif
                                @endfor
                            </tr>
                        @endfor
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    {{-- available in stock --}}
    <table>
        <thead>
            <tr>
                <th class="text-start radius-left" colspan="2">New Patients this Month {{ date('F') }}</th>
                <th class="text-end radius-right" colspan="1" style="width: 25%">Total : {{ $new_patients->count() }}
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th style="padding: 4px;font-size: 12px">Case No.</th>
                <th style="padding: 4px;font-size: 12px">Patient name</th>
                <th style="padding: 4px;font-size: 12px">Diagnosis</th>
            </tr>
            @forelse ($new_patients as $patient)
                <tr>
                    <td style="width: 15%">{{ $patient->case_no }}</td>
                    <td>{{ $patient->first_name }} {{ $patient->mid_name }} {{ $patient->last_name }}</td>
                    <td class="text-center">{{ $patient->diagnosis }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">
                        <h1 class="no_margin">No patients yet</h1>
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>

    {{-- stocks --}}
    {{-- totals medicine --}}
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
