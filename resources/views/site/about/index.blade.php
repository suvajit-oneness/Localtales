@extends('site.app')
@section('title') {{ $pageTitle }} @endsection

@section('content')
    @foreach($about as $key => $blog)
    @php
    $demoImage = DB::table('demo_images')->where('title', '=', 'about')->get();
    $demo = $demoImage[0]->image;
    @endphp
    <section class="inner_banner"
    style="background: url({{URL::to('/').'/Demo/' .$demo}})"
                        >
                        <div class="container position-relative">

                            <h1 class="mb-4">About Us</h1>
                    </div>
    </section>
    @endforeach

    @foreach($about as $key => $blog)
    <section class="py-4 py-lg-5">
        <div class="container">
            <div class="row mb-4 mb-lg-5">
                <div class="col-12 best_deal">
                    {!! $blog->content !!}
                </div>
            </div>
            <div class="row mb-4 mb-lg-5 justify-content-between align-items-center">
                <div class="col-lg-4 mb-4 mb-lg-0 pr-md-0">
                    <img class="" src="{{URL::to('/').'/Aboutus/'}}{{$blog->image}}" alt="" style="height: 280px;">
                </div>
                <div class="col-lg-8 best_deal pl-md-0">
                    {!! $blog->content1 !!}
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-12 best_deal">
                    {!! $blog->content2 !!}
                </div>
            </div> --}}
        </div>
    </section>

    {{-- <section class="py-4 py-lg-5">
        <div class="container">
            <div class="row mb-4 mb-lg-5">
                <div class="col-12 best_deal">
                   {!! $blog->content !!}
                </div>
            </div>
            <div class="row mb-4 mb-lg-5 justify-content-between">
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <img class="w-100" src="{{URL::to('/').'/Aboutus/'}}{{$blog->image}}" alt="">
                </div>
                <div class="col-lg-7 best_deal">
                {!! $blog->content1 !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12 best_deal">
                {!! $blog->content2 !!}
                </div>
            </div>
        </div>
    </section> --}}
    @endforeach

@endsection
