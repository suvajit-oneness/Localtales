<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 Page Not Found</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container text-center mt-5 pt-5">
        {{-- <div class="alert alert-danger text-center"> --}}
            <img src="{{ asset('front/img/main-logo.png')}}" alt="Local Tales" height="60">
            <h2 class="display-1">404</h2>
            <p class="display-5">Oops! Something is wrong.</p>

            <a href="{{url('/')}}" class="btn btn-danger">Back to HOME</a>
        {{-- </div> --}}
    </div>
</body>

</html>
