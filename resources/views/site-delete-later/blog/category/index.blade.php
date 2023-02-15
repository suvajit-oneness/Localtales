@extends('site.app')
@section('title')
@php
$meta_title=DB::table('seo_management')->where('page', '=', 'article_primary_category')->get();
$title=$meta_title[0]->title;
if(!empty($cat[0]->description)){
$meta_desc=explode(".",$cat[0]->description);

$description= $meta_desc[0]. "." .$meta_desc[1]. "."  ?? '';
}
else{
    $description= '';
}
@endphp
 {{$title}}
@stop
@section('description', $description)
@section('content')

    <!-- ========== Inner Banner ========== -->

    <section class="inner_banner"
    @if($cat[0]->image)
            style="background: url({{URL::to('/').'/categories/'}}{{$cat[0]->image}})" class="w-100" height: 350px;object-fit: cover

    @else
    @php

        $demoImage=DB::table('demo_images')->where('title', '=', 'category')->get();
        $demo=$demoImage[0]->image;
    @endphp
            style="background: url({{URL::to('/').'/Demo/' .$demo}})" class="w-100" height: 350px;object-fit: cover

    @endif>
        <div class="container position-relative">
            <h1>{{$cat[0]->title}}</h1>
            <h4>Resources</h4>
        </div>
    </section>
    <section class="Categorysearch">
        <div class="container position-relative">
            <div class="page-search-block filterSearchBoxWraper" style="bottom: -83px;">
                <div class="filterSearchBox">
                    <form action="" id="checkout-form">
                        <div class="filterSearchBox">
                            <div class="row">
                                <div class="mb-sm-0 col col-lg fcontrol position-relative filter_selectWrap filter_selectWrap2">
                                    <div class="select-floating">
                                        <img src="{{ asset('front/img/grid.svg')}}">
                                        <label>Category</label>
                                        <select class="filter_select form-control" name="title" id="searchFilterSelect" onchange="location =  this.options[this.selectedIndex].value;">
                                            <option value="" hidden selected>Select Category...</option>
                                            @foreach ($articlecat as $index => $item)
                                                <option value="{{$item->slug}}" {{ (request()->input('title') == $item->title) ? 'selected' : '' }}><a href="{{ route('article.category',$item->slug) }}">{{ $item->title }}</a></option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section class="pb-4 pb-lg-5 our-process">
        <div class="container">
        <ul class="breadcumb_list mb-4 border-bottom pb-2">
            <li><a href="{!! URL::to('/') !!}">Home</a></li>
            <li>/</li>
            <li><a href="{{ route('article.index') }}">Article</a></li>
            <li>/</li>
            <li class="active">{{$cat[0]->title}}</li>
        </ul>
       </div>
    </section>

    <!-- ========== Description ========== -->
  @if($cat[0]->description!='')
    <section class="map_section pb-4 pb-lg-5 pt-3">
        <div class="container">
            <div class="row m-0 justify-content-center">
                <div class="col-12">
                 <p>{!! $cat[0]->description ?? '' !!}</p>
                </div>
            </div>
        </div>
    </section>
@endif
  @if($cat[0]->short_content!='')
<section class="pb-4 pb-lg-5 our-process">
    <div class="container">
        <div class="page-title best_deal">
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                    <h4>
                        {!! $cat[0]->short_content ?? '' !!}
                    </h4>
            </div>
        </div>
    </div>
</section>
@endif
 <!-- ========== Description ========== -->
  @if($cat[0]->medium_content)
     <section class="pb-4 pb-lg-5 top-deals">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 best_deal order-2 order-lg-1">
                    <p>
                        {!! $cat[0]->medium_content ?? '' !!}
                    </p>
                </div>
            </div>
        </div>
    </section>
    @endif
    @if($cat[0]->medium_content_image)
     <section class="pb-4 pb-lg-5 top-deals">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 order-1 order-lg-2 mb-4 mb-lg-0">
                    <img class="w-100" src="{{URL::to('/').'/categories/'}}{{$cat[0]->medium_content_image}}" alt="">
                </div>
            </div>
        </div>
    </section>
    @endif
    <!-- ========== Our Process ========== -->
     @if($cat[0]->long_content)
<section class="pb-4 pb-lg-5 our-process">
    <div class="container">
        <div class="page-title best_deal">

        </div>
        <div class="row justify-content-center">
            <div class="col-12">

                    <h4>
                        {!!  $cat[0]->long_content ?? '' !!}
                    </h4>
            </div>
        </div>
    </div>
