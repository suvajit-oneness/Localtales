@extends('site.app')
@section('title')
{{ $blog->title }}
@endsection
@php
if(!empty($blog->content)){
    $meta_description= strip_tags($blog->content);
    $meta_desc=explode(".",$meta_description);
// dd($meta_desc);
    if (!empty($meta_desc[1])) {
        $description= $meta_desc[0]. "." .$meta_desc[1]. ".";
    } else {
        $description= $meta_desc[0];
    }

}
else{
    $description='';
}
@endphp
@section('description', $description)
@section('content')
    {{-- CKEDITOR 5 INCLUDE --}}
    <link rel="stylesheet" href="{{ asset('backend/ckeditor5-36.0.1-dundmb20fh0i/sample/content-styles.css') }}">
    <style>
        .a2a_svg svg {
            margin-right: 0!important;
        }
            .Articletag {
            padding: 0 15px !important;
           line-height: 32px;
           }
        
        .Bestdeals .location_btn:hover img {
            margin-bottom: 8px;
            margin-left: 0 !important;
        }
    </style>

    <section class="artiledetails_banner">
        <div class="container-fluid">
            <div class="artiledetails_banner_img">
                @if($blog->image)
                    <img class="w-100" src="{{URL::to('/').'/Blogs/'}}{{$blog->image}}" alt="">
                @else
                    @php
                        $demoImage = DB::table('demo_images')->where('title', '=', 'article')->get();
                        $demo = $demoImage[0]->image;
                    @endphp
                    <img class="w-100" src="{{URL::to('/').'/Demo/'}}{{$demo}}">
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
                            @if(is_array($blog->category) && count($blog->category)>0)
                            <li><a href="{!! URL::to('/article/category/'.$blog->category->slug) !!}">
                            @endif
                            @php
                                $cat = $blog->blog_category_id ?? '';
                                $displayCategoryName = '';
                                foreach(explode(',', $cat) as $catKey => $catVal) {
                                    if($catKey==0){
                                    $catDetails = DB::table('blog_categories')->where('id', $catVal)->first();
                                    if($catDetails !=''){
                                        $displayCategoryName .= '<li><a href="'.route("article.category", $catDetails->slug).'">'.$catDetails->title.'</a>  ';
                                    }
                                }
                                }
                                echo substr($displayCategoryName, 0, -2);
                            @endphp
                            </a></li>
                            <li>/</li>
                            <li>{{ $blog->title }}</li>
                        </ul>
                        <h1>{{ $blog->title }}</h1>
                        <div class="row">
                            <div class="col">
                                <ul class="articlecat">
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                        {{ $blog->updated_at->format('d M Y') }}
                                    </li>
