<div class="account-nav">
    <ul>
      <li class="@if (request()->is('account*')) active @endif">
         <a href="{{route('front.account-profile')}}">Account</a>
      </li>
      
      <li class="@if (request()->is('dashboard/open-position*')) active @endif">
         <a href="@role(['subscriber']) {{route('front.open-position')}} @else {{route('front.subscription')}}  @endrole">open positions</a>
      </li>
      <li class="@if (request()->is('dashboard/main-feed*')) active @endif">
         <a href="@role(['subscriber']) {{route('front.main-feed')}} @else {{route('front.subscription')}}  @endrole">Main feed</a>
      </li>
      <li class="@if (request()->is('dashboard/closed-position*')) active @endif">
         <a href="@role(['subscriber']) {{route('front.closed-position')}} @else {{route('front.subscription')}}  @endrole">Closed positions</a>
      </li>
    </ul>
 </div>