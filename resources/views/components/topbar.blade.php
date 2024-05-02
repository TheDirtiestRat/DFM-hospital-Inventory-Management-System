<nav class="text-bg-primary navbar navbar-expand-lg navbar-light w-100 rounded-4 rounded-top shadow-sm p-3 mb-3">
    <div class="container-fluid p-0">
        <!-- sidebar button -->
        <button class="btn btn-light rounded-3" id="sidebarToggle">
            <i class="bi bi-list-task"></i>
        </button>

        <!-- dropdown list -->
        <button class="navbar-toggler p-2 text-bg-light" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <i class="bi bi-list-task"></i>
        </button>

        {{-- dropdown --}}
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav ms-auto gap-2 mt-2 mt-lg-0 float-md-none">
                {{-- options list --}}
                <li class="nav-item dropdown">
                    {{-- <div class="dropdown"> --}}
                    @include('components.notification-ui')
                    {{-- </div> --}}
                </li>
                <li class="nav-item dropdown">
                    <a href="{{ route('user.show', Auth::user()->id) }}" class=" text-decoration-none">
                        <button class="btn btn-outline-light rounded-3 w-100" type="button">{{ Auth::user()->name }} -
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
