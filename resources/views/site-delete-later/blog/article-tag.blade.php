@extends('site.app')
@section('title') {{ $pageTitle }} @endsection

@section('content')
    <style>
        .select2-container--default {
            width: 100%;
        }
    </style>

    <section class="inner_banner" style="background: url(https://demo91.co.in/localtales-prelaunch/public/site/images/banner-image.jpg) no-repeat center center;
    background-size: cover;">
        <div class="container position-relative">
	    <h1>{{ $articleTag[0]->tag ??''}} </h1>
            <h4>Resources</h4>
            <div class="page-search-block filterSearchBoxWraper">
                <form action="" id="checkout-form">
                    <div class="filterSearchBox">
                        <div class="row">
                            <div class="col-5 col-sm">
                                <div class="form-floating">
                                    <input id="searchbykeyword" type="search" name="keyword" class="form-control" value="{{ request()->input('keyword') }}" placeholder="Search by keyword...">
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

    <section class="pb-2 pb-sm-4 pb-lg-5 searchpadding">
        <div class="container">
            <div class="">

                @if (!empty(request()->input('keyword')))
                    @if ($blogs->count() > 0)
                       <h3 class="mb-2 mb-sm-3">Results found for "{{ request()->input('keyword') }}"
                          </h3>
                   @else
                       <h3 class="mb-2 mb-sm-3">No Results found for
                          "{{ request()->input('keyword')}}" </h3>

                       <p class="mb-2 mb-sm-3 text-muted">Please try again with different keyword</p>
                   @endif



               @endif
           </div>
            <!--<div class="row justify-content-between">
                <div class="col">
                    <div class="page-title best_deal">
                        <h2></h2>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="articleSliderBtn">
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
            </div>-->

            <div class="swiperSliderWraper">
                <div class="Bestdeals articleTag">
                    <div class="row">
                        @if(count($blogs)>0)
                    @foreach($blogs as  $key => $blog)
                    @php
                        if($blog->image =='') { continue; }
                    @endphp
                        <div class="col-lg-3 col-xl-3 col-md-4 col-sm-6 col-6 jQueryEqualHeight">
                            <div class="card blogCart articleCard border-0">
                                <div class="bst_dimg">
                                    <!--<div class="cmg_div"></div>-->
                                     @if($blog->image)
                                    <a href="{!! URL::to('article/'. $blog->slug) !!}" class="location_btn w-100"><img src="{{URL::to('/').'/Blogs/'}}{{$blog->image}}" class="card-img-top" alt="ltItem"></a>
                                     @else
                                    <a href="{!! URL::to('article/'. $blog->slug) !!}" class="location_btn w-100"><img src="{{asset('Directory/placeholder-image.png')}}" ></a>
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
                                            <a href="{!! URL::to('article/'. $blog->slug) !!}" class="location_btn">{{$blog->title}}</a>
                                        </h5>

                                        <div class="article_badge_wrap mt-3 mb-1">
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
                                   </div>
                                    </div>
                                    <div class="card-body-bottom">
					                   <!--<span class="tag_text">{{ $blog->tag }}</span>-->
                                       <a href="{!! URL::to('article/'.$blog->slug) !!}" class="readMoreBtn">Read Article</a>
                                   </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>



@endsection

@push('scripts')
    <script type="text/javascript">


        $(document).on("click", "#btnFilter", function() {
            $('#checkout-form').submit();
        });


		$('select[name="blog_category_id"]').on('change', (event) => {
			var value = $('select[name="blog_category_id"]').val();

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

        $('select[name="blog_sub_category_id"]').on('change', (event) => {
			var value = $('select[name="blog_sub_category_id"]').val();

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
            $('#select_holder2').show();
            alert($('#cat_level1').val());
        });
        $(document).on('change', '#cat_level2', () => {
            $('#select_holder2').show();
            alert($('#cat_level2').val());
        });
    </script>
@endpush

