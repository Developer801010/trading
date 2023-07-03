
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
      <a class="navbar-brand fw-bold" href="{{ route('front.home') }}">
        <img src="{{ asset('assets/image/logo.png') }}" class="front-logo" />
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav front-nav mx-auto mb-2 mb-lg-0">
          @auth
            <li class="nav-item">
              <a class="nav-link @if (request()->is('dashboard/main-feed')) active @endif" href="{{route('front.main-feed')}}">Main feed</a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if (request()->is('dashboard/open-stock-trades*')) active @endif" href="{{route('front.open-stock-trades')}}">Open Stock Trades</a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if (request()->is('dashboard/closed-stock-trades*')) active @endif" href="{{route('front.closed-stock-trades')}}">Closed Stock Trades</a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if (request()->is('dashboard/open-options-trades*')) active @endif" href="{{route('front.open-options-trades')}}">Open Options Trades</a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if (request()->is('dashboard/closed-options-trades*')) active @endif" href="{{route('front.closed-options-trades')}}">Closed Options Trades</a>
            </li>
          @else
            <li class="nav-item">
              <a class="nav-link @if (request()->is('/')) active @endif" href="{{ route('front.home') }}">Home</a>
            </li> 
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="#">News</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="#">Learn</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="#">Results</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="#">Trading Strategy</a>
            </li>       
          @endauth
        </ul>
        @auth
         
          {{-- @role('admin')
            <a class="btn btn-out fw-bold btn_member btn-register" target="_blank" href={{ route('admin.home') }}>Dashboard</a>
          @else
            <a class="btn btn-out fw-bold btn_member btn-register" href={{ route('front.account-profile') }}>Dashboard</a>
          @endrole --}}

        @else
          <a class="btn btn-sub fw-bold btn_member btn-login" href={{ route('login') }}>Member Login</a>
          <a class="btn btn-danger fw-bold btn_member" href={{ route('front.subscription') }}>Start Trading</a>
        @endauth
        
      </div>
    </div>
  </nav>