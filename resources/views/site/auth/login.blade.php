<!DOCTYPE html>
<html lang="en">
<head>
  <title>Local Tales</title>
  <link rel="icon" type="image/x-icon"  href="{{ asset('favicon.png') }}">
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

<!-- Navbar-->
<section class="login_block" style="background: url({{asset('site/images/banner')}}-image.jpg) no-repeat center center; background-size:cover;">
    <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-auto login_wrap">
                    <a href="{!! URL::to('') !!}"><img src="{{asset('site/images/login')}}-logo.png" class="login_logo"></a>
                    <h1><span>Advertise</span> <br/>Your Business</h1>
                </div>
                <div class="col">
                    <div class="form_holder">
                        <h3>Login Now</h3>
                      <form action="{{ route('front.user.login.check') }}" method="POST" role="form">
                        @if(session()->has('verified'))
                            <div class="alert alert-success">
                                Verified successfully
                            </div>
                        @endif

                        @csrf
                        <div class="row px-3">
                            <label class="mb-1">Email Address</label>
                            <input class="mb-1 mb-sm-3" type="text" name="email" placeholder="Enter a valid email address" value="{{ old('email') }}">
                            @error('email') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="row px-3">
                            <label class="mb-1">Password</label>
                            <input class="mb-2 mb-sm-3" type="password" name="password" placeholder="Enter password" value="{{ old('password') }}">
                            @error('password') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-sm-6">
                                <div class="grid">
                                    <button type="submit" class="btn btn-orange m-0">Login</button>
                                </div>
                            </div>
                        </div>
                        <div class="w-100">Don't have an account? <a class="text-orange " href="{{ route('front.user.register') }}">Register</a></div>
                        <div class="w-100"><a class="text-orange " href="{!! URL::to('business/login') !!}">Business Login</a></div>
                        <div class="w-100"><a class="text-orange " href="{!! URL::to('eventorganiser/login') !!}">Event Organiser Login</a></div>
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

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        feather.replace()
    </script>

    <script>
        // sweetalert fires | type = success, error, warning, info, question
        function toastFire(type = 'success', title, body = '') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                showCloseButton: true,
                timer: 2000,
                timerProgressBar: false,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: type,
                title: title,
                // text: body
            })
        }

        // on session toast fires
        @if (Session::get('success'))
            toastFire('success', '{{ Session::get('success') }}');
        @elseif (Session::get('failure'))
            toastFire('warning', '{{ Session::get('failure') }}');
        @endif
    </script>


</body>
</html>
