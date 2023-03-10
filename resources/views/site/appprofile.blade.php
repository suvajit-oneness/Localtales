<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title') - {{ config('app.name') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('b2b/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('b2b/css/slick.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('b2b/css/slick-theme.css') }}"/>
    <link rel="stylesheet" href="{{ asset('b2b/css/style.css') }}">

    @yield('styles')

    @stack('styles')
</head>
<body class="bg-lightgray">
    <nav class="mnb navbar navbar-default fixed-top topnav">
        <div class="container-fluid">
            <div class="navbar-header">
                <div>
                    <a href="#" id="msbo" class="menuIcon"><i class="ic fa fa-bars"></i></a>
                    <a href="{!! URL::to('') !!}" class="admin-brand"><img src="{{ asset('b2b/images/logo.png')}}" class="img-fluid"></a>
                </div>
            </div>
            <div id="navbar" class="top-rightmenu">
                <ul class="navbar-nav ml-aoto">
                    <li class="mr-3">
                        <a href="{!! URL::to('notification') !!}"><i class="far fa-bell"></i></a>
                    </li>
                    <li class="">
                        <a href="javascript: void(0)" class="dropdown-head"><i class="far fa-user-circle"></i></a>
                        <div class="dropdown-options">
                            <ul>
                                <li><a href="{{ route('site.dashboard') }}">Dashboard</a></li>
                                <li><a href="{{ route('site.dashboard.editProfile') }}">Edit Profile</a></li>
                                <li><a href="{{ route('user.logout') }}">Logout</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @include('site.partials.sidebar')

    <div class="mcw">
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('b2b/js/jquery.min.js') }}"></script>
    <script src="{{ asset('b2b/js/popper.min.js') }}"></script>
    <script src="{{ asset('b2b/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('b2b/js/slick.min.js') }}"></script>
    <script src="{{ asset('b2b/js/custom.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('b2b/js/ckeditor.js')}}"></script>

    <script>
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

        //TOGGLING NESTED ul
        $(".dropdown-head").click(function() {
            $(".dropdown-options").toggleClass('active');
        });
    </script>

    @stack('scripts')

</body>
</html>
