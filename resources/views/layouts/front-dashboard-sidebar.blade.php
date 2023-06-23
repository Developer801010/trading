<div class="sidebar-inner">
    <ul>
        <li class="@if(request()->is('account/profile*')) active @endif">
            <a href="{{route('front.account-profile')}}">Profile</a>
        </li>
        <li class="@if(request()->is('account/change-password*')) active @endif">
            <a href="{{route('front.account-change-password')}}">Change Password</a>
        </li>
        <li class="@if(request()->is('account/notification*')) active @endif">
            <a href="{{route('front.account-notification')}}">Notifications</a>
        </li>
    </ul>
</div>