<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Local Tales</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('front/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css?ver=5.9.3' />
    <link rel="stylesheet" type="text/css" href="{{ asset('front/css/swiper-bundle.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('front/css/main.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('front/css/responsive.css')}}">
</head>
<body>

   <header class="header">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#"><img class="w-100" src="{{ asset('front/img/main-logo.png')}}" alt="Local Tales"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav m-auto">
            <li class="nav-item {{ request()->is('home') ? 'active' : '' }}">
              <a class="nav-link" href="{!! URL::to('/') !!}">Home</a>
            </li>
            <li class="nav-item {{ request()->is('postcode') ? 'active' : '' }}">
                <a class="nav-link" href="{!! URL::to('postcode/3094') !!}">Postcode</a>
              </li>
              <li class="nav-item {{ request()->is('directory-list') ? 'active' : '' }}">
                <a class="nav-link" href="{!! URL::to('directory-list') !!}">Directory</a>
              </li>
            {{-- <li class="nav-item {{ request()->is('collection-page') ? 'active' : '' }}">
              <a class="nav-link" href="{!! URL::to('collection-page/3') !!}">Collection</a>
            </li> --}}
            <li class="nav-item {{ request()->is('collection') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('collection.home') }}">Collection</a>
            </li>
            <li class="nav-item {{ request()->is('category') ? 'active' : '' }}">
              <a class="nav-link" href="{!! URL::to('category-index') !!}">Category</a>
            </li>
            <li class="nav-item {{ request()->is('article') ? 'active' : '' }}">
                <a class="nav-link" href="{!! URL::to('article') !!}">Article</a>
              </li>
          </ul>
          <div class="form-inline my-2 my-lg-0">
              @if(Auth::guard('user')->check())
						<a type="button" class="btn btn-login" href="{!! URL::to('site-edit-profile') !!}">
							<!-- <span><img src="{{ asset('site/images/login-icon.png ')}}"></span> -->

							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
							<span>Hi, {{Auth::guard('user')->user()->name}}</span>
						</a>
						@else
               <a type="button" class="btn btn-login" href="{!! URL::to('login') !!}" ><img src="{{ asset('front/img/login.svg')}}"> Login</a>
               	@endif
            <a type="button" class="btn btn-login btn_buseness" href="{{ route('business.signup')}}"><img src="{{ asset('front/img/briefcase.svg')}}"> Business Signup</a>
          </div>
        </div>
    </nav>
</header>

    <div class="banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-xl-8">
                    @foreach($data as  $key => $blog)
                    <h4>Welcome here2!</h4>
                    {!! $blog->content !!}

                    <div class="banner_counter">
                        <div class="banner_counter_item">
                            <h3>50k+</h3>
                            <h5>Postcode</h5>
                        </div>
                        <div class="banner_counter_item">
                            <h3>5m+</h3>
                            <h5>Directory</h5>
                        </div>
                        <div class="banner_counter_item">
                            <h3>10k+</h3>
                            <h5>Collections</h5>
                        </div>
                    </div>
                    <form action="" method="get" class="banner_form">
                        @csrf
                        <div class="row">
                            <div class="col-12 mb-3 mb-lg-0 col-sm-4 pr-sm-0">
                                <div class="banner-form-group">
                                    <input type="text" name="name" id="inputSearchTextFilter" class="form-control" placeholder="Your Business Name">
                                    <label>Your Business Name</label>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4 pr-sm-0">
                                <div class="banner-form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Email">
                                    <label>Email</label>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <input type="hidden" name="website" value="">
                                <input type="hidden" name="email" value="">
                                <input type="hidden" name="address" value="">
                                <input type="hidden" name="mobile" value="">
                                <button type="submit" class="btn main-btn">Join Us</button>
                            </div>
                        </div>
                    </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


    <section class="play-section">
        <div class="container">
            <div class="row align-items-center">
                @foreach($data as  $key => $blog)
                <div class="col-lg-6 mb-4">
                    <figure>
                        @if($blog->image!='')
                        <img src="{{URL::to('/').'/Extra/'}}{{$blog->image}}">
                        @endif

                        <div class="browse_box">
                            <span class="browse_icon">
                                <img src="{{ asset('front/img/localtale_icon.png') }}">
                            </span>
                            <h3>Find the best collections</h3>
                            <h4>Browse thousands of collections</h4>
                        </div>
                    </figure>
                </div>
                <div class="col-lg-5 offset-lg-1 page-title">
                    {!! $blog->content1 !!}
                    <a href="#" class="btn main-btn">Sign up</a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="available-section">
        <div class="container">
            <div class="row align-items-center">
                @foreach($data as  $key => $blog)
                <div class="col-lg-5 page-title order-2 order-lg-1">
                    <span class="app-tag">Available for all platforms.</span>
                    {!! $blog->content2 !!}
                    <a href="#" class="playstore-btn">
                        <span>Play Store<br>Get it for free</span>
                        <img src="{{  asset('front/img/play_store.png') }}" alt="">
                    </a>
                </div>
                <div class="col-lg-7 mb-4 mb-lg-0 order-1 order-lg-2">
                    @if($blog->image2!='')
                    <img class="w-100"  src="{{URL::to('/').'/Splash/'}}{{$blog->image2}}">
                @endif
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-12">
                    <a href="#" class="footer-logo">
                        <img class="w-100" src="{{ asset('front/img/footer-logo.png')}}" alt="Local Tales">
                    </a>
                </div>
                <div class="col-12 col-lg-10">
                    <p>
                        Award-winning, in-store coffee roastery, coffee bean boutique and sydney cbd cafe.<br/>VELLA NERO is a one
                        stop shop for all thing coffee.
                    </p>
                </div>
                <div class="col-12">
                    <p class="copy-text">
                        © 2021 Local Tales. All Rights Reserved.
                    </p>
                </div>

            </div>
        </div>
    </footer>

    <script type="text/javascript" src="{{ asset('front/js/jquery-3.6.0.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('front/js/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('front/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('front/js/swiper-bundle.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('front/js/custom.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDPuZ9AcP4PHUBgbUsT6PdCRUUkyczJ66I&libraries=places"></script>

    <script>
        google.maps.event.addDomListener(window,'load',initialize);
        function initialize(){
            var autocomplete= new google.maps.places.Autocomplete(document.getElementById('inputSearchTextFilter'));

            autocomplete.setComponentRestrictions({'country': ['au']});

            google.maps.event.addListener(autocomplete, 'place_changed', function(){

                var places = autocomplete.getPlace();
                console.log(places);
                // console.log(places.formatted_address);
                // console.log(places.address_components.length);
                addressObj = places.address_components;
                // console.log(addressObj);
                addressObjLength = places.address_components.length;
                // console.log(addressObj.addressObjlength);
                for (let index = 0; index < addressObjLength; index++) {
                    if(index = addressObjLength-1) {
                        var pinCode = addressObj[index].long_name;
                        console.log(pinCode);
                        $("#pin").val(pinCode)
                    }
                }
                // console.log(places.website);
                $('#inputSearchTextFilter').val(places.name);
                $('#website').val(places.website);
                $('#email').val(places.email);
                $('#address').val(places.formatted_address);

                if(places.formatted_phone_number){
                    function phpneNumberFormatted(phNum){
                        var i,newValue='';
                        for(i = 0; i < phNum.length; i++){
                            if($.isNumeric(phNum[i])){
                                newValue+=phNum[i];
                            }
                        }
                        return newValue;
                    }
                    var phNum = phpneNumberFormatted(places.formatted_phone_number);
                    // console.log(phNum);

                    $('#mobile').val(phNum);
                } else {
                    $('#mobile').val('');
                }

                $('#selectedLongitude').val(places.geometry.location.lng());
                $('#selectedLatitude').val(places.geometry.location.lat());

                window.location = "{{URL::to('/')}}/business-signup?name="+places.name+"&website="+places.website+"&email="+places.email+"&address="+places.formatted_address+"&mobile="+phNum+"&pin="+pinCode;

            });

        }
    </script>

</body>

</html>
