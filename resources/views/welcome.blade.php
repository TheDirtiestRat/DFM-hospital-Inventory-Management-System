<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome</title>

    @vite(['resources/js/app.js'])
    <style>
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

        /*
 * Globals
 */
        /* Custom default button */
        .btn-secondary,
        .btn-secondary:hover,
        .btn-secondary:focus {
            color: #333;
            text-shadow: none;
            /* Prevent inheritance from `body` */
        }


        /*
 * Base structure
 */

        body {
            /* text-shadow: 0 .05rem .1rem rgba(0, 0, 0, .5); */
            /* box-shadow: inset 0 0 5rem rgba(0, 0, 0, .5); */
        }

        .cover-container {
            max-width: 42em;
        }


        /*
        * Header
        */

        .nav-masthead .nav-link {
            color: rgba(255, 255, 255, .5);
            border-bottom: .25rem solid transparent;
        }

        .nav-masthead .nav-link:hover,
        .nav-masthead .nav-link:focus {
            /* border-bottom-color: rgba(255, 255, 255, .25); */
        }

        .nav-masthead .nav-link+.nav-link {
            margin-left: 1rem;
        }

        .nav-masthead .active {
            color: #fff;
            border-bottom-color: #fff;
        }

        .cover_whole_page {
            height: 100vh;
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

        .float_clues {
            /* color: #FFEDD8; */
            position: absolute;
            bottom: 15px;
            right: 15px;
            z-index: 9999;
            font-size: 12px;
        }
    </style>
</head>

<body class="d-flex cover_whole_page text-center bg">

    {{-- header --}}
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        {{-- <header class="text-bg-primary shadow rounded-4 rounded-top p-2 mb-2">
            <div>

                <nav class="nav nav-masthead justify-content-center float-md-start m-0">
                    <a class="nav-link text-light m-0" href="#">@include('components.title')</a>
                </nav>
                <nav class="nav nav-masthead justify-content-center float-md-end m-0">
                    <a class="nav-link text-light m-0" href="{{ url('login') }}">Sign-in</a>
                </nav>
            </div>
        </header> --}}
        {{-- header --}}
        {{-- <header class="mb-auto">
            <div class="">
                <nav class="nav nav-masthead justify-content-center float-md-start m-0">
                    <a class="nav-link text-light m-0" href="#">@include('components.title')</a>
                </nav>
                <nav class="nav nav-masthead justify-content-center float-md-end m-0"> --}}
        {{-- <a class="nav-link py-1 px-0 text-dark" href="{{ url('JudgeLogin') }}">Score Contestant</a> --}}
        {{-- <a class="nav-link text-light m-0" href="{{ url('login') }}">Sign-in</a>
                </nav> --}}
        {{-- <h3 class="float-md-start mb-0">
                    <img src="{{ asset('/storage/images/ormoc.png') }}" alt="" width="45">
                    Hospital Status System
                </h3> --}}
        {{-- <nav class="nav text-bg-primary p-3 gap-2 nav-masthead justify-content-center align-items-center float-md-end"> --}}
        {{-- <a class="nav-link py-1 px-0 text-dark" href="">User Login</a>
                    <a class="nav-link py-1 px-0 text-dark" href="{{ url('login') }}">Log in</a> --}}
        {{-- <a href="{{ url('login') }}" class="btn btn-primary fw-bold border-white">
                        Sign in User
                    </a>
                </nav> --}}
        {{-- </div>
        </header> --}}

        {{-- body content --}}
        <main class=" mt-auto px-3 text-bg-primary p-3 rounded-4 shadow slide-top">
            <h1>@include('components.title')</h1>
            <p class="lead">
                This system is develop to be able to provide a service for our
                nurses and medical staff to lessen their work in managing and
                maintaining the records of their patient status espicially in
                a busy environment.
            </p>
            {{-- <p class="lead">
                <a href="{{ url('login') }}" class="btn btn-lg btn-primary fw-bold border-white">
                    Log in User
                </a>
            </p> --}}
        </main>

        <div class="text-center slide-top">
            <a href="{{ url('login') }}" class="btn btn-primary btn-lg rounded-3 m-3">Sign-in</a>
        </div>

        <!-- Here is the entrance for you to open the surpise, guess the code and you'll be rewarded -->
        <form action="{{ url('From_Leal') }}" class=" visually-hidden " method="post">
            @csrf
            <input type="text" name="code" id="code">
        </form>

        {{-- footer --}}
        <footer class="mt-auto text-dark-50">
            <p>
                <a href="https://web.facebook.com/aclccollegeoformoc/?_rdc=1&_rdr" class="text-dark">ACLC Ormoc</a>, by
                <a href="https://www.tiktok.com/@thedirtiestrat" class="text-dark" target="_blank">Mr. Dirty Rat</a>.
            </p>
        </footer>
    </div>

    {{-- floating clues here --}}
    <span class="float_clues text-secondary" id="floating-clues">
        Mr. Dirtiest Rat
    </span>

    {{-- dont mind here --}}
    <script>
        document.getElementById('code').focus();

        // randomize the clues hehehe
        var ran_n = [
            'Hahaha Hi there fella!',
            'Wanna see something cool',
            'March 19, 2001',
            '/I/Am/Very/Bored',
            'Something About Blocks',
            'when leal is board'
        ];
        const flt_clu = document.getElementById('floating-clues');

        setInterval(function() {
            flt_clu.innerHTML = ran_n[(Math.floor(Math.random() * ran_n.length))];
        }, 5000);

        flt_clu.innerHTML = ran_n[(Math.floor(Math.random() * ran_n.length))];
    </script>
</body>

</html>
