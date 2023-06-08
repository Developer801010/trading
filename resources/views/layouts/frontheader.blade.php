<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
      <a class="navbar-brand fw-bold" href="{{ route('front.home') }}">
        <img src="{{ asset('assets/image/logo.png') }}" class="front-logo" />
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav front-nav mx-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link @if (request()->is('/')) active @endif" href="{{ route('front.home') }}">Home</a>
         </li> 
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="#">How it works & Strategy</a>
          </li>
          <li class="nav-item">
            <a class="nav-link @if (request()->is('subscription*')) active @endif" href="{{route('front.subscription')}}">Start Trading</a>
          </li>          
          <li class="nav-item">
            <a class="nav-link">Contact</a>
          </li>
        </ul>
        <a class="btn btn-sub fw-bold btn_member" href={{ route('login') }}>Member Login</a>
      </div>
    </div>
  </nav>