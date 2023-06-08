   <!-- BEGIN: Main Menu-->
   <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto">
                <a class="navbar-brand" href="{{route('home')}}">
                    <img src="{{ asset('assets/image/logo.png') }}" />
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
                    <a class="d-flex align-items-center" href="{{ route('home') }}">
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

            @endcan

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