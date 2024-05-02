<button class="btn btn-outline-light dropdown-toggle w-100 " type="button" id="dropdownMenuButton2"
    data-bs-toggle="dropdown" aria-expanded="false">
    Notifications <i class="bi bi-bell-fill"></i>
    <span class="badge text-bg-secondary">{{ auth()->user()->unreadNotifications()->count() }}</span>
</button>

<ul class="dropdown-menu dropdown-menu-dark" style="min-width: 300px" aria-labelledby="dropdownMenuButton2">
    {{-- list of notification --}}
    <li>
        <h6 class="dropdown-header">Unread</h6>
    </li>
    @foreach (auth()->user()->unreadNotifications()->take(4)->get() as $notification)
        {{-- if its a patient notif --}}
        @if ($notification->data['type'] == 'patient')
            <li>
                <a class="dropdown-item fw-bold text-wrap "
                    href="{{ route('go-to-notif', [
                        'n_id' => $notification->id,
                        'type' => 'patient',
                        'i_val' => $notification->data['p_id']
                    ]) }}">{{ $notification->data['data'] }}
                    !
                    <br>
                    <span style="font-size: 11px">{{ $notification->updated_at }}</span>
                </a>
            </li>
        @endif
    @endforeach
    <li>
        <h6 class="dropdown-header">Read</h6>
    </li>
    @foreach (auth()->user()->readNotifications()->take(4)->get() as $notification)
        <li>
            <a class="dropdown-item text-wrap " href="#">{{ $notification->data['data'] }}
                <br>
                <span style="font-size: 11px">{{ $notification->updated_at }}</span>
            </a>
        </li>
    @endforeach

    {{-- <li><a class="dropdown-item" href="#">Something else here</a></li> --}}
    <li>
        <hr class="dropdown-divider">
    </li>
    <li><a class="dropdown-item" href="{{ route('mark-as-read') }}">Mark as All Read <i class="bi bi-check-all"></i></a>
    </li>
</ul>
