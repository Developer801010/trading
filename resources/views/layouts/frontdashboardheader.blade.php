<div class="account-nav">
    <ul>
      <li class="@if (request()->is('account*')) active @endif">
         <a href="{{route('front.account')}}">Account</a>
      </li>
      <li class="@if (request()->is('open-position*')) active @endif">
         <a href="{{route('front.open-position')}}">open positions</a>
      </li>
      <li>
         <a href="#">Main feed</a>
      </li>
      <li>
         <a href="#">Closed positions</a>
      </li>
      
    </ul>
 </div>