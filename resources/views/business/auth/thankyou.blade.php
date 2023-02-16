@extends('site.app')
{{-- @section('title') {{ $pageTitle }} @endsection --}}
@section('content')

    <section class="thank-you">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <img src="{{ asset('front/img/logo-icon.png')}}" alt="" class="logo-tnx">
                    <h1>Thank You</h1>
                    <h3>FOR BEING A PART OF US</h3>
                    <p>Check your mail to verify</p>
                    <div class="mt-4 mt-md-5">
                        <!-- <button type="button" class="btn main-btn btn_buseness">BACK TO HOME</button> -->
                        <a type="button" class="btn main-btn ml-3" href="{{route('index')}}">Go to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
