@extends('site.app')
@section('title') {{ $pageTitle }} @endsection

@section('content')
    <style>
       .select2-container--default {
         width: 100% !important;
        }
    </style>

    <section class="inner_banner" style="background: url(https://demo91.co.in/localtales-prelaunch/public/site/images/banner-image.jpg) no-repeat center center;
    background-size: cover;">
        <div class="container position-relative">
            <h1 class="mb-4">Resources</h1>
            <div class="page-search-block filterSearchBoxWraper">

                <form action="" id="checkout-form">

                    <div class="filterSearchBox">

                        <div class="row">

                            <div class="col-5 col-sm fcontrol position-relative">

                                <div class="dropdown">

                                    <div class="form-floating drop-togg" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                        <input id="postcodefloting" type="text" class="form-control pl-3" name="key_details" placeholder="Postcode/ State" value="{{ request()->input('key_details') }}" autocomplete="off">

                                         <input type="hidden" name="type" value="{{ request()->input('type') }}">
                                        <input type="hidden" name="code" value="{{ request()->input('code') }}">
                                        <label for="postcodefloting">Category</label>

                                    </div>

                                    <div class="respDrop"></div>

                                </div>

                            </div>
                            <div class="col-5 col-sm">
                                <div class="form-floating">
                                    <input id="searchbykeyword" type="search" name="title" class="form-control" placeholder="Search by keyword..." value="{{request()->input('title')}}">
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

    {{-- Search article --}}
    @if(request()->input('code') || request()->input('title'))
      <section class="pb-4 pb-sm-4 pb-lg-5 searchpadding">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col">
                    <div class="page-title best_deal">
                        <h2>
                        @if (request()->input('key_details') || request()->input('title'))
                            @if ($blogs->count() > 0)
                                Result found for {{ request()->input('key_details') ? '"'.request()->input('key_details').'"' : '' }} {{ request()->input('title') ? ( !empty(request()->input('key_details')) ? ' and "'.request()->input('title').'"' : '"'.request()->input('title').'"' ) : '' }}
                            @else
                                No Result found for {{ request()->input('key_details') ? '"'.request()->input('key_details').'"' : '' }} {{ request()->input('title') ? ( !empty(request()->input('key_details')) ? ' and "'.request()->input('title').'"' : '"'.request()->input('title').'"' ) : '' }}
                            @endif
                        @endif
                        </h2>
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
                    @foreach($blogs as $blogCategorykey => $blog)
                    @php
                        if($blog->image =='') { continue; }
                    @endphp
                    {{-- {{ dd($blog) }} --}}
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
                                                    <span class="date">
                                                        {{ date('d', strtotime($blog->created_at)) }}
                                                    </span>
                                                    <span class="month">
                                                        {{ date('M', strtotime($blog->created_at)) }}
                                                    </span>
                                                    <span class="year">
                                                        {{ date('Y', strtotime($blog->created_at)) }}
                                                    </span>
                                        </div>
                                     </div>
                                <div class="card-body">
                                    <div class="card-body-top">
                                        <h5 class="card-title mb-0">
                                            <a href="{!! URL::to('article/'.$blog->slug) !!}" class="location_btn">{{$blog->title}}</a>
                                        </h5>
                                          @if($blog->blog_category_id)
                                        <div class="article_badge_wrap mt-3 mb-1">

                                            <a href="">
                                            @php
                                                $cat = $blog->blog_category_id;
                                                $displayCategoryName = '';
                                                foreach(explode(',', $cat) as $catKey => $catVal) {
                                                    $catDetails = DB::table('blog_categories')->where('id', $catVal)->first();
                                                     if($catDetails !=''){
                                                    $displayCategoryName .= '<a href="'.route("article.category", $catDetails->slug).'">'.'<span class="badge p-1" style="font-size: 10px;">'.$catDetails->title.'</span>'.'</a>  ';
                                                    }
                                                }
                                                echo $displayCategoryName;
                                            @endphp

                                            </a>

                                        </div>
                                        @endif
                                    </div>
                                    <div class="card-body-bottom">
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
    </section>
    @endif
    {{-- Featured Articles --}}
    <section class="pb-2 pb-sm-4 pb-lg-5 searchpadding">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col">
                    <div class="page-title best_deal">
                        <h2>Featured Articles</h2>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="articleSliderBtn">
                        <div class="featuredArticles-button-prev swiperBtn-prev"><i class="fas fa-angle-left"></i></div>
                        <div class="featuredArticles-button-next swiperBtn-next"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="swiperSliderWraper">
                <div class="swiper Bestdeals featuredArticles">
                    <div class="swiper-wrapper">
                    @foreach($latestblogs as  $key => $blog)
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
                                        <span class="date">{{$blog->created_at->format('d')}}</span>
                                        <span class="month">{{$blog->created_at->format('M')}}</span>
                                        <span class="year">{{$blog->created_at->format('Y')}}</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                  <div class="card-body-top">
                                        <h5 class="card-title mb-0">
                                            <a href="{!! URL::to('article/'. $blog->slug) !!}" class="location_btn">{{$blog->title}}</a>

                                        </h5>

                                        @if($blog->blog_category_id)



                                        <div class="article_badge_wrap mt-3 mb-1">





                                            @php



                                                $cat = $blog->blog_category_id ?? '';



                                                $displayCategoryName = '';



                                                foreach(explode(',', $cat) as $catKey => $catVal) {



                                                    $catDetails = DB::table('blog_categories')->where('id', $catVal)->first();

                                                      if($catDetails == ''){

 $displayCategoryName .= '';

                                                      } else{

                                                    $displayCategoryName .= '<a href="'.route("article.category", $catDetails->slug).'">'.'<span class="badge p-1" style="font-size: 10px;">'.$catDetails->title.'</span>'.'</a>  ';

                                                 }

                                                }



                                                echo $displayCategoryName;



                                            @endphp



                                        </div>



                                        @endif



                                    </div>



                                    <div class="card-body-bottom">



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



    </section>







    {{-- CATEGORIES --}}



    @foreach($categories as $categoryKey => $categoryValue)

        @php
            // BOLGS UNDER CATEGORIES

            $blogsUnderCategory = \DB::table('blogs')->where('blog_category_id', 'like', '%'.$categoryValue->id.'%')->where('status', 1)->where('image','!=','')->orderby('id','desc')->limit(8)->get();

        @endphp
        {{-- SHOW THE CATEGORIES WHICH HAVE BLOGS IN THEM --}}
        @if ($blogsUnderCategory->count() > 0)

        <section class="pb-4 py-sm-4 pb-lg-5 bg-light article_blogs">
            <div class="container">
                <div class="row align-items-center mb-3">
                    <div class="col">
                        <div class="page-title best_deal">
                            <h2 class="mb-0">{{ $categoryValue->title }}</h2>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="articleSliderBtn">
                            <div class="categorySlide-button-prev-{{$categoryKey}} swiperBtn-prev"><i class="fas fa-angle-left"></i></div>
                            <div class="categorySlide-button-next-{{$categoryKey}} swiperBtn-next"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

                <div class="swiperSliderWraper swiperSliderWraper__two">
                    <div class="swiper Bestdeals categorySlide-{{$categoryKey}} test">
                        <div class="swiper-wrapper">
                        @foreach($blogsUnderCategory as $blogKey => $blogValue)
                            <div class="swiper-slide jQueryEqualHeight">
                                <div class="card blogCart border-0">
                                    <div class="bst_dimg">
                                        @if($blogValue->image)
                                            <a href="{!! URL::to('article/'.$blogValue->slug) !!}" class="location_btn w-100"><img src="{{URL::to('/').'/Blogs/'}}{{$blogValue->image}}" class="card-img-top" alt="ltItem"></a>
                                        @else
                                            @php

                                            $demoImage=DB::table('demo_images')->where('title', '=', 'article')->get();

                                            $demo=$demoImage[0]->image;



                                            @endphp



                                            <a href="{!! URL::to('article/'.$blogValue->slug) !!}" class="location_btn w-100"><img src="{{URL::to('/').'/Demo/'}}{{$demo}}" class="card-img-top"></a>



                                        @endif



                                        <div class="dateBox">



                                            <span class="date">



                                                {{ date('d', strtotime($blogValue->created_at)) }}



                                            </span>



                                            <span class="month">



                                                {{ date('M', strtotime($blogValue->created_at)) }}



                                            </span>



                                            <span class="year">



                                                {{ date('Y', strtotime($blogValue->created_at)) }}



                                            </span>



                                            {{-- <span class="date">{{$blogValue->created_at->format('d')}}</span>



                                            <span class="month">{{$blogValue->created_at->format('M')}}</span>



                                            <span class="year">{{$blogValue->created_at->format('Y')}}</span> --}}



                                        </div>



                                    </div>



                                    <div class="card-body">



                                        <div class="card-body-top">



                                            <h5 class="card-title"><a href="{!! URL::to('article/'.$blogValue->slug) !!}" class="location_btn">{{ $blogValue->title }}</a></h5>







                                            @if($blogValue->blog_category_id)



                                            <div class="article_badge_wrap mt-3 mb-1">
                                              @if(is_array($blogValue->blog_category_id) && count($blogValue->blog_category_id)>0)
                                                <a href="{!! URL::to('article/category/'.$blog->category->slug) !!}">
                                               @endif
                                                @php



                                                    $cat = $blogValue->blog_category_id;







                                                    $displayCategoryName = '';



                                                    foreach(explode(',', $cat) as $catKey => $catVal) {



                                                        $catDetails = DB::table('blog_categories')->where('id', $catVal)->first();
if($catDetails == ''){

 $displayCategoryName .= '';

                                                      } else{






                                                        $displayCategoryName .= '<a href="'.route("article.category", $catDetails->slug).'">'.'<span class="badge p-1" style="font-size: 10px;">'.$catDetails->title.'</span>'.'</a>  ';


}
                                                    }



                                                    echo $displayCategoryName;



                                                @endphp

                                                </a>

                                            </div>



                                            @endif







                                        </div>



                                        <div class="card-body-bottom">



                                            <!--<span class="tag_text">{{ $blogValue->tag }}</span>-->



                                            <a href="{!! URL::to('article/'. $blogValue->slug) !!}" class="readMoreBtn">Read More</a>



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



        @endif


    @endforeach

