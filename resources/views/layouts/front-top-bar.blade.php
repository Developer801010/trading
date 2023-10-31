@auth
<div class="top-bar">
    <div class="container top-bar-section">
        <div class="top-bar-user">
            <span class="login-email text-white">
                {{auth()->user()->email}}
            </span>
            <a class="logout-link text-danger" href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">            
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
        <div class="top-bar-account">
            <a class="nav-link dropdown-toggle text-white top-bar-my-account" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                My Account
            </a>
            <div class="dropdown-menu top-bar-menu" aria-labelledby="navbarDropdown">
               
                <a class="dropdown-item @if (request()->is('account/*')) active @endif" href="{{route('front.account-profile')}}">
                    Account Details
                </a>
                @role('admin')
                    <a class="dropdown-item" href="{{route('admin.home')}}">
                        Dashboard
                    </a>
                @endrole
            </div>
            
        </div>
    </div>
</div>    
@endauth
