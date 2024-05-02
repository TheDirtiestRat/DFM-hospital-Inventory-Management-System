<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DFM Center</title>

    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="{{ url('bootstrap-icons/font/bootstrap-icons.css') }}">
    {{-- additional header links --}}
    @yield('link')
</head>

<body>
    <div class="d-flex" id="wrapper">
        {{-- depending on the user type the side bar changes --}}

        <!-- Sidebar-->
        @include('components.sidebar')

        <!-- Page content wrapper-->
        <div class="ps-3 pe-3 pb-3 content-fixed" id="page-content-wrapper">
            <!-- Top navigation-->
            @include('components.topbar')

            <!-- Page content-->
            <div class="bg-white container-fluid rounded-4 p-md-3 shadow">
                {{-- contents to be put --}}
                @yield('content')
            </div>
        </div>
    </div>
</body>

</html>
