@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <!-- ========== Inner Banner ========== -->
    @foreach($content as  $key => $blog)
    <section class="inner_banner" style="background-image: url('{{URL::to('/').'/ContactusBanner/'}}{{$blog->banner_image}}');">
        <div class="container">
            <div class="row text-center justify-content-center">
                <div class="col-12 col-lg-10">
                    <h6>{{$blog->pretty_name}}</h6>
                </div>
            </div>
        </div>
    </section>
    @endforeach
    <!-- ========== FAQ ========== -->

    <section class="py-4 py-lg-5 faq">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-7 mb-4 mb-lg-0">
                    <ul class="faq-accordion">
                    @foreach($faq as  $key => $blog)
                        <li class="first-set">  <!-- First Layer -->
                            <div class="toggle">
                                <h3>{{$blog->category}}</h3>
                                <i class="fas fa-minus plus-sign"></i>
                            </div>
                            <div class="inner show">

                                <div class="set">
                                    <h6>{{$blog->subcategory}}</h6>
                                    <ul>
                                        <li class="second-set">   <!-- Second Layer -->
                                            <div class="toggle">
                                                <h5>
                                                    <i class="far fa-check-circle"></i>
                                                    {!! $blog->question !!}
                                                </h5>
                                                <i class="fas fa-plus plus-sign-icon plus-sign"></i>
                                            </div>
                                            <div class="inner">
                                            {!! $blog->answer !!}
                                            </div>
                                        </li>
                                    </ul>
                                </div>


                            </div>
                        </li>  <!-- First Layer -->


                        @endforeach
                    </ul>

                </div>
                <div class="col-12 col-lg-5">
                    <div class="row">
                    @foreach($content as  $key => $blog)
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="row mb-4 mb-lg-5">
                                <div class="col-md-5 p-sm-0 mb-4 mb-md-0">
                                    <div class="card faq-card h-100">
                                        {!! $blog->content !!}
                                        <a href="#" class="">Explore</a>
                                    </div>
                                </div>
                                <div class="col-md-7 img-col">
                                    <img class="w-100" src="{{URL::to('/').'/Contactus/'}}{{$blog->image}}" alt="">
                                </div>
                            </div>
                        </div>
                       
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </section>


    <!-- ========== Subscribe ========== -->
    <section class="py-4 subscribe">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h6>Subscribe For a Newsletter</h6>
                    <p>Want to be notified about new locations? Just sign up.</p>
                </div>
                <div class="col-md-6">
                    <form>
                        <div class="form-group position-relative m-0">
                            <input type="email" class="form-control" placeholder="Enter your email">
                            <button type="submit" class="subscribe-btn">
                                <i class="fa fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== Inner Banner ========== -->
    @endsection
