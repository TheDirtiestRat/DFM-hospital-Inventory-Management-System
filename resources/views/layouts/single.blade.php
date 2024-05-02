<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="{{ url('bootstrap-icons/font/bootstrap-icons.css') }}">
    {{-- additional header links --}}
    @yield('link')
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Page content wrapper-->
        <div class="ps-3 pe-3 pb-3 content-fixed" id="page-content-wrapper">
            <!-- Top navigation-->
            <nav
                class="text-bg-primary navbar navbar-expand-lg navbar-light w-100 rounded-4 rounded-top shadow-sm p-3 mb-3">
                <div class="container-fluid p-0">
                    <a href="{{ route('medicine.index') }}" class="btn btn-light rounded-3">
                        <i class="bi bi-card-list"></i>
                    </a>

                    <!-- dropdown list -->
                    <button class="navbar-toggler p-2 text-bg-light" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <i class="bi bi-list-task"></i>
                    </button>

                    {{-- dropdown --}}
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">

                        <ul class="navbar-nav ms-auto gap-2 mt-2 mt-lg-0 float-md-none">
                            {{-- options list --}}
                            <li class="nav-item dropdown">
                                <a href="{{ route('user.show', Auth::user()->id) }}" class=" text-decoration-none">
                                    <button class="btn btn-outline-light rounded-3 w-100"
                                        type="button">{{ Auth::user()->name }} -
                                        <strong>{{ Auth::user()->type }}</strong></button>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <form action="{{ url('logoutUser') }}" method="post">
                                    {{-- validation --}}
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-light rounded-3 w-100" type="submit">
                                        Logout
                                        <i class="bi bi-power"></i>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>


            <!-- Page content-->
            <div class="bg-white container-fluid rounded-4 p-md-3 shadow">
                {{-- contents to be put --}}
                @yield('content')
            </div>
        </div>
    </div>
</body>

</html>
