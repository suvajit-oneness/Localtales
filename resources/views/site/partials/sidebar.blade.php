<div class="msb" id="msb">
    <nav class="navbar navbar-default" role="navigation">
      <div class="side-menu-container">
        <div class="navbar-header">
          <div class="brand-wrapper">
            <div class="brand-name-wrapper">
              <h6>{{Auth::guard('user')->user()->name}}</h6>
              <ul class="left-menuadd pt-2 pb-0">
                <li style="white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;" title="{{Auth::guard('user')->user()->email}}"><i class="fas fa-envelope"></i> {{Auth::guard('user')->user()->email}}</li>
                <li><i class="fas fa-phone-alt"></i> {{Auth::guard('user')->user()->mobile}}</li>
              </ul>
              <div class="social-div text-center">
                <a href="{{ route('site.dashboard.editProfile') }}" class="pro-edit"><i class="far fa-edit"></i> Edit Profile</a>
              </div>
            </div>
          </div>
        </div>
        <ul class="nav navbar-nav sidebar--nav">
          <li class="{{ request()->is('dashboard*') ? 'active' : '' }}"><a href="{{ route('site.dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>

          <li class="{{ request()->is('saved-collection*') ? 'active' : '' }}"><a href="{{ route('site.dashboard.saved_collection') }}"><i class="fa fa-heart"></i> Saved Collections</a></li>

          {{-- <li><a href="{{ route('site.dashboard.saved_deals') }}"><i class="fa fa-heart"></i> Saved Deals</a></li> --}}

          <li class="{{ request()->is('saved-directory*') ? 'active' : '' }}"><a href="{{ route('site.dashboard.saved_businesses') }}"><i class="fa fa-heart"></i> Saved Directories</a></li>

          <li class="{{ request()->is('saved-job*') ? 'active' : '' }}"><a href="{{ route('site.dashboard.saved_job') }}"><i class="fa fa-bell"></i> Saved Jobs</a></li>

          {{-- <li><a href="{{ route('site.dashboard.applied_job') }}"><i class="fa fa-cogs"></i> Applied Jobs</a></li> --}}

          <li class="{{ request()->is('notification/setup*') ? 'active' : '' }}"><a href="{{ route('user.notification.setup') }}"><i class="fa fa-cogs"></i> Notification setup</a></li>
        </ul>
        <ul class="nav navbar-nav mt-auto">
          <li><a href="{{ route('user.logout') }}" class="logout-bg text-light"><i class="fas fa-sign-out-alt"></i>LOGOUT</a></li>
        </ul>
      </div>
    </nav>
</div>
