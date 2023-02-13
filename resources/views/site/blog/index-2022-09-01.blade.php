@extends('site.app')
@section('title') {{ $pageTitle }} @endsection

@section('content')
    {{-- BLOG SEARCH --}}
    <section class="inner_banner" style="background: url(https://demo91.co.in/localtales-prelaunch/public/site/images/banner-image.jpg) no-repeat center center;
    background-size: cover;">
        <div class="container position-relative">
            <h1 class="mb-4">Resources</h1>
            <div class="page-search-block filterSearchBoxWraper">
            <form action="" id="checkout-form">
                <div class="filterSearchBox">
                    <div class="row">
                        <div class="col-5 col-lg-4 fcontrol position-relative filter_selectWrap filter_selectWrap2">
                            <div class="select-floating">
                                <img src="{{ asset('front/img/grid.svg')}}">
                                <label for="blogcategory">Primary Category</label>
                                <select class="filter_select blogcategory floating-select form-control" name="blog_category_id">
                                    <option value="" hidden selected>Select Primary Category...</option>
                                    @foreach ($categories as $index => $item)
                                        <option value="{{$item->id}}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-5 col-lg-4 fcontrol position-relative filter_selectWrap filter_selectWrap2">
                             <div class="select-floating">
                                <img src="{{ asset('front/img/grid.svg')}}">
                                <label for="blogpostcode">Secondary Category</label>
                                <select class="filter_select blogpostcode floating-select form-control" name="blog_sub_category_id">
                                    <option value="" hidden selected>Select Secondary Category</option>
                                    @foreach ($subcategories as $index => $item)
                                        <option value="{{$item->id}}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                            </div>
			</div>
			 <div class="col-5 col-lg-4 fcontrol position-relative filter_selectWrap filter_selectWrap2">
                             <div class="select-floating">
                                <img src="{{ asset('front/img/grid.svg')}}">
                                <label for="blogpostcode">Tertiary Category</label>
                                <select class="filter_select blogpostcode floating-select form-control" name="blog_tertiary_category_id">
                                    <option value="" hidden selected>Select Tertiary Category</option>
                                    @foreach ($tertiarycategories as $index => $item)
                                        <option value="{{$item->id}}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                            </div>
			</div>
                           {{-- <div class="form-floating">
                                <input id="postcodefloting" type="text" class="form-control" name="pincode" placeholder="Postcode/ State" value="{{ request()->input('pincode') }}" autocomplete="off">
                                <label for="postcodefloting">Postcode/ State</label>
                            </div>
                            <div class="respDrop"></div>
                        </div> --}}
                        <!--<div class="col-12 col-lg-3 plr-3 pl-lg-0 fcontrol position-relative filter_selectWrap filter_selectWrap2">-->
                        <!--    <img src="{{ asset('front/img/map-pin.svg')}}">-->
                        <!--    <select class="filter_select form-control" name="suburb_id">-->
                        <!--        <option value="" hidden selected>Search by Suburb</option>-->
                        <!--        @foreach ($suburb as $index => $item)-->
                        <!--            <option value="{{$item->id}}">{{ $item->name }}</option>-->
                        <!--        @endforeach-->
                        <!--    </select>-->
                        <!--</div>-->
                        <div class="col-5 col-sm">
                            <div class="form-floating">
                                <input id="searchbykeyword" type="search" name="title" class="form-control" placeholder="Search by keyword...">
                                <label for="searchbykeyword" placeholder="Nom">Search by keyword</label>
                            </div>
                        </div>
                        <div class="col-2 col-sm-auto">
                            <a href="javascript:void(0);" id="btnFilter" class="w-100 btn btn-blue text-center ml-auto"><img src="{{ asset('front/img/search.svg')}}"></a>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </section>

    {{-- BLOG SEARCH RESULT --}}
    <section class="pb-2 pb-sm-4 pb-lg-5 searchpadding">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col">
                    <div class="page-title best_deal">
                        <h2>Articles</h2>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="articleSliderBtn">
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
            </div>

            <div class="swiperSliderWraper">
                <div class="swiper Bestdeals">
                    <div class="swiper-wrapper">
                    @foreach($blogs as  $key => $blog)
                        <div class="swiper-slide">
                            <div class="card blogCart border-0">
                                <div class="bst_dimg">
                                    <!--<div class="cmg_div"></div>-->
                                     @if($blog->image)
                                    <img src="{{URL::to('/').'/Blogs/'}}{{$blog->image}}" class="card-img-top" alt="ltItem">
                                     @else
                                    <img src="{{asset('Directory/placeholder-image.png')}}" >
                                    @endif
                                    <div class="dateBox">
                                        <span class="date">{{$blog->created_at->format('d')}}</span>
                                        <span class="month">{{$blog->created_at->format('M')}}</span>
                                        <span class="year">{{$blog->created_at->format('Y')}}</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="card-body-top">
                                        <h5 class="card-title mb-0">
                                            <a href="{!! URL::to('article-details/'.strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $blog->title))) !!}" class="location_btn">{{$blog->title}}</a>
                                        </h5>
                                        <span class="tag_text">{{ $blog->category->title ?? ''}}</span>
                                    </div>
                                    <div class="card-body-bottom">

                                       <a href="{!! URL::to('article-details/'.strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $blog->title))) !!}" class="readMoreBtn">Read Article</a>
                                   </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CATEGORY WISE BLOGS --}}
    @foreach($categories as $blogCategorykey => $blog)
    @php
        if($blog->productDetails->count() == 0) { continue; }
    @endphp
    {{-- @if() {{ break; }} @endif --}}
    <section class="py-2 py-sm-4 py-lg-5 bg-light article_blogs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-title best_deal">
                        <h2>{{ $blog->title }}</h2>

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

            <div class="swiperSliderWraper swiperSliderWraper__two">
                <div class="swiper Bestdeals">
                    <div class="swiper-wrapper">
                    @foreach($blog->productDetails as $blogProductkey => $blogProductValue)
                        @if($blogProductValue->status == 0) @continue; @endif
                        <div class="swiper-slide">
                            <div class="card blogCart border-0">
                                <div class="bst_dimg">
                                    @if($blog->image)
                                      <img src="{{URL::to('/').'/Blogs/'}}{{$blogProductValue->image}}" class="card-img-top" alt="ltItem">
                                   
                                     @else
                                   <img src="{{asset('Directory/placeholder-image.png')}}" >
                                    @endif
                                    <div class="dateBox">
                                        <span class="date">{{$blogProductValue->created_at->format('d')}}</span>
                                        <span class="month">{{$blogProductValue->created_at->format('M')}}</span>
                                        <span class="year">{{$blogProductValue->created_at->format('Y')}}</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="card-body-top">
                                        <h5 class="card-title">{{ $blogProductValue->title }}</h5>
                                         <p>{{ $blogProductValue->category->title ?? ''}}</p>
                                    </div>
                                    <div class="card-body-bottom">

                                        <span class="tag_text">{{ $blogProductValue->tag }}</span>
                                        {{-- <a href="#">Read More...</a> --}}
                                        <a href="{!! URL::to('article-details/'.strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $blogProductValue->title))) !!}" class="readMoreBtn">Read More <!--<img src="{{asset('site/images/right-arrow.png')}}">--></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
                <!--<div class="swiper-button-next"></div>-->
                <!--<div class="swiper-button-prev"></div>-->
            </div>
        </div>
    </section>
    @endforeach
    <section class="py-4 py-lg-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-title best_deal">
                        <h2>Related Categories</h2>
                    </div>
                </div>
                <div class="col-auto">
                    <a href="{{ route('category-home') }}" class="viewAllBtn">VIEW ALL</a>
                </div>
            </div>
            <div class="row m-0 rel-cat">
                <div class="swiper Bestdeals cafe-card">
                    <div class="swiper-wrapper">
                    @foreach($categories as  $key => $content)
                        <div class="swiper-slide">
                            <div class="card relatedCard border-0">
                                @if($content->image)
                                <img  src="{{URL::to('/').'/categories/'}}{{$content->image}}">
                                @else
                                 <img class="w-100" src="{{asset('Directory/placeholder-image.png')}}" >
                                 @endif
                                 <div class="card-body">
                                    <div class="card-body-top">
                                        <h5><a href="{!! URL::to('category/'.$content->slug) !!}" >{{ $content->title }}</a></h5>
                                    </div>
                                    <div class="card-body-bottom">
                                        {{-- <a href="#">Read More...</a> --}}
                                    </div>
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
    </section>
