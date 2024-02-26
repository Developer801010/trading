
<div class="header-main lp-header-main">
    <a href="{{route('front.home')}}" class="logo">
        <img src="{{ asset('assets/images/Logo.png') }}" alt="Logo" class="img-fluid">
    </a>
    <div class="d-flex gap-3 align-items-center">
        <div class="dropdown account-drop">
            <a class="profile-btn" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="svg-20">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M9.99998 9.99999C12.3012 9.99999 14.1666 8.13451 14.1666 5.83332C14.1666 3.53214 12.3012 1.66666 9.99998 1.66666C7.69879 1.66666 5.83331 3.53214 5.83331 5.83332C5.83331 8.13451 7.69879 9.99999 9.99998 9.99999Z" stroke="CurrentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M17.1583 18.3333C17.1583 15.1083 13.95 12.5 10 12.5C6.05001 12.5 2.84167 15.1083 2.84167 18.3333" stroke="CurrentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </a>

            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                @if (Auth::check())
					@role('admin')
						<li><a class="dropdown-item" href="{{route('admin.home')}}">Dashboard</a></li>
					@endrole
					<li><a class="dropdown-item @if (request()->is('notify/*')) active @endif" href="{{route('front.account-notification-setup')}}">Notification Setup</a></li>
					<li><a class="dropdown-item @if (request()->is('account/*')) active @endif" href="{{route('front.account-profile')}}">Account Details</a></li>
					<li>
						<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							@csrf
						</form>
					</li>
				    {{-- @else
				    <li><a class="dropdown-item" href="{{ route('login') }}">Member Login</a></li>
                    <li><a class="dropdown-item" href="{{ route('front.subscription') }}">Start Trading</a></li> --}}
                @endauth
            </ul>
          </div>
        <div class="nav-mobile"><button id="nav-toggle" type="button"><span></span></button></div>
    </div>
</div>

