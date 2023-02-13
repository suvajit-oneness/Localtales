@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')

    @foreach($dir as  $key => $blog)
    <section class="inner_banner" style="background-image: url('{{URL::to('/').'/Collection/'}}{{$blog->image}}');">
        <div class="container">
            <div class="row text-center justify-content-center">
                <div class="col-12 col-lg-12">
                    <h1>{{ $blog->title }}</h1>
                    {!! $blog->description !!}
                    
                </div>
            </div>
        </div>
    </section>
    @endforeach<!--end_innerbanner-->
    <section class="pt-4 pt-lg-5 cafe-listing">
    <figcaption>
                    <div class="container">
                     <div class="details_info">
                         <ul class="breadcumb_list">
                           <li><a href="{!! URL::to('') !!}">Home</a></li>
                              <li>/</li>

                         <li class="active">    @php $category = \App\Models\Collection::findOrFail($id); @endphp
                            {{$category->title}} </li>
                     </ul>
                   </div>
                </div>
            </figcaption>
    </section>
    @foreach($data as  $key => $blog)
    <section class="py-4 py-lg-5 cafe-listing">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12 col-lg-9 page-title">

                    {!! $blog->content !!}
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center cafe-listing-nav">
                <ul class="d-flex" id="tabs-nav">
                   <li class="">
                        <a href="#grid">
                            <i class="fa fa-th-large"></i>
                        </a>
                    </li>
                    <li class="active">
                        <a href="#list">
                            <i class="fa fa-list"></i>
                        </a>
                    </li>
                    
                </ul>
                
            </div>

            <div id="tab-contents">

            <div class="tab-content" id="grid">
                    <div class="row cafe-card">
                        @foreach($categories as $key => $directory)
                        <div class="col-md-4 col-sm-6 col-12 mb-4">
                            <div class="card border-0">
                                <img src="{{URL::to('/').'/Directory/'}}{{$directory->directory->image}}" class="card-img-top" alt="">
                                <div class="card-body px-0">
                                    <h4> <a href="{!! URL::to('directory-details/'.$directory->directory->id.'/'.strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $directory->directory->name))) !!}" class="location_btn">{{ $directory->directory->name }}</a></h4>
                                    <div class="d-flex justify-content-between align-items-center">
                                  
                                        <span class="location">
                                            <i class="fa fa-map-marker-alt"></i>
                                            <p>{!! $directory->directory->address !!}</p>

                                        </span>

                                    </div>
                                </div>
                                <span class="save">
                                    <img src="{{ asset('front/img/bookmark.png')}}" alt="">
                                </span>
                            </div>
                        </div>
                        <span>
                   {{$directory->directory->count()}} Listed
                </span>
                        @endforeach
                    </div>
                </div>
                <div class="tab-content" id="list">

                    <div class="row cafe-card  justify-content-center">
                        @foreach($categories as $key => $directory)
                        <div class="col-12 col-xl-8 col-lg-10 mb-4">
                            <div class="card border-0">
                                <div class="row">
                                    <div class="col-md-4 col-lg-6">
                                        <img src="{{URL::to('/').'/Directory/'}}{{$directory->directory->image}}" class="card-img-top" alt="">
                                    </div>
                                    <div class="col-md-8 col-lg-6">
                                        <div class="card-body pl-0">
                                            <h4> <a href="{!! URL::to('directory-details/'.$directory->directory->id.'/'.strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $directory->directory->name))) !!}" class="location_btn">{{ $directory->directory->name }}</a></h4>
                                            <p>
                                                {!! $directory->directory->description !!}
                                            </p>
                                            <ul>
                                                <li>
                                                    <i class="fas fa-envelope"></i>
                                                    <a href="matito:test@gmail.com">{{ $directory->email }}</a>
                                                </li>
                                                <li>
                                                    <i class="fas fa-phone-alt"></i>
                                                    <a href="tel">{{ $directory->mobile }}</a>
                                                </li>
                                            </ul>
                                            <div class="location pt-3">
                                                <i class="fa fa-map-marker-alt"></i>
                                                <p>{!! $directory->directory->address !!}</p>

                                                <strong class="rating ml-4">
                                                    <span class="badge">4.5</span>
                                                    Rated
                                                </strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span class="save">
                                    <img src="img/bookmark.png" alt="">
                                </span>
                            </div>
                        </div>
                        <span>
                    <!-- {{$directory->directory->count()}} Listed -->
                    </span>
                        @endforeach
                    </div>
                </div>
               
            </div>



        </div>
    </section>
