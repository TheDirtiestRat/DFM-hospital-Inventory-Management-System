<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content>
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap
      contributors">
    <meta name="generator" content="Hugo 0.104.2">
    <title>Sign in</title>

    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="{{ url('bootstrap-icons/font/bootstrap-icons.css') }}">
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            /* background-color: #f5f5f5; */
        }

        .form-signin {
            max-width: 330px;
            padding: 12px;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;
        }

        /* .form-signin input[type="text"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        } */

        /* .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        } */

        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .bg{
            display: flex;
            align-items: center;
            padding-bottom: 40px;
        background-image: linear-gradient(to top, #ffffffab, #ffffffd2),
        url('{{ asset("/storage/images/bgs.png") }}');
            background-repeat:no-repeat;
            background-position:center;
            background-size: auto 100vh;

        }

        .img-fluid {
            max-width: 100%;
            height: auto;
            object-fit: cover;
        }

        .slide-top {
            -webkit-animation: slide-top 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
            animation: slide-top 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
        }

        @-webkit-keyframes slide-top {
            0% {
                opacity: 0;
                -webkit-transform: translateY(100px);
                transform: translateY(100px);
            }

            100% {
                opacity: 1;
                -webkit-transform: translateY(-0);
                transform: translateY(0);
            }
        }

        @keyframes slide-top {
            0% {
                opacity: 0;
                -webkit-transform: translateY(100px);
                transform: translateY(100px);
            }

            100% {
                opacity: 1;
                -webkit-transform: translateY(0);
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="text-center bg">
    <div class="container slide-top" style="max-width: 800px">
        <div class="row g-2 align-items-center">
            <div class="col-12 m-0">
                <img src="{{ asset('/storage/images/ormoc.png') }}" alt="" width="55">
                <h5 class="fw-normal">@include('components.title')</h5>
            </div>
            <div class="col-md-7">
                <div class="m-3 ms-1 me-1">
                    <img src="{{ asset('/storage/images/sign-in.jpg') }}"
                        class="rounded-4 img-fluid shadow d-none d-md-block" width="" height=""
                        alt="">
                </div>
            </div>
            <div class="col-md-5">
                <main class="form-signin w-100 m-auto">
                    <form action="{{ url('loginUser') }}" class="h-100" method="POST">
                        {{-- for validation --}}
                        @csrf

                        {{-- <img src="{{ asset('/storage/images/aclc500px.png') }}" alt="" width="55"> --}}
                        {{-- <h5 class="mb-4 fw-normal">@include('components.title')</h5> --}}

                        {{-- <div class="text-bg-primary rounded-4 p-2 mb-4">
                        <h5 class="m-0 fw-normal m-0 ">Sign in User</h5>
                    </div> --}}

                        {{-- alert --}}
                        @include('components.alert')

                        <div class=" bg-primary shadow p-3 rounded-4 pb-4 h-100">
                            <p class="text-light">
                                Sign in to your user account to enter the system.
                            </p>
                            {{-- <div class="form-floating">
                        <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com">
                        <label for="floatingInput">Email address</label>
                    </div> --}}

                            <div class="form-floating mb-1">
                                <input type="text" class="form-control" style="border-radius: 8px" id="username" name="name"
                                    placeholder="Username" autocomplete="true">
                                <label for="username">Username</label>
                            </div>
                            <div class="input-group rounded-4">
                                <div class="form-floating">
                                    <input type="password" class="form-control" style="border-radius: 8px 0px 0px 8px" id="password" name="password"
                                        placeholder="Password">
                                    <label for="password">Password</label>
                                </div>
                                <span class="input-group-text" id="togglePassword" style="border-radius: 0px 8px 8px 0px"><i class="bi bi-eye"
                                        id="icon_eye"></i></span>
                            </div>
                            {{-- <div class="form-floating">
                                <input type="password" class="form-control" id="password"
                                    placeholder="Password" name="password">
                                <label for="floatingPassword">Password</label>
                            </div> --}}

                            {{-- <div class="form-floating ">
                                <input type="text" class="form-control" id="floatingInput" name="name"
                                    placeholder="Username" autocomplete="true">
                                <label for="floatingInput">Username</label>
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text"> <i class="bi bi-eye" id="togglePassword"></i></span>
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password">
                                    <label for="floatingInputGroup1">Password</label>
                                </div>

                            </div> --}}

                            {{-- <div class="form-floating">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Password">
                                <label for="password">Password <i class="bi bi-eye" id="togglePassword"></i></label>
                            </div> --}}

                            {{-- back to welcome page --}}
                            <div class="mt-2 mb-3"><a class="text-light text-decoration-none"
                                    href="{{ url('/') }}">Return to Welcome
                                    Page</a></div>

                            <button class="w-100 btn btn-light" type="submit">Sign in</button>
                        </div>


                        {{-- <div class="mt-2 text-muted">@include('components.copyright')</div> --}}
                    </form>
                </main>
            </div>
            <div class="col-12">
                <div class="mt-2 text-muted">@include('components.copyright')</div>
            </div>
        </div>
    </div>

    {{-- password view script --}}
    <script>
        const icon = document.getElementById('icon_eye');
        const togglePassword = document
            .querySelector('#togglePassword');
        const password = document.querySelector('#password');
        togglePassword.addEventListener('click', () => {
            // Toggle the type attribute using
            // getAttribure() method
            const type = password
                .getAttribute('type') === 'password' ?
                'text' : 'password';
            password.setAttribute('type', type);

            // console.log(type)
            if (type == 'text') {
                icon.classList.replace('bi-eye', 'bi-eye-slash')
            }else if (type == 'password') {
                icon.classList.replace('bi-eye-slash', 'bi-eye')
            }

            // Toggle the eye and bi-eye icon
            // icon.classList.toggle('bi-eye');
        });
    </script>

    {{-- <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("fa-eye-slash");
                    $('#show_hide_password i').removeClass("fa-eye");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("fa-eye-slash");
                    $('#show_hide_password i').addClass("fa-eye");
                }
            });
        });
    </script> --}}
</body>

</html>
