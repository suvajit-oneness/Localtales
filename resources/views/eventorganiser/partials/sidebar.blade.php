<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">

        <!-- <div class="user-profile-pic">
          <img src="{{ asset('b2b/images/c2.jpg')}}">
        </div> -->
        {{-- <ul class="app-menu">
            <li>{{Auth::guard('business')->user()->name}}</li>
            <li><i class="app-menu__icon fa fa-envelope"></i> {{Auth::guard('business')->user()->email}}</li>
          <li><i class="app-menu__icon fa fa-map-marker-alt"></i>{{Auth::guard('business')->user()->address}}</li>
          <li><i class="app-menu__icon fa fa-globe"></i> {{Auth::guard('business')->user()->website}}</li>
          <li><i class="app-menu__icon fa fa-phone-alt"></i> {{Auth::guard('business')->user()->mobile}}</li>
        </ul> --}}

    <ul class="app-menu">
        <li>
            <a class="app-menu__item  {{ Route::currentRouteName() == 'event.organiser.dashboard' ? 'active' : '' }}" href="{!! URL::to('/eventorganiser/dashboard')!!}"><i class="app-menu__icon fa fa-dashboard"></i>
                <span class="app-menu__label">Dashboard</span>
            </a>
        </li>
        <li><a class="app-menu__item " href="{{ route('eventorganiser.event.index') }}"><i class="app-menu__icon fa fa-calendar"></i>
            <span class="app-menu__label">Event</span>
        </a></li>
        <li><a class="app-menu__item " href="{{ route('eventorganiser.profile') }}"><i class="app-menu__icon fa fa-user"></i>
            <span class="app-menu__label">Edit Profile</span>
        </a></li>
        <li><a class="app-menu__item " href="{{route('eventorganiser.change.password')}}"><i class="app-menu__icon fa fa-key"></i>
            <span class="app-menu__label">Change Password</span>
        </a></li>
       
        <li><a href="{{ route('eventorganiser.logout') }}" class="app-menu__item"><i class="app-menu__icon fa fa-sign-out fa-lg"></i>LOGOUT</a></li>
        <!-- User Management -->
    </ul>
</aside>
