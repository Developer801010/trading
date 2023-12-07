<ul class="tab-nav">
    <li>
        <a href="{{route('front.account-profile')}}" class="nav-link @if(request()->is('account/profile*')) active @endif">Account Details</a>
    </li>
    <li>
        <a href="{{route('front.account-payment-method-management')}}" class="nav-link @if(request()->is('account/payment-method-management*')) active @endif">Payment Methods</a>
    </li>
    <li>
        <a href="{{route('front.account-membership')}}" class="nav-link @if(request()->is('account/membership*')) active @endif">My Subscription</a>
    </li>
</ul>
