<!DOCTYPE html>
<html>
<head>
    <title>Local Tales</title>
    <style>
        .text-align-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <p>{{$title}}</p>
    @if($image == 1)
    <img src="{{ $message->embed(URL::to('/').'/email/'.$body) }}" width="100%" height="100%"/>
    @else
    <p>{!! $body !!}</p>
    @endif
    <h1 class="text-align-center">Email Verification Mail</h1>
  
    <p class="text-align-center">Please verify your email with bellow link: 
    <a href="{{ route('user.verify', $token) }}">Verify Email</a></p>
    <p class="text-align-center"><a href="{{$url}}">LOGIN URL</a></p>
    <p class="text-align-center">Here are your credentials for Login: </p>
    <p class="text-align-center"> Email : {{$email}}</p>
    <p class="text-align-center"> Password : Welcome@2022</p>
    <p>Thank you</p>
   
</body>
</html>