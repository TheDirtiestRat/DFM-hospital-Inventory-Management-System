@extends('pdf.layout')

@section('content')
    <h1 class="no_margin" style="margin: 4px;">Patients Records Reports</h1>

    {{-- totals --}}
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

    {{-- Age groups --}}
    <table>
        <thead>
            <tr>
                <th class="text-start radius-left radius-right" colspan="4">Age</th>
            </tr>
        </thead>
        <tbody>
            <tr class="text-center">
                <td>
                    <strong>Child</strong>
                    {{ $child }}
                </td>
                <td>
                    <strong>Teen</strong>
                    {{ $teen }}
                </td>
                <td>
                    <strong>Adult</strong>
                    {{ $adult }}
                </td>
                <td>
                    <strong>Señor Citizen</strong>
                    {{ $old }}
                </td>
            </tr>
        </tbody>
    </table>

    {{--  --}}
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

    {{-- recent patient --}}
@endsection
