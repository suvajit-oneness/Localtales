<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <ul class="app-menu">
        <li>
            <a class="app-menu__item {{ request()->is('business') ? 'active' : '' }}" href="{{ route('business.dashboard') }}"><i class="app-menu__icon fa fa-tachometer-alt"></i>
                <span class="app-menu__label">Dashboard</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ request()->is('business/review*') ? 'active' : '' }}" href="{{ route('business.review') }}"><i class="app-menu__icon fa fa-star"></i>
                <span class="app-menu__label">Rating & Review</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ request()->is('business/deals*') ? 'active' : '' }}" href="{{ route('business.deal.index') }}"><i class="app-menu__icon fa fa-tags"></i>
                <span class="app-menu__label">Deals</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ request()->is('business/event*') ? 'active' : '' }}" href="{{ route('business.event.index') }}"><i class="app-menu__icon fa fa-calendar"></i>
                <span class="app-menu__label">Events</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ request()->is('business/profile*') ? 'active' : '' }}" href="{{ route('business.profile') }}"><i class="app-menu__icon fa fa-user"></i>
                <span class="app-menu__label">Edit Profile</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ request()->is('business/change/password*') ? 'active' : '' }}" href="{{ route('business.change.password') }}"><i class="app-menu__icon fa fa-key"></i>
                <span class="app-menu__label">Change Password</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ request()->is('business/notification*') ? 'active' : '' }}" href="{{ route('business.notification.index') }}"><i class="app-menu__icon fa fa-cogs"></i>
                <span class="app-menu__label">Notifications</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item" href="{{ route('business.logout') }}"><i class="app-menu__icon fa fa-sign-out-alt"></i>
                <span class="app-menu__label">Logout</span>
            </a>
        </li>
    </ul>
</aside>
