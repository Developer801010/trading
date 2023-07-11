<div class="sidebar-inner">
    <ul>
        <li class="@if(request()->is('account/profile*')) active @endif">
            <a href="{{route('front.account-profile')}}">Change Password</a>
        </li>

        <li class="@if(request()->is('account/payment-method-management*')) active @endif">
            <a href="{{route('front.account-payment-method-management')}}">Payment methods</a>
        </li>
        
        <li class="@if(request()->is('account/membership*')) active @endif">
            <a href="{{route('front.account-membership')}}">My Subscription</a>
        </li>
    </ul>
</div>