@endforeach

    <section class="py-s py-5 light-bg more-collection">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center cafe-listing-nav page-title">
                <h3>More Collections</h3>
                
                <span>

                </span>
            </div>
            <div class="row">
                @foreach($leaduser as  $key => $col)
               
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card collectionCard">
                        <a class="cardLink d-block" href="{!! URL::to('collection-page/'.$col->id) !!}">
                            <img src="{{URL::to('/').'/Collection/'}}{{$col->image}}" alt="">
                            <div class="card-body">
                                {{-- <h5><i class="fas fa-map-marker-alt"></i> {{ $col->address }}</h5> --}}
                                <h4 class="location_btn">{{ $col->title }}</h4>
                                {{-- <div class="collectionPlaces">
                                    20 Places
                                    <i class="fas fa-caret-right"></i>
                                </div> --}}
                            </div>
                        </a>
                    </div>
                </div>
                <!-- <span>
                        {{$col->count()}} Places
                    </span> -->
                @endforeach
                {{-- <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <a href="#">
                        <div class="card">
                            <img src="img/collection-2.png" alt="">
                            <div class="card-body">
                                <h5>Melbourne's Best Take..</h5>
                                <a href="#">
                                    20 Places
                                    <i class="fas fa-caret-right"></i>
                                </a>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <a href="#">
                        <div class="card">
                            <img src="img/collection-3.png" alt="">
                            <div class="card-body">
                                <h5>Melbourne's Best Take..</h5>
                                <a href="#">
                                    20 Places
                                    <i class="fas fa-caret-right"></i>
                                </a>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <a href="#">
                        <div class="card">
                            <img src="img/collection-4.png" alt="">
                            <div class="card-body">
                                <h5>Melbourne's Best Take..</h5>
                                <a href="#">
                                    20 Places
                                    <i class="fas fa-caret-right"></i>
                                </a>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <a href="#">
                        <div class="card">
                            <img src="img/collection-5.png" alt="">
                            <div class="card-body">
                                <h5>Melbourne's Best Take..</h5>
                                <a href="#">
                                    20 Places
                                    <i class="fas fa-caret-right"></i>
                                </a>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <a href="#">
                        <div class="card">
                            <img src="img/collection-6.png" alt="">
                            <div class="card-body">
                                <h5>Melbourne's Best Take..</h5>
                                <a href="#">
                                    20 Places
                                    <i class="fas fa-caret-right"></i>
                                </a>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <a href="#">
                        <div class="card">
                            <img src="img/collection-7.png" alt="">
                            <div class="card-body">
                                <h5>Melbourne's Best Take..</h5>
                                <a href="#">
                                    20 Places
                                    <i class="fas fa-caret-right"></i>
                                </a>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <a href="#">
                        <div class="card">
                            <img src="img/collection-8.png" alt="">
                            <div class="card-body">
                                <h5>Melbourne's Best Take..</h5>
                                <a href="#">
                                    20 Places
                                    <i class="fas fa-caret-right"></i>
                                </a>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <a href="#">
                        <div class="card">
                            <img src="img/collection-1.png" alt="">
                            <div class="card-body">
                                <h5>Melbourne's Best Take..</h5>
                                <a href="#">
                                    20 Places
                                    <i class="fas fa-caret-right"></i>
                                </a>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <a href="#">
                        <div class="card">
                            <img src="img/collection-2.png" alt="">
                            <div class="card-body">
                                <h5>Melbourne's Best Take..</h5>
                                <a href="#">
                                    20 Places
                                    <i class="fas fa-caret-right"></i>
                                </a>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <a href="#">
                        <div class="card">
                            <img src="img/collection-3.png" alt="">
                            <div class="card-body">
                                <h5>Melbourne's Best Take..</h5>
                                <a href="#">
                                    20 Places
                                    <i class="fas fa-caret-right"></i>
                                </a>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <a href="#">
                        <div class="card">
                            <img src="img/collection-4.png" alt="">
                            <div class="card-body">
                                <h5>Melbourne's Best Take..</h5>
                                <a href="#">
                                    20 Places
                                    <i class="fas fa-caret-right"></i>
                                </a>
                            </div>
                        </div>
                    </a>
                </div> --}}
            </div>
        </div>
    </section>

    @foreach($data as  $key => $blog)
    <section class="py-4 py-lg-5">
        <div class="container">
            <div class="row page-title">
                <div class="col-12 mb-4">
                    {!! $blog->content1 !!}
                </div>
                <div class="col-12">
                    <a href="#" class="btn main-btn">
                        let us know your experience
                    </a>
                </div>
            </div>
        </div>
    </section>
  @endforeach
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
