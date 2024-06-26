   <!-- BEGIN: Main Menu-->
   <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto" style="margin: 0 auto;">
                <a class="navbar-brand" href="{{route('admin.home')}}">
                    <img src="{{ asset('assets/images/Logo.png') }}" style="width: 50px;"/>
                </a>
            </li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            @role(['admin'])
                <li class="navigation-header">
                    <span>Dashboard</span>
                </li>
                <li class="nav-item @if(request()->is('home')) active @endif">
                    <a class="d-flex align-items-center" href="{{ route('admin.home') }}">
                        <i data-feather="home"></i>
                        <span class="menu-title text-truncate">Dashboard</span>
                    </a>
                </li>

                <li class="navigation-header">
                    <span>User &amp Role management</span>
                </li>

                <li class="nav-item  @if(request()->is('users*')) active @endif">
                    <a class="d-flex align-items-center" href="{{ route('users.index') }}">
                        <i data-feather="user"></i>
                        <span class="menu-title text-truncate">User</span>
                    </a>
                </li>

                <li class="nav-item @if(request()->is('roles*')) active @endif">
                    <a class="d-flex align-items-center" href="{{ route('roles.index') }}">
                        <i data-feather="shield"></i>
                        <span class="menu-title text-truncate">Role</span>
                    </a>
                </li>

                <li class="navigation-header">
                    <span>Payment management</span>
                </li>

                <li class="nav-item">
                    <a class="d-flex align-items-center" href="#">
                        <i data-feather="aperture"></i>
                        <span class="menu-title text-truncate">Payment</span>
                    </a>
                    <ul class="menu-content">
                        <li class="nav-item @if(request()->is('plans*')) active @endif">
                            <a class="d-flex align-items-center" href="{{ route('plans.index') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item text-truncate">Plan Management</span>
                            </a>
                        </li>

                        <li class="nav-item @if(request()->is('paypal/plan*')) active @endif">
                            <a class="d-flex align-items-center" href="{{route('admin.list-plan-paypal')}}">
                                <i data-feather="circle"></i><span class="menu-item text-truncate">Plan(Paypal)</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="navigation-header">
                    <span>Trade</span>
                </li>

                <li class="nav-item">
                    <a class="d-flex align-items-center" href="#">
                        <i data-feather="mail"></i>
                        <span class="menu-title text-truncate">Alerts</span>
                    </a>
                    <ul class="menu-content">
                        <li class="nav-item @if(request()->is('trades*')) active @endif">
                            <a class="d-flex align-items-center" href="{{ route('trades.index') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item text-truncate">Open Trades</span>
                            </a>
                        </li>
                    </ul>
                </li>

				<li class="nav-item  @if(request()->is('messages*')) active @endif">
                    <a class="d-flex align-items-center" href="{{ route('messages.index') }}">
                        <i data-feather="message-circle"></i>
                        <span class="menu-title text-truncate">Messages</span>
                    </a>
                </li>

                <li class="navigation-header">
                    <span>Articles</span>
                </li>

                <li class="nav-item @if(request()->is('articles*')) active @endif">
                    <a class="d-flex align-items-center" href="{{ route('articles.index') }}">
                        <i data-feather="gift"></i>
                        <span class="menu-title text-truncate">Articles</span>
                    </a>
                </li>
                <li class="navigation-header">
                    <span>Settings</span>
                </li>
                <li class="nav-item  @if(request()->is('settings*')) active @endif">
                    <a class="d-flex align-items-center" href="{{ route('settings.index') }}">
                        <i data-feather="user"></i>
                        <span class="menu-title text-truncate">Settings</span>
                    </a>
                </li>
            @endrole

            @role(['user'])
                <li class="nav-item @if(request()->is('home')) active @endif">
                    <a class="d-flex align-items-center" href="{{ route('home') }}">
                        <i data-feather="home"></i>
                        <span class="menu-title text-truncate">Dashboard</span>
                    </a>
                </li>
            @endrole
        </ul>
    </div>
</div>
<!-- END: Main Menu-->