@if(is_array($blog->category) && count($blog->category)>0)
                            <li>
                                <a href="{!! URL::to('/article/category/'.$blog->category->slug) !!}">
                            @endif
                            @php
                                $cat = $blog->blog_category_id ?? '';
                                $displayCategoryName = '';
                                foreach(explode(',', $cat) as $catKey => $catVal) {
                                    $catDetails = DB::table('blog_categories')->where('id', $catVal)->first();
                                    if($catDetails !=''){
                                        $displayCategoryName .= '<li><a class="blogDetailsCatbadge" href="'.route("article.category", $catDetails->slug).'">'.$catDetails->title.'</a>  ';
                                    }
                                }
                                echo substr($displayCategoryName, 0, -2);
                            @endphp
                            </a></li>
                            @if($blog->subcategory!='')
                            <li>
                                <a class="blogDetailsCatbadge" href="{!! URL::to('/article/category/'.$blog->category->slug .'/'.$blog->subcategory->slug) !!}">{{$blog->subcategory? $blog->subcategory->title : ''}}
                            </a></li>
                            @endif
                            @if($blog->subcategorylevel!='')
                            <li>
                                <a class="blogDetailsCatbadge" href="{!! URL::to('/article/category/'.$blog->category->slug .'/'.$blog->subcategory->slug.'/'.$blog->subcategorylevel->slug) !!}">{{$blog->subcategorylevel? $blog->subcategorylevel->title : ''}}
                            </a></li>
                            @endif

                                    <li>
                                        <div class="share-btns ml-0">
                                            <div class="dropdown">
                                                <button class="share_button dropdown-toggle px-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- for sticky image half or full -->
    @if($blog->type==1)
    <section class="py-2 py-sm-4 art-dtls">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mb-4 mb-lg-0 article_content ck-content">
                    {!! $blog->content !!}
                </div>
                <div class="col-lg-4 art-aside">
                    <div class="become p-4">
                        @if($blog->sticky_image !=null)
                            <div class="p-3" style="background-image: url('{{URL::to('/').'/Blogs/'.$blog->sticky_image}}');">
                        @else
                            <div class="p-3" style="background-image: url('{{URL::to('/').'/front/img/aside.png'}}');">
                        @endif
                        <div class="become-text">
                            <h3>
                               {{$blog->heading}}
                            </h3>
                            {!! $blog->sticky_content !!}
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
    @elseif($blog->type==2)
    <section class="py-2 py-sm-4 art-dtls">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mb-4 mb-lg-0 article_content">
                    {!! $blog->content !!}
                </div>
                <div class="col-lg-4 art-aside">
                   
                    <div class="sticky_block">
                        <figure>
                            @if($blog->sticky_image !=null)
                                <img src="{{URL::to('/').'/Blogs/'.$blog->sticky_image}}">
                            @else
                                <img src="{{URL::to('/').'/front/img/aside.png'}}">
                            @endif
                        </figure>
                        <figcaption>
                            <h4>{{$blog->heading}}</h4>
                            {!! $blog->sticky_content !!}
                            @if($blog->btn_text)
                                <a href=" {{$blog->btn_link}}" class="btn main-btn"> {{$blog->btn_text}}</a>
                            @else
                            @endif
                        </figcaption>
                    </div>

                </div>
            </div>
        </div>
    </section>
    @endif

    @if(count($faq) > 0)
    <section class="py-2 py-sm-4 py-lg-5">
        <div class="container">
            <div class="faq mt-4">
                <div class="row">
                    <div class="col-12">
                        <div class="best_deal page-title">
                            <h2>Frequently asked questions</h2>
                        </div>
                    </div>
                </div>
                <div class="row m-0">
                    <div class="col-12 p-0">
                        <ul class="faq-accordion">
                            <li class="first-set">
                                <div class="inner show container-fluid">
                                    <div class="set mt-0">
                                        <ul>
                                            @foreach ( $faq  as $blogProductkey => $blogProductValue)
                                            <li class="second-set">
                                                <div class="toggle mb-0">
                                                    {!! $blogProductValue->question !!}
                                                    <i class="fas fa-plus plus-sign-icon plus-sign"></i>
                                                </div>
                                                <div class="inner">
                                                    {!! $blogProductValue->answer !!}
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <section class="py-2 py-sm-4 py-lg-5 bg-light">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col">
                    <div class="page-title best_deal">
                        <h2>Relevant Articles</h2>
                    </div>
                </div>

                <div class="col-auto">
                    <div class="articleSliderBtn">
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
            </div>
            <div class="row m-0">
                <div class="col-12">
                    <div class="swiper Bestdeals Bestdeals2">
                        <div class="swiper-wrapper">
                            @foreach($relatedBlogs as  $key => $blog)
                            @php
                            if($blog->image =='') { continue; }
                            @endphp
                            <div class="swiper-slide jQueryEqualHeight">
                                <div class="card blogCart border-0">
                                    <div class="bst_dimg">
                                        @if($blog->image)
                                    <a href="{!! URL::to('article/'.$blog->slug) !!}" class="location_btn w-100"><img src="{{URL::to('/').'/Blogs/'}}{{$blog->image}}" class="card-img-top" alt="ltItem"></a>
                                        @else
                                        @php
                                            $demoImage=DB::table('demo_images')->where('title', '=', 'article')->get();
                                            $demo=$demoImage[0]->image;

                                        @endphp
                                        <a href="{!! URL::to('article/'.$blog->slug) !!}" class="location_btn w-100"><img src="{{URL::to('/').'/Demo/'}}{{$demo}}" class="card-img-top"></a>
                                        @endif
                                        <div class="dateBox">
                                            <span class="date">{{$blog->updated_at->format('d')}}</span>
                                            <span class="month">{{$blog->updated_at->format('M')}}</span>
                                            <span class="year">{{$blog->updated_at->format('Y')}}</span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="card-body-top">
                                            <h5 class="card-title m-0"><a href="{!! URL::to('article/'.$blog->slug) !!}" class="location_btn">{{ $blog->title }}</a></h5>
                                            @if($blog->blog_category_id)
                                            <div class="article_badge_wrap mt-3 mb-1">
                                                @php
                                                    $cat = $blog->blog_category_id;
                                                    $displayCategoryName = '';
                                                    foreach(explode(',', $cat) as $catKey => $catVal) {
                                                        $catDetails = DB::table('blog_categories')->where('id', $catVal)->first();
                                                        //if(is_array($catDetails) && count($catDetails)>0){
                                                        if($catDetails !=''){
                                                            $displayCategoryName .= '<a href="'.route("article.category", $catDetails->slug).'">'.'<span class="badge p-1" style="font-size: 10px;">'.$catDetails->title.'</span>'.'</a>  ';
                                                        }
                                                    }
                                                    echo $displayCategoryName;
                                                @endphp
                                            </div>
                                            @endif
                                        </div>
                                        <div class="card-body-bottom">
                                            {{-- <span class="tag_text">{{ $blog->tag }}</span> --}}
                                            <!--<a href="{!! URL::to('blog-details/'.$blog->id.'/'.strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $blog->title))) !!}" class="location_btn">Read More <img src="{{asset('site/images/right-arrow.png')}}"></a>-->
                                            <a href="{!! URL::to('article/'. $blog->slug) !!}" class="readMoreBtn">Read More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script async src="https://static.addtoany.com/menu/page.js"></script>
@endpush
