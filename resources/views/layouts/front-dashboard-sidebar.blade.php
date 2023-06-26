<div class="sidebar-inner">
    <ul>
        <li class="@if(request()->is('account/profile*')) active @endif">
            <a href="{{route('front.account-profile')}}">Profile</a>
        </li>
        <li class="@if(request()->is('account/change-password*')) active @endif">
            <a href="{{route('front.account-change-password')}}">Change Password</a>
        </li>
        
        <li class="@if(request()->is('account/membership*')) active @endif">
            <a href="@role(['subscriber']) {{route('front.account-membership')}} @else {{route('front.subscription')}}  @endrole">Membership</a>
        </li>
    </ul>
</div>