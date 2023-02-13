@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')

    <!-- ========== Inner Banner ========== -->
    <section class="artiledetails_banner">
        <div class="container-fluid">
            <div class="artiledetails_banner_img">
                {{-- <img class="w-100" src="{{asset('Blogs/'.$blog->banner_image)}}" alt=""> --}}
                                  @if($blog->image)
                                   <img class="w-100" src="{{URL::to('/').'/Blogs/'}}{{$blog->banner_image}}" alt="">
                                     @else
                                    <img class="w-100" src="{{asset('Directory/placeholder-image.png')}}" >
                                    @endif

            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="artiledetails_banner_text">
                    <ul class="breadcumb_list mb-2 mb-sm-4">
                        <li><a href="{!! URL::to('') !!}">Home</a></li>
                        <li>/</li>
                        <li><a href="{!! URL::to('article') !!}">Article</a></li>
                        <li>/</li>
                         <li> <a href="{!! URL::to('category/'.$blog->blog_category_id) !!}">{{ $blog->category? $blog->category->title : ''}}</a></li>
                             <li>/</li>
                        <li>{{ $blog->title }}</li>
                    </ul>
                        <div class="article_badge_wrap">
                            <span class="badge">{{$blog->suburb? $blog->suburb->name : ''}}</span>
                            <span class="badge"><a href="{!! URL::to('category/'.$blog->blog_category_id) !!}">{{ $blog->category? $blog->category->title : ''}}</span></a>
                              <span class="badge">{{ $blog->subcategory? $blog->subcategory->title : ''}}</span>
                              @if($blog->blog_tertiary_category_id == 10)

                              @else
                            <span class="badge">{{$blog->subcategorylevel? $blog->subcategorylevel->title : ''}}</span>
                             @endif
                        </div>
                        <h1>{{ $blog->title }}</h1>
                        <div class="row">
                            <div class="col">
                                <ul class="articlecat">
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                        {{ $blog->created_at->format('d M Y') }}
                                    </li>
                                    @if($blog->tag)
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tag"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                                        {{ $blog->tag ?? '' }}
                                    </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="col-auto">
                                <div class="share-btns">
                                    <div class="dropdown">
                                        <button class="share_button dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#898989" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share-2"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                            <div class="w-100 pl-2">
                                                <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                                    <a class="a2a_button_facebook"></a>
                                                    <a class="a2a_button_twitter"></a>
                                                    <a class="a2a_button_whatsapp"></a>
                                                    <a class="a2a_button_pinterest"></a>
                                                    <a class="a2a_button_linkedin"></a>
                                                    <a class="a2a_button_telegram"></a>
                                                    <a class="a2a_button_reddit"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== Articles section ========== -->
    <section class="py-2 py-sm-4 art-dtls">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 mb-4 mb-lg-0">
                    <p>{!! $blog->content !!}</p>
                   {{-- <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="metaImg">
                                @if($blog->image)
                                   <img class="w-100 my-3" src="{{URL::to('/').'/Blogs/'}}{{$blog->image}}" alt="">
                                     @else
                                    <img src="{{asset('Directory/placeholder-image.png')}}" >
                                    @endif
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="metaImg">
                                @if($blog->image)
                                   <img class="w-100 my-3" src="{{URL::to('/').'/Blogs/'}}{{$blog->image2}}" alt="">
                                     @else
                                    <img src="{{asset('Directory/placeholder-image.png')}}" >
                                    @endif
                            </div>
                        </div>
                    </div>
                    <h3>
                       {!! $blog->content !!}
                    </h3>
                    <p>
                        {!! $blog->meta_description !!}
                    </p>--}}
                </div>
                <div class="col-lg-5 art-aside">
                    <div class="become p-4">
                        @if($blog->sticky_image !=null)
                        <div style="background-image: url({{$blog->sticky_image}});">
                        @else
                        <div style="background-image: url('../img/aside.png');">
                        @endif
                        <div class="become-text">
                            <h3>
                               {{$blog->heading}}
                            </h3>
                            <p>
                                {!! $blog->sticky_content !!}
                            </p>
                            @if($blog->btn_text)
                            <a href=" {{$blog->btn_link}}" class="btn main-btn"> {{$blog->btn_text}}</a>
                            @else
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="">
        <div class="container">
            <div class="art-aside">
                <div class="row">
                    @foreach ( $widget as $blog)


                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="card alert" role="alert">
                        <div class="card-body p-0">
                            <h3>{{ $blog->widget_heading }}</h3>
                            <p>
                                {!! $blog->widget_content !!}
                            </p>
                            <a href="{{ $blog->widget_btn_link }}" class="btn main-btn">{{ $blog->widget_btn_text }}</a>
                        </div>
                        <button type="button" class="cross-icon close" data-dismiss="alert" aria-label="Close">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    </div>
                    @endforeach

                </div>
                <div class="row">
                    @foreach ( $feature as $blog)
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="card listing-card text-left">
                            <div class="row">
                               {{--   <div class="col-sm-6">
                                    @if($blog->image !=null)
                                    <img src="{{ asset('Blogs/'.$blog->image) }}" alt="">

                                    @else
                                    <img src="{{ asset('front/img/logo2.png')}}" alt="">
                                    @endif
                                </div>--}}
                                <div class="col-sm-6">
                                    <h3>{{ $blog->heading }}</h3>
                                    <ul>
                                        <li>{{ $blog->highlights }}</li>

                                    </ul>
                                </div>
                            </div>
                            <hr>
                            <h3>Key Features</h3>
                            <ul class="feature-list">
                                <li>
                                    <i class="fa fa-check-circle"></i>
                                    {{ $blog->features }}
                                </li>


                            </ul>
                        </div>
                        <div class="card mt-0 text-center">
                            <div class="card-body p-0">
                                <h4>{!! $blog->content !!}</h4>
                                <a href="{{ $blog->btn_link }}" class="btn main-btn d-block">{{ $blog->btn_text }}</a>
                            </div>
                        </div>
                    </div>
                   @endforeach
                    </div>
                    <!--<div class="col-lg-6 col-md-6 col-12">
                        <div class="card listing-card text-left">
                            <div class="row">
                                <div class="col-sm-6">
                                    <img src="{{ asset('front/img/logo2.png')}}" alt="">
                                </div>
                                <div class="col-sm-6">
                                    <h3>The Onigiri</h3>
                                    <ul>
                                        <li>Selling point 1</li>
                                        <li>Selling point 2</li>
                                        <li>Selling point 3</li>
                                    </ul>
                                </div>
                            </div>
                            <hr>
                            <h3>Key Features</h3>
                            <ul class="feature-list">
                                <li>
                                    <i class="fa fa-check-circle"></i>
                                    Features 1
                                </li>
                                <li>
                                    <i class="fa fa-check-circle"></i>
                                    Features 2
                                </li>
                                <li>
                                    <i class="fa fa-check-circle"></i>
                                    Features 3
                                </li>
                                <li>
                                    <i class="fa fa-check-circle"></i>
                                    Features 4
                                </li>
                                <li>
                                    <i class="fa fa-check-circle"></i>
                                    Features 5
                                </li>
                                <li>
                                    <i class="fa fa-check-circle"></i>
                                    Features 6
                                </li>
                                <li>
                                    <i class="fa fa-check-circle"></i>
                                    Features 7
                                </li>
                                <li>
                                    <i class="fa fa-check-circle"></i>
                                    Features 8
                                </li>
                                <li>
                                    <i class="fa fa-check-circle"></i>
                                    Features 9
                                </li>

                            </ul>
                        </div>
                        <div class="card mt-0 text-center">
                            <div class="card-body p-0">
                                <h4>Find Free Quote For Food & Drinks</h4>
                                <a href="#" class="btn main-btn d-block">free quotes</a>
                            </div>
                        </div>
                    </div>-->
                </div>
            </div>
        </div>
    </section>

    <!--FAQ-->
    <section class="py-2 py-sm-4 py-lg-5">
        <div class="container">
            <!-- ========== FAQ ========== -->
            <div class="faq mt-4">
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="best_deal page-title">
                            <h2>Frequently asked questions</h2>
                        </div>
                    </div>
                </div>
                <div class="row m-0">
                    <div class="col-12 p-0">
                        <ul class="faq-accordion">
                            @foreach ( $faq as $item)
                           
                            @php
                                 if($item->blogs->count() == 0) { continue; }
                            @endphp
                           
                            <li class="first-set">
                                <!-- First Layer -->
                                <div class="toggle">
                                    <h3>{{ $item->category->title }}</h3>
                                    <i class="fas fa-minus plus-sign"></i>
                                </div>
                                <div class="inner show container-fluid">

                                    <div class="set">
                                        <h6>{{ $item->subcategory->title }}</h6>
                                        <ul>
                                            @foreach ( $faq  as $blogProductkey => $blogProductValue)
                                            <li class="second-set">
                                                <!-- Second Layer -->
                                                <div class="toggle">
                                                    <h5>
                                                        
                                                        {!! $blogProductValue->question !!}
                                                    </h5>
                                                    <i class="fas fa-plus plus-sign-icon plus-sign"></i>
                                                </div>
                                                <div class="inner">
                                                    <p>
                                                        {!! $blogProductValue->answer !!}
                                                    </p>
                                                </div>
                                            </li> 
                                            @endforeach<!-- Second Layer -->
                                           {{--   <li class="second-set">
                                                <!-- Second Layer -->
                                                <div class="toggle">
                                                    <h5>
                                                        <i class="far fa-check-circle"></i>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit?
                                                    </h5>
                                                    <i class="fas fa-plus plus-sign-icon plus-sign"></i>
                                                </div>
                                                <div class="inner">
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                        Maecenas tempus
                                                        placerat fringilla. Duis a elit et dolor laoreet
                                                        volutpat. Aliquam
                                                        ultrices
                                                        mauris id mattis imperdiet. Aenean cursus ultrices justo
                                                        et varius.
                                                        Suspendisse aliquam orci id dui dapibus blandit. In hac
                                                        habitasse platea
                                                        dictumst.
                                                        Sed risus velit, pellentesque eu enim ac, ultricies
                                                        pretium felis.
                                                    </p>
                                                </div>
                                            </li> <!-- Second Layer -->
                                            <li class="second-set">
                                                <!-- Second Layer -->
                                                <div class="toggle">
                                                    <h5>
                                                        <i class="far fa-check-circle"></i>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit?
                                                    </h5>
                                                    <i class="fas fa-plus plus-sign-icon plus-sign"></i>
                                                </div>
                                                <div class="inner">
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                        Maecenas tempus
                                                        placerat fringilla. Duis a elit et dolor laoreet
                                                        volutpat. Aliquam
                                                        ultrices
                                                        mauris id mattis imperdiet. Aenean cursus ultrices justo
                                                        et varius.
                                                        Suspendisse aliquam orci id dui dapibus blandit. In hac
                                                        habitasse platea
                                                        dictumst.
                                                        Sed risus velit, pellentesque eu enim ac, ultricies
                                                        pretium felis.
                                                    </p>
                                                </div>
                                            </li>
                                        </ul> <!-- Second Layer -->
                                    </div>

                                    <div class="set">
                                        <h6>Fruits & vegitables</h6>
                                        <ul>
                                            <li class="second-set">
                                                <!-- Second Layer -->
                                                <div class="toggle">
                                                    <h5>
                                                        <i class="far fa-check-circle"></i>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit?
                                                    </h5>
                                                    <i class="fas fa-plus plus-sign-icon plus-sign"></i>
                                                </div>
                                                <div class="inner">
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                        Maecenas tempus
                                                        placerat fringilla. Duis a elit et dolor laoreet
                                                        volutpat. Aliquam
                                                        ultrices
                                                        mauris id mattis imperdiet. Aenean cursus ultrices justo
                                                        et varius.
                                                        Suspendisse aliquam orci id dui dapibus blandit. In hac
                                                        habitasse platea
                                                        dictumst.
                                                        Sed risus velit, pellentesque eu enim ac, ultricies
                                                        pretium felis.
                                                    </p>
                                                </div>
                                            </li> <!-- Second Layer -->
                                        </ul>
                                    </div>

                                    <div class="set">
                                        <h6>Healthy eating</h6>
                                        <ul>
                                            <li class="second-set">
                                                <!-- Second Layer -->
                                                <div class="toggle">
                                                    <h5>
                                                        <i class="far fa-check-circle"></i>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit?
                                                    </h5>
                                                    <i class="fas fa-plus plus-sign-icon plus-sign"></i>
                                                </div>
                                                <div class="inner">
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                        Maecenas tempus
                                                        placerat fringilla. Duis a elit et dolor laoreet
                                                        volutpat. Aliquam
                                                        ultrices
                                                        mauris id mattis imperdiet. Aenean cursus ultrices justo
                                                        et varius.
                                                        Suspendisse aliquam orci id dui dapibus blandit. In hac
                                                        habitasse platea
                                                        dictumst.
                                                        Sed risus velit, pellentesque eu enim ac, ultricies
                                                        pretium felis.
                                                    </p>
                                                </div>
                                            </li> <!-- Second Layer -->
                                            <li class="second-set">
                                                <!-- Second Layer -->
                                                <div class="toggle">
                                                    <h5>
                                                        <i class="far fa-check-circle"></i>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit?
                                                    </h5>
                                                    <i class="fas fa-plus plus-sign-icon plus-sign"></i>
                                                </div>
                                                <div class="inner">
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                        Maecenas tempus
                                                        placerat fringilla. Duis a elit et dolor laoreet
                                                        volutpat. Aliquam
                                                        ultrices
                                                        mauris id mattis imperdiet. Aenean cursus ultrices justo
                                                        et varius.
                                                        Suspendisse aliquam orci id dui dapibus blandit. In hac
                                                        habitasse platea
                                                        dictumst.
                                                        Sed risus velit, pellentesque eu enim ac, ultricies
                                                        pretium felis.
                                                    </p>
                                                </div>
                                            </li> <!-- Second Layer -->
                                            <li class="second-set">
                                                <!-- Second Layer -->
                                                <div class="toggle">
                                                    <h5>
                                                        <i class="far fa-check-circle"></i>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit?
                                                    </h5>
                                                    <i class="fas fa-plus plus-sign-icon plus-sign"></i>
                                                </div>
                                                <div class="inner">
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                        Maecenas tempus
                                                        placerat fringilla. Duis a elit et dolor laoreet
                                                        volutpat. Aliquam
                                                        ultrices
                                                        mauris id mattis imperdiet. Aenean cursus ultrices justo
                                                        et varius.
                                                        Suspendisse aliquam orci id dui dapibus blandit. In hac
                                                        habitasse platea
                                                        dictumst.
                                                        Sed risus velit, pellentesque eu enim ac, ultricies
                                                        pretium felis.
                                                    </p>
                                                </div>
                                            </li>--}} <!-- Second Layer -->
                                        </ul>
                                    </div>

                                </div>
                            </li> <!-- First Layer -->
                            @endforeach
                            
                                       
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== Relevent Articles ========== -->
    <section class="py-2 py-sm-4 py-lg-5 bg-light">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col">
                    <div class="page-title best_deal">
                        <h2>Relevent Articles</h2>
                    </div>
                </div>

                <div class="col-auto">
                    <!--<a href="#" class="viewAllBtn">View All</a>-->
                    <div class="articleSliderBtn">
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
            </div>
            <div class="row m-0">
                <div class="swiper Bestdeals Bestdeals2">
                    <div class="swiper-wrapper">
                        @foreach($latestBlogs as  $key => $blog)
                        <div class="swiper-slide">
                            <div class="card blogCart border-0">
                                <div class="bst_dimg">
                                     @if($blog->image)
                                   <img src="{{URL::to('/').'/Blogs/'}}{{$blog->image}}" class="card-img-top" alt="ltItem">
                                     @else
                                    <img src="{{asset('Directory/placeholder-image.png')}}" >
                                    @endif
                                </div>
                                <div class="card-body">
                                    <div class="card-body-top">
                                        <h5 class="card-title m-0"><a href="{!! URL::to('article-details/'.strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $blog->title))) !!}" class="location_btn">{{ $blog->title }}</a></h5>
                                    </div>
                                    <div class="card-body-bottom">
                                        {{-- <p>
                                            {!! $blog->content !!}
                                        </p> --}}
                                        <span class="tag_text">{{ $blog->tag }}</span>
                                        <!--<a href="{!! URL::to('blog-details/'.$blog->id.'/'.strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $blog->title))) !!}" class="location_btn">Read More <img src="{{asset('site/images/right-arrow.png')}}"></a>-->
                                        <a href="{!! URL::to('article-details/'.strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $blog->title))) !!}" class="readMoreBtn">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="form-inline my-2 my-lg-0">
                        	<a type="button" class="btn btn-login" href="{!! URL::to('site-edit-profile') !!}">Was this article helpful?</a>
                        </div>
                        {{-- <div class="swiper-slide">
                            <div class="card border-0">
                                <div class="bst_dimg">
                                    <img src="./img/fd2.png" class="card-img-top" alt="ltItem">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title m-0">Morbiat semper nunc mollis accumsan</h5>
                                    <p>
                                        Morbi consequat semper nunc, mollis cumsa enim molestie tem. velit aliquam.
                                    </p>
                                    <span class="tag_text"># 3095, # Eltham , # Eltham North</span>
                                    <a href="#">Read More...</a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card border-0">
                                <div class="bst_dimg">
                                    <img src="./img/fd3.png" class="card-img-top" alt="ltItem">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title m-0">Morbiat semper nunc mollis accumsan</h5>
                                    <p>
                                        Morbi consequat semper nunc, mollis cumsa enim molestie tem. velit aliquam.
                                    </p>
                                    <span class="tag_text"># 3095, # Eltham , # Eltham North</span>
                                    <a href="#">Read More...</a>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <!--<div class="swiper-button-next"></div>-->
                    <!--<div class="swiper-button-prev"></div>-->
                    <!--<div class="swiper-pagination"></div>-->
                </div>
            </div>
        </div>
    </section>



    <!-- ========== Subscribe ========== -->
   
    <!-- ========== Inner Banner ========== -->
   @endsection
@push('scripts')

    <script async src="https://static.addtoany.com/menu/page.js"></script>



@endpush
