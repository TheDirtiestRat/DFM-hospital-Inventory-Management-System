<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="{{ url('bootstrap-icons/font/bootstrap-icons.css') }}">
</head>

<body>

    {{-- content to print --}}
    <div class="container-fluid">
        @yield('content')
    </div>

    {{-- script to print quickly --}}
    <script>
        window.print();
    </script>
</body>

</html>
