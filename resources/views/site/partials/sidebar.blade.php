<!--msb: main sidebar-->
<div class="msb" id="msb">
    <nav class="navbar navbar-default" role="navigation">
      <!-- Brand and toggle get grouped for better mobile display -->

      <!-- Main Menu -->
      <div class="side-menu-container">
        <div class="navbar-header">
          <div class="brand-wrapper">
            <!-- Brand -->
            <div class="brand-name-wrapper">
              <!-- <div class="user-profile-pic">
                <img src="{{ asset('b2b/images/c2.jpg')}}">
              </div> -->
              <h6>{{Auth::user()->name}}</h6>
              <ul class="left-menuadd">
                <li><i class="fas fa-envelope"></i> {{Auth::user()->email}}</li>
                <li><i class="fas fa-phone-alt"></i> {{Auth::user()->mobile}}</li>
              </ul>
              <div class="social-div text-center">
               {{-- <ul>
                  <li><a href=""><i class="fab fa-facebook-f"></i></a></li>
                  <li><a href=""><i class="fab fa-twitter"></i></a></li>
                  <li><a href=""><i class="fab fa-instagram"></i></a></li>
                  <li><a href=""><i class="fab fa-youtube"></i></a></li>
                </ul>--}}
                <a href="{{ route('site.dashboard.editProfile') }}" class="pro-edit"><i class="far fa-edit"></i> Edit Profile</a>
              </div>
            </div>

          </div>

        </div>
        <ul class="nav navbar-nav">
            <li><a href="{{ route('site.dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>
          <li><a href="{{ route('site.dashboard.saved_collection') }}"><i class="fa fa-heart"></i> Saved Collection</a></li>
          {{-- <li><a href="{{ route('site.dashboard.saved_deals') }}"><i class="fa fa-heart"></i> Saved Deals</a></li> --}}
           <li><a href="{{ route('site.dashboard.saved_businesses') }}"><i class="fa fa-heart"></i> Saved Directories</a></li>
           <li><a href="{{ route('site.dashboard.saved_job') }}"><i class="fa fa-bell"></i> Saved Jobs</a></li>
           <li><a href="{{ route('site.dashboard.applied_job') }}"><i class="fa fa-cogs"></i> Applied Jobs</a></li>
           <li><a href="{{ route('user.notification.setup') }}"><i class="fa fa-cogs"></i> Notification setup</a></li>
        </ul>
        <ul class="nav navbar-nav mt-auto">
          <li><a href="{{ route('user.logout') }}" class="logout-bg"><i class="fas fa-sign-out-alt"></i>LOGOUT</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </nav>
</div>
