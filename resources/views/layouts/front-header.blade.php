<nav class="navigation-menu">
    <ul class="nav-list nav">
        @auth
        <li class="nav-item"><a class="nav-link  @if (request()->is('dashboard/main-feed')) active @endif" href="{{route('front.main-feed')}}">Main Feed</a></li>
        <li class="nav-item"><a class="nav-link @if (request()->is('dashboard/open-stock-trades*')) active @endif" href="{{route('front.open-stock-trades')}}">Open Stock Trades</a></li>
        <li class="nav-item"><a class="nav-link @if (request()->is('dashboard/closed-stock-trades*')) active @endif" href="{{route('front.closed-stock-trades')}}">Closed Stock Trades</a></li>
        <li class="nav-item"><a class="nav-link @if (request()->is('dashboard/open-options-trades*')) active @endif" href="{{route('front.open-options-trades')}}">Open Options Trades</a></li>
        <li class="nav-item"><a class="nav-link @if (request()->is('dashboard/closed-options-trades*')) active @endif" href="{{route('front.closed-options-trades')}}">Closed Options Trades</a></li>
        {{-- @else
        <li class="nav-item"><a class="nav-link @if (request()->is('/')) active @endif" href="{{ route('front.home') }}">Home</a></li>
        <li class="nav-item"><a class="nav-link  @if (request()->is('/news')) active @endif" aria-current="page" href="{{route('front.news')}}">News</a></li>
        <li class="nav-item"><a class="nav-link  @if (request()->is('/learn')) active @endif" aria-current="page" href="{{route('front.learn')}}">Learn</a></li>
        <li class="nav-item"><a class="nav-link  @if (request()->is('/result')) active @endif" aria-current="page" href="{{route('front.results')}}">Results</a></li>
        <li class="nav-item"><a class="nav-link  @if (request()->is('/trading-strategy')) active @endif" aria-current="page" href="{{route('front.trading-strategy')}}">Trading Strategy</a></li> --}}
        @endauth
    </ul>
</nav>