</section>
    @endif
    @if($cat[0]->long_content_image)
    <section class="pb-4 pb-lg-5 top-deals">
       <div class="container">
           <div class="row">
               <div class="col-lg-6 order-1 order-lg-2 mb-4 mb-lg-0">
                   <img class="w-100" src="{{URL::to('/').'/categories/'}}{{$cat[0]->long_content_image}}" alt="">
               </div>
           </div>
       </div>
   </section>
   @endif
    <!-- ========== Articles ========== -->
    @if(count($latestBlogs)>0)
    <section class="py-4 py-lg-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col">
                </div>
                <div class="col-auto">

                </div>
            </div>

            <div class="Bestdeals bestdeals-no-slide categoryDeals CategoryarticleTitle">
                <div class="row w-100">
                    @foreach($latestBlogs as  $key => $content)
                    @php
                        if($content->image =='') { continue; }
                    @endphp
                        <div class="col-lg-3 col-xl-3 col-md-4 col-sm-6 col-6 jQueryEqualHeight">
                            <div class="card innerCatlistCard border-0">
                                <div class="bst_dimg">
                                    <!--<div class="cmg_div">Coming Soon</div>-->
                                    @if($content->image)
                                    <a href="{!! URL::to('article/'. $content->slug) !!}" class="location_btn w-100"><img src="{{URL::to('/').'/Blogs/'}}{{$content->image}}" class="card-img-top" alt="ltItem"></a>
                                    @else
                                    @php
                                        $demoImage=DB::table('demo_images')->where('title', '=', 'article')->get();
                                        $demo=$demoImage[0]->image;
                                        //dd($demoImage);
                                    @endphp
                                         <a href="{!! URL::to('article/'. $content->slug) !!}" class="location_btn w-100"><img src="{{URL::to('/').'/Demo/'}}{{$demo}}" class="card-img-top"></a>
                                    @endif
                                    <div class="dateBox">
                                        <span class="date"> {{ date('d', strtotime($content->updated_at)) }}</span>
                                        <span class="month"> {{ date('M', strtotime($content->updated_at)) }}</span>
                                        <span class="year"> {{ date('Y', strtotime($content->updated_at)) }}</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="card-body-top">
                                        <h5 class="card-title mb-0"><a href="{!! URL::to('article/'.$content->slug) !!}" class="">{{$content->title}}</a></h5>
                                    <div class="article_badge_wrap mt-3 mb-1">
                                    @php
                                         $category = $content->blog_category_id;

                                         $displayCategoryName = '';
                                         foreach(explode(',', $category) as $catKey => $catVal) {

                                             $catDetails = DB::table('blog_categories')->where('id', $catVal)->first();
                                             if($catDetails!=''){
                                             $displayCategoryName .= '<a href="'.route("article.category", $catDetails->slug).'">'.$catDetails->title.'</a>  ';
                                         }
                                         }
                                         echo substr($displayCategoryName, 0, -2);
                                     @endphp
                                    </div>
                                    <p>
                                    {{-- {!! $content->description ?? '' !!} --}}
                                    </p>
                                    </div>
                                    <div class="card-body-bottom">
                                        <a href="{!! URL::to('article/'. $content->slug) !!}" class="readmore_btn">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endforeach
                    </div>
                    <div class="d-flex w-100 justify-content-center mt-4">
                    {{ $latestBlogs->appends($_GET)->links() }}
                   </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    @if(count($faq)>0)
<section class="pb-4 pb-lg-5 ">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="best_deal page-title">
                        <h2>{{ $cat[0]->title }} FAQs</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <ul class="faq-accordion">
                        <li class="first-set">  <!-- First Layer -->
                            <div class="inner show">

                                <div class="set">
                                    <ul>
                                        @foreach ($faq as $key => $item)
                                        <li class="second-set">   <!-- Second Layer -->
                                            <div class="toggle">
                                                <h5>
                                                    <i class="far fa-check-circle"></i>
                                                   {!! $item->question ?? '' !!}
                                                </h5>
                                                <i class="fas fa-plus plus-sign-icon plus-sign"></i>
                                            </div>
                                            <div class="inner">
                                                <p>
                                                    {!! $item->answer ?? ''!!}
                                                </p>
                                            </div>
                                        </li>
                                        @endforeach  <!-- Second Layer -->
                                    </ul>  <!-- Second Layer -->
                                </div>
                            </div>
                        </li>  <!-- First Layer -->
                    </ul>
                </div>
            </div>
        </div>
    </section>
    @endif
    <!-- ========== Category ========== -->
   {{-- <section class="pb-4 pb-lg-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-title best_deal">
                        <h2>Related Categories</h2>
                    </div>
                </div>
            </div>
            <div class="row m-0 rel-cat">
                <div class="swiper Bestdeals cafe-card">
                    <div class="swiper-wrapper">
                    @foreach($articlecat as  $key => $content)
                        <div class="swiper-slide">
                            <div class="card relatedCard border-0">

                                 @if ($content->image)
                            <img  src="{{URL::to('/').'/categories/'}}{{$content->image}}" style="height: 350px;object-fit: cover;">
                            @else
                            @php
                             $demoImage=DB::table('demo_images')->where('title', '=', 'category')->get();
                             $demo=$demoImage[0]->image;
                             //dd($demoImage);
                            @endphp
                             <img src="{{URL::to('/').'/Demo/'}}{{$demo}}"  style="height: 350px;object-fit: cover;">

                            @endif
                                <div class="relatedCardBody px-0">
                                    <h4><a href="{!! URL::to('article/category/' . $content->slug) !!}" class="location_btn">{{$content->title}}</a></h4>

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
    </section> --}}


    <!-- ========== Inner Banner ========== -->
@endsection
@push('scripts')
<script>
$(document).on("click", "#btnFilter", function() {
    $('#checkout-form').submit();
});

$(document).keypress(function(event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);  if(keycode == '13'){    $('#checkout-form').submit();
 }
});
$('#searchFilterSelect').change(function() {
    var ss = $(this).val();

});
</script>
@endpush