@endsection

@push('scripts')

    <script type="text/javascript">
        // category swiper slider js
        @foreach($categories as $categoryKey => $categoryValue)
        var swiper = new Swiper(".categorySlide-{{$categoryKey}}", {
            navigation: {
                nextEl: ".categorySlide-button-next-{{$categoryKey}}",
                prevEl: ".categorySlide-button-prev-{{$categoryKey}}",
            },
            breakpoints: {
                320: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 15,
                },
                1366: {
                    slidesPerView: 4,
                    spaceBetween: 15,
                },
            },
        });
        @endforeach

        $(document).on("click", "#btnFilter", function() {
            $('#checkout-form').submit();
        });

        $(document).keypress(function(event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);  if(keycode == '13'){    $('#checkout-form').submit();
         }
        });

        $('select[name="pincode"]').on('change', (event) => {
			var value = $('select[name="pincode"]').val();

			$.ajax({
            	url: '{{url("/")}}/api/postcode-suburb/'+value,

                method: 'GET',

                success: function(result) {

					var content = '';

					var slectTag = 'select[name="suburb_id"]';

					var displayCollection = (result.data.postcode == "all") ? "All postcode" : " Select";
					content += '<option value="" selected>'+displayCollection+'</option>';
					$.each(result.data.suburb, (key, value) => {
						content += '<option value="'+value.suburb_id+'">'+value.suburb_title+'</option>';
					});
					$(slectTag).html(content).attr('disabled', false);
                }
			});
		});

        $(document).on('change', '#cat_level1', () => {
           var value = $('#cat_level1').val();
            $.ajax({
				url: '{{url("/")}}/api/subcategory/'+value,

                method: 'GET',

                success: function(result) {

					var content = '';

					var slectTag = 'select[name="blog_sub_category_id"]';

					var displayCollection = (result.data.cat_name == "all") ? "All Subcategory" : " Select ";


					content += '<option value="" selected>'+displayCollection+'</option>';



					$.each(result.data.subcategory, (key, value) => {



						content += '<option value="'+value.subcategory_id+'">'+value.subcategory_title+'</option>';



					});



					$(slectTag).html(content).attr('disabled', false);



                }



			});



        });







        $(document).on('change', '#cat_level2', () => {



            var value = $('#cat_level2').val();







			$.ajax({



				url: '{{url("/")}}/api/tertiarycategory/'+value,



                method: 'GET',



                success: function(result) {



                    var content = '';



                    var slectTag = 'select[name="blog_tertiary_category_id"]';



                    var displayCollection = (result.data.cat_name == "all") ? "All Subcategory" : " Select";







                    content += '<option value="" selected>'+displayCollection+'</option>';



                    $.each(result.data.tertiarycategory, (key, value) => {



                        content += '<option value="'+value.tertiarycategory_id+'">'+value.tertiarycategory_title+'</option>';



                    });



                    $(slectTag).html(content).attr('disabled', false);



                }



			});



        });















        // state, suburb, postcode data fetch



       /* $('input[name="key_details"]').on('keyup', function() {

            var $this = 'input[name="key_details"]'

            if ($($this).val().length > 0) {

                $('input[name="keyword"]').val($($this).val())

                $.ajax({

                    url: '{{ route('user.category') }}',

                    method: 'post',

                    data: {

                        '_token': '{{ csrf_token() }}',

                        code: $($this).val(),

                    },

                    success: function(result) {

                        var content = '';



                        if (result.error === false) {

                            // content += `<div class="dropdown-menu show w-100 postcode-dropdown" aria-labelledby="dropdownMenuButton">`;

                            content += `<div class="dropdown-menu show">`;



                            $.each(result.data, (key, value) => {

                                if (value.cat1.length > 0 || value.cat2.length > 0 || value.cat3.length > 0) {

                                    if (value.cat1.length > 0) {

                                        content += `<h6 class="dropdown-header">Primary</h6>`;



                                        $.each(value.cat1, (key1, value1) => {

                                            content += `<a class="dropdown-item" href="javascript: void(0)" onclick="fetchCode(${value1.id}, '${value1.title}', '${value1.type}')"><strong>${value1.title}</strong></a>`;

                                        })

                                    }



                                    if (value.cat2.length > 0) {

                                        content += `<h6 class="dropdown-header">Secondary</h6>`;



                                        $.each(value.cat2, (key2, value2) => {

                                            content += `<a class="dropdown-item" href="javascript: void(0)" onclick="fetchCode(${value2.id}, '${value2.title}', '${value2.type}')"><strong>${value2.title}</strong></a>`;

                                        })

                                    }



                                    if (value.cat3.length > 0) {

                                        content += `<h6 class="dropdown-header">Tertiary</h6>`;



                                        $.each(value.cat3, (key3, value3) => {

                                            content += `<a class="dropdown-item" href="javascript: void(0)" onclick="fetchCode(${value3.id}, '${value3.title}', '${value3.type}')"><strong>${value3.title}</strong></a>`;

                                        })

                                    }

                                }

                            });

                            content += `</div>`;

                        } else {

                            content += `<div class="dropdown-menu show"><a href="javascript: void(0)" class="dropdown-item">${result.message}</a></div>`;

                        }



                        $('.respDrop').html(content);

                    }

                });

            } else {

                $('.respDrop').text('');

            }

        });



        function fetchCode(keyword, details, type) {

            // $('.respDrop > dropdown-menu').hide()

            // $('.respDrop > dropdown-menu').dropdown('hide')

            $('.respDrop').text('')

            $('input[name="keyword"]').val(keyword)
            $('input[name="type"]').val(type)
            $('input[name="key_details"]').val(details)

        }*/

        $('body').on('click', function() {
            //code
            $('.postcode-dropdown').hide();
        });

        $('input[name="key_details"]').on('click', function(e) {
            e.stopPropagation()
            var content = '';
            @php
                $primaryCat = \DB::table('blog_categories')->where('status', 1)->orderby('title')->get();
                $primarySubCat = \DB::table('sub_categories')->where('status', 1)->orderby('title')->get();
                $tertiaryCat = \DB::table('sub_category_levels')->where('status', 1)->orderby('title')->get();

            @endphp

            content += `<div class="dropdown-menu show articleOnclickDrop postcode-dropdown">`;
            content += `<div class="articleCol_search">`;
            @foreach($primaryCat as $category)
                content += `<a class="dropdown-item" href="javascript: void(0)" onclick="fetchCode('{{$category->title}}', 'primary',{{$category->id}})">{{$category->title}}</a>`;
            @endforeach
            content += `</div>`;
            content += `<div class="articleCol_search">`;
            @foreach($primarySubCat as $category)
                content += `<a class="dropdown-item" href="javascript: void(0)" onclick="fetchCode('{{$category->title}}', 'secondary',{{$category->id}})">{{$category->title}}</a>`;
            @endforeach
            content += `</div>`;
            content += `<div class="articleCol_search">`;
            @foreach($tertiaryCat as $category)
                content += `<a class="dropdown-item" href="javascript: void(0)" onclick="fetchCode('{{$category->title}}', 'tertiary',{{$category->id}})">{{$category->title}}</a>`;
            @endforeach
            content += `</div>`;


            content += `</div>`;
            $('.respDrop').html(content);
        });

  $('input[name="key_details"]').on('keyup', function() {
            var $this = 'input[name="key_details"]'

            if ($($this).val().length > 0) {
                $.ajax({
                    url: '{{ route('user.category') }}',
                    method: 'post',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        data: $($this).val(),
                    },
                    success: function(result) {
                        var content = '';
                        if (result.error === false) {
                            content += `<div class="dropdown-menu show w-100 postcode-dropdown">`;

                            $.each(result.data, (key, value) => {
                                //var type1 = var type2 = '';
                                // if(value.type == 'secondary') type = 'Secondary'

                                if (value.type == 'primary') {
                                    type1 = 'primary';
                                    type2 = 'secondary';
                                } else if(value.type == 'secondary') {
                                    type1 = 'secondary';
                                    type2 = 'tertiary';
                                }
                                else{
                                    type1 = 'tertiary';
                                    type2 = 'tertiary';
                                }

                                content += `<a class="dropdown-item" href="javascript: void(0)" onclick="fetchCode('${value.title}', '${type1}',${value.id})">${value.title}</a>`;

                                if (value.child.length > 0) {
                                    // content += `<h6 class="dropdown-header">Secondary</h6>`;
                                    $.each(value.child, (key1, value1) => {
                                        content += `<a class="dropdown-item ml-4" href="javascript: void(0)" onclick="fetchCode('${value1.title}', '${type2}',${value1.id})">${value1.title}</a>`;
                                    })
                                }
                            })

                            content += `</div>`;

                        } else {
                            content +=
                                `<div class="dropdown-menu show w-100 postcode-dropdown" aria-labelledby="dropdownMenuButton"><li class="dropdown-item">${result.message}</li></div>`;
                        }
                        $('.respDrop').html(content);
                    }
                });
            } else {
                $('.respDrop').text('');
            }
        });

        function fetchCode(item,type,code) {
            $('.postcode-dropdown').hide()
            $('input[name="key_details"]').val(item)
            $('input[name="type"]').val(type)
            $('input[name="code"]').val(code)
        }
    </script>



@endpush
