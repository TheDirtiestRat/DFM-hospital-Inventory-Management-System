{{-- alert error --}}
@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul class="m-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- display error --}}
@if (Session::has('error'))
    <div class="alert alert-danger" role="alert">
        {{ Session::get('error') }}
    </div>
@endif

{{-- success message when we add new data --}}
@if ($message = Session::get('success'))
    <div class="alert alert-success" role="alert">
        {{-- shows the message given --}}
        <p class="m-0">{{ $message }}</p>
    </div>
@endif

{{-- success message when we add new data --}}
@if ($message = Session::get('info'))
    <div class="alert alert-info" role="alert">
        {{-- shows the message given --}}
        <p class="m-0">{{ $message }}</p>
    </div>
@endif

{{-- warning --}}
@if ($message = Session::get('warning'))
    <div class="alert alert-warning" role="alert">
        {{-- shows the message given --}}
        <p class="m-0">{{ $message }}</p>
    </div>
@endif