@forelse ($assistance_requests as $request)
    {{-- card --}}
    <div class="col-auto p-0">
        <div class="card" style="width: 18rem;">
            <div class="card-header">
                Case number<strong>: {{ $request->case_no }}</strong>
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $request->first_name }} {{ $request->mid_name }}
                    {{ $request->last_name }}</h5>
                <p class="card-text">{{ $request->request_type }}</p>
                <div class="text-center">
                    {{-- show status buttons --}}
                    @if ($request->status == 'PENDING')
                        <a href="{{ route('assistanceRequest.edit', $request->id) }}"
                            class="btn btn-warning w-100">{{ $request->status }}</a>
                    @elseif ($request->status == 'APPROVE')
                        <a href="" class="btn btn-success w-100">{{ $request->status }}</a>
                    @else
                        <a href="" class="btn btn-danger w-100">{{ $request->status }}</a>
                    @endif

                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-12 text-center text-muted">
        <h1 class="m-0">No Requests Listed</h1>
    </div>
@endforelse