@endsection

@push('scripts')
    <script type="text/javascript">
    	@php
    	$locations = array();
    	foreach($blogs as $deal){
    		$data = array($deal->title,floatval($deal->lat),floatval($deal->lon));
    		array_push($locations,$data);
    	}
    	@endphp

        // $(document).ready(function(){
        // 	$('#btnFilter').on("click",function(){
        // 		$('#checskout-form').submit();
        // 	})
        // });

        $(document).on("click", "#btnFilter", function() {
            $('#checkout-form').submit();
        });
    </script>

    <script>
        // state, suburb, postcode data fetch
        $('input[name="pincode"]').on('keyup', function() {
            var $this = 'input[name="pincode"]'

            if ($($this).val().length > 0) {
                $.ajax({
                    url: '{{ route('user.postcode') }}',
                    method: 'post',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        code: $($this).val(),
                    },
                    success: function(result) {
                        var content = '';
                        if (result.error === false) {
                            content += `<div class="dropdown-menu show w-100 postcode-dropdown" aria-labelledby="dropdownMenuButton">`;

                            $.each(result.data, (key, value) => {
                                content += `<a class="dropdown-item" href="javascript: void(0)" onclick="fetchCode(${value.pin})">${value.state}, ${value.suburb}, ${value.pin}</a>`;
                            })
                            content += `</div>`;
                            // $($this).parent().after(content);
                        } else {
                            content += `<div class="dropdown-menu show w-100 postcode-dropdown" aria-labelledby="dropdownMenuButton"><li class="dropdown-item">${result.message}</li></div>`;
                        }
                        $('.respDrop').html(content);
                    }
                });
            } else {
                $('.respDrop').text('');
            }
        });

        function fetchCode(code) {
            $('.postcode-dropdown').hide()
            $('input[name="pincode"]').val(code)
        }
    </script>
@endpush

