<div class="account-nav">
    <ul>
      <li class="@if (request()->is('account*')) active @endif">
         <a href="{{route('front.account-profile')}}">Account</a>
      </li>
      <li class="@if (request()->is('dashboard/open-position*')) active @endif">
         <a href="{{route('front.open-position')}}">open positions</a>
      </li>
      <li class="@if (request()->is('dashboard/main-feed*')) active @endif">
         <a href="{{route('front.main-feed')}}">Main feed</a>
      </li>
      <li class="@if (request()->is('dashboard/closed-position*')) active @endif">
         <a href="{{route('front.closed-position')}}">Closed positions</a>
      </li>
      
    </ul>
 </div>