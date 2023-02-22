<header class="app-header">
    <a class="app-header__logo" href="{{ url('/') }}"><img src="{{ asset('front/img/main-logo.png')}}" alt=""></a>
    <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>

    <ul class="app-nav">
        <li>
            <a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu">
                <strong>{{Auth::guard('business')->user()->name}}</strong>
            </a>
        </li>

        <li class="nav-item dropdown">
            <a class="app-nav__item nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-bell"></i>
                @if ($totalUnreadNotifications > 0)
                    <div class="badge noti-badge">{{$totalUnreadNotifications}}</div>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-right notification-list">
                @forelse ($notificationList as $index => $noti)
                    <a href="javascript:void(0)" class="dropdown-item {{ $noti->read_flag == 0 ? 'unread' : 'read' }}" onclick="readNotification({{ $noti->id }}, '{{ $noti->route }}')">
                        <p class="mb-0">{{ $noti->title }}</p>
                        <p class="small mb-0">{{ $noti->description }}</p>
                    </a>
                @empty
                    <a class="dropdown-item" href="javascript: void(0)">
                        <p class="small text-muted text-center mb-0">No notifications yet</p>
                    </a>
                @endforelse

                @if (count($notificationList) > 0)
                    <a class="dropdown-item all-notification" href="{{ route('business.notification.index') }}">
                        View all Notifications
                    </a>
                @endif
            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="app-nav__item nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-user"></i>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ url('business') }}">Dashboard</a>
                <a class="dropdown-item" href="{{ url('business/profile') }}">Profile</a>
                <a class="dropdown-item" href="{{ url('business/change/password') }}">Change Password</a>
                <a class="dropdown-item" href="{{ route('business.logout') }}">Logout</a>
            </div>
        </li>
    </ul>
</header>
