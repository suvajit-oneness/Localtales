<!DOCTYPE html>
<html lang="en">
<head>
  <title>Local Tales</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
  <link rel="stylesheet" href="{{ asset('b2b/css/bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('b2b/css/slick.css') }}"/>
  <link rel="stylesheet" type="text/css" href="{{ asset('b2b/css/slick-theme.css') }}"/>
  <link rel="stylesheet" href="{{ asset('b2b/css/style.css') }}">

</head>
<body ><!-- class="login-body" -->


<section class="login_block" style="background: url({{asset('site/images/banner')}}-image.jpg) no-repeat center center; background-size:cover;">
    <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-auto">
                    <a href="{!! URL::to('') !!}"><img src="{{asset('site/images/login')}}-logo.png" class="login_logo"></a>
                    <h1><span>Advertise</span><br/>Your Business</h1>
                </div>
                <div class="col">
                    <div class="form_holder">
                        <h3>Login Now</h3>
                        <form action="{{ route('business.login.post') }}" method="POST" role="form">
                        @if(session()->has('verified'))
                            <div class="alert alert-success">
                                Verified successfully
                            </div>
                        @endif
                        @if(session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session()->get('error') }}
                            </div>
                        @endif
                        @csrf
                        <div class="row px-3">
                            <label class="mb-1">Email Address</label>
                            <input class="mb-4" type="text" name="email" placeholder="Enter a valid email address">
                        </div>
                        <div class="row px-3">
                            <label class="mb-1">Password</label>
                            <input class="mb-4" type="password" name="password" placeholder="Enter password">
                        </div>
                        <!-- <div class="row px-3 mb-4">
                            <div class="custom-control custom-checkbox custom-control-inline"> <input id="chk1" type="checkbox" name="chk" class="custom-control-input"> <label for="chk1" class="custom-control-label text-sm text-dark">Remember me</label> </div> <a href="#" class="ml-auto mb-0 text-sm text-primary">Forgot Password?</a>
                        </div> -->
                        <div class="row mb-3 align-items-center">
                            <div class="col-sm-6">
                                <div class="grid">
                                    <button type="submit" class="btn btn-orange m-0">Login</button>
                                </div>
                            </div>
                            <!-- <div class="col-sm-6 text-right">
                                <a href="#" class="">Forgot Password?</a>
                            </div> -->
                        </div>
                        <div class="row mb-4 px-3"> <small class="font-weight-bold text-muted">Don't have an account? <a class="text-orange " href="{{ route('business.signup') }}">Register</a></small> </div>
                      </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!--Script-->

<script src="{{ asset('b2b/js/jquery.min.js') }}"></script>
<script src="{{ asset('b2b/js/popper.min.js') }}"></script>
<script src="{{ asset('b2b/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('b2b/js/slick.min.js') }}"></script>
<script src="{{ asset('b2b/js/custom.js') }}"></script>




</body>
</html>
