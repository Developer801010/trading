<div class="lp-header-main">
    <a href="{{route('front.home')}}" class="logo">
        <img src="{{ asset('assets/images/Logo.png') }}" alt="Logo" class="img-fluid">
    </a>
    <div class="d-flex gap-3 align-items-center order-2 order-lg-1">
        <div class="nav-mobile"><button id="nav-toggle-home" type="button"><span></span></button></div>
    </div>
    <nav class="lp-navigation-menu order-3 order-lg-2">
        <ul class="nav-list nav">
            <li class="nav-item"><a class="nav-link @if (request()->is('/')) active @endif" href="{{ route('front.home') }}">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('front.home') }}#overview">Overview</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('front.home') }}#features">Features</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Performance</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('front.home') }}#pricing">Pricing</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Guides & Posts</a></li>
            {{-- <li class="nav-item"><a class="nav-link  @if (request()->is('/news')) active @endif" aria-current="page" href="{{route('front.news')}}">News</a></li>
            <li class="nav-item"><a class="nav-link  @if (request()->is('/learn')) active @endif" aria-current="page" href="{{route('front.learn')}}">Learn</a></li>
            <li class="nav-item"><a class="nav-link  @if (request()->is('/result')) active @endif" aria-current="page" href="{{route('front.results')}}">Results</a></li>
            <li class="nav-item"><a class="nav-link  @if (request()->is('/trading-strategy')) active @endif" aria-current="page" href="{{route('front.trading-strategy')}}">Trading Strategy</a></li> --}}
        </ul>
    </nav>
    <div class="d-flex gap-2 flex-wrap align-items-center order-1 order-lg-2 ms-auto ms-lg-0">
        <a href="{{ url('/login') }}" class="btn login-btn-outline shadow-none">
            <span class="d-none d-sm-block">Member Login</span>
            <span class="svg-14">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7 3C6.50555 3 6.0222 3.14662 5.61108 3.42133C5.19995 3.69603 4.87952 4.08648 4.6903 4.54329C4.50108 5.00011 4.45157 5.50277 4.54804 5.98773C4.6445 6.47268 4.8826 6.91813 5.23223 7.26777C5.58187 7.6174 6.02732 7.8555 6.51228 7.95196C6.99723 8.04843 7.49989 7.99892 7.95671 7.8097C8.41352 7.62048 8.80397 7.30005 9.07867 6.88892C9.35338 6.4778 9.5 5.99445 9.5 5.5C9.5 4.83696 9.23661 4.20107 8.76777 3.73223C8.29893 3.26339 7.66304 3 7 3ZM7 7C6.70333 7 6.41332 6.91203 6.16665 6.7472C5.91997 6.58238 5.72771 6.34811 5.61418 6.07402C5.50065 5.79994 5.47095 5.49834 5.52882 5.20736C5.5867 4.91639 5.72956 4.64912 5.93934 4.43934C6.14912 4.22956 6.41639 4.0867 6.70737 4.02882C6.99834 3.97094 7.29994 4.00065 7.57403 4.11418C7.84812 4.22771 8.08238 4.41997 8.24721 4.66664C8.41203 4.91332 8.5 5.20333 8.5 5.5C8.4996 5.8977 8.34144 6.279 8.06022 6.56022C7.779 6.84144 7.3977 6.9996 7 7Z" fill="currentColor"/>
                    <path d="M7 0C5.61553 0 4.26215 0.410543 3.11101 1.17971C1.95987 1.94888 1.06266 3.04213 0.532846 4.32122C0.00303298 5.6003 -0.13559 7.00776 0.134506 8.36563C0.404603 9.7235 1.07129 10.9708 2.05026 11.9497C3.02922 12.9287 4.2765 13.5954 5.63437 13.8655C6.99224 14.1356 8.3997 13.997 9.67879 13.4672C10.9579 12.9373 12.0511 12.0401 12.8203 10.889C13.5895 9.73785 14 8.38447 14 7C13.9979 5.14413 13.2597 3.36489 11.9474 2.05259C10.6351 0.740295 8.85587 0.00211736 7 0ZM4 12.1885V11.5C4.0004 11.1023 4.15856 10.721 4.43978 10.4398C4.721 10.1586 5.1023 10.0004 5.5 10H8.5C8.8977 10.0004 9.279 10.1586 9.56022 10.4398C9.84144 10.721 9.9996 11.1023 10 11.5V12.1885C9.08958 12.7201 8.05426 13.0002 7 13.0002C5.94574 13.0002 4.91042 12.7201 4 12.1885ZM10.996 11.463C10.986 10.8072 10.7188 10.1815 10.252 9.72079C9.78508 9.26009 9.15591 9.00123 8.5 9H5.5C4.84409 9.00123 4.21492 9.26009 3.74805 9.72079C3.28117 10.1815 3.01397 10.8072 3.004 11.463C2.09728 10.6534 1.45787 9.58743 1.17042 8.40633C0.882972 7.22523 0.961053 5.98467 1.39432 4.84893C1.82759 3.71319 2.59561 2.73583 3.59669 2.04628C4.59776 1.35673 5.78467 0.987513 7.00025 0.987513C8.21583 0.987513 9.40274 1.35673 10.4038 2.04628C11.4049 2.73583 12.1729 3.71319 12.6062 4.84893C13.0395 5.98467 13.1175 7.22523 12.8301 8.40633C12.5426 9.58743 11.9027 10.6534 10.996 11.463Z" fill="currentColor"/>
                </svg>
            </span>
        </a>
        <a href="{{ route('front.subscription') }}" class="btn trade-btn shadow-none">Start Trading</a>
    </div>
</div>
