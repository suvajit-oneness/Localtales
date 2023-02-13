<header class="app-header">
    <a class="app-header__logo" href="{{ url('/') }}"><img src="{{ asset('front/img/main-logo.png')}}" alt=""></a>
    <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
    <ul class="app-nav">
        <li class="dropdown">
            <a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i> {{ Auth::user()->name }} <span><i class="treeview-indicator fa fa-angle-down" style="font-size: 15px;"></i></span></a>
            <ul class="dropdown-menu settings-menu dropdown-menu-right account-dropdown">
                <li>
                    <a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="fa fa-user fa-lg"></i> Profile</a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('admin.logout') }}"><i class="fa fa-sign-out fa-lg"></i> Logout</a>
                </li>
            </ul>
        </li>
    </ul>
</header>
