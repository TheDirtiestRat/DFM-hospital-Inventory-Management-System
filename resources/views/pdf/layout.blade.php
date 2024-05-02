<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reports</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        .d-none {
            display: none;
        }

        .p-0 {
            padding: 0px;
        }

        /* table,
        td,
        th {
            border: 1px solid;
        } */

        td {
            border-bottom: 1px solid black;
            /* border: 1px solid black; */
            font-size: 12px;
            padding: 4px;
        }

        .no-border_bot {
            border-bottom: 0px solid black;
        }

        th {
            font-size: 16px;
        }

        hr {
            margin: 4px;
        }

        /* h3 {
            font-style: oblique;
        } */

        h2,
        h3,
        h5 {
            margin: 5px;
        }

        .text-start {
            text-align: left;
        }

        .text-end {
            text-align: right;
        }

        th {
            border: 1px solid;
            color: white;
            background-color: #0d6efd;
            padding: 8px 12px 8px 12px;
            height: 25px;
        }

        .radius-left {
            border-top-left-radius: 16px;
        }

        .radius-right {
            border-top-right-radius: 16px;
        }

        .float-end {
            float: right;
        }

        table.no-borders table,
        table.no-borders th,
        table.no-borders td {
            border: 0;
        }

        .pad-3 td {
            padding: 8px 8px 14px 8px;
        }

        .pad-5 {
            padding: 0 0 50px 0;
            height: 150px
        }

        .no-borders {
            border: 0;
        }

        table {
            width: 100%;
            /* text-align: center; */
            border-collapse: collapse;
            border-radius: 16px 16px 0px 0px;
            margin-bottom: 15px;
        }

        .no-spc-cell {

            border-collapse: collapse;
            /* border: 1px solid black; */
        }

        .no-spc-cell td {
            /* border: 1px solid black; */
            padding: 0px;
        }

        .table-dark {
            background: black;
            color: white;
            border: 1px solid black;
        }

        p {
            margin: 0;
        }

        .text-center {
            text-align: center;
        }

        .center {
            display: block;
            justify-content: center;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            margin: 4px;
            text-align: center;
        }

        .footer p {
            margin: 0;
            color: gray;
            font-size: 12px;
        }

        .no_margin {
            margin: 0px;
        }

        .row {
            display: flex;
        }

        .box {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 8px;
            border: 1px solid black;
            border-radius: 16px;
            width: 100px;
            height: 100px;

        }

        .c-box {
            display: inline-block;
            width: 100px;
            height: 100px;
            position: relative;
            padding: 8px;
            border: 1px solid black;
            border-radius: 16px;
        }

        .c-b-child {
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .column {
            flex: 50%;
        }
    </style>
</head>

<body>
    {{-- header --}}
    <header>
        <table class="no-borders no_margin">
            <tr>
                <td class="text-center ">
                    {{-- <h1>Test</h1> --}}
                    <img src="{{ $img_logo }}" alt="" width="60">
                </td>
                <td class="text-start ">
                    <h3 class="no_margin">@include('components.title')</h3>
                    <h4 class="no_margin">ACLC COLLEGE OF ORMOC CITY, INC</h4>
                    {{-- <p>A pdf report : {{ date('l jS \of F Y h:i:s A') }}</p> --}}
                </td>
            </tr>
        </table>
    </header>

    <section style="width: 100%; position: relative;">
        @yield('content')
    </section>

    {{-- footer --}}
    <footer class="footer">
        <p>A pdf report : {{ date('l jS \of F Y h:i:s A') }}</p>
    </footer>
</body>

</html>
