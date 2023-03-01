@extends('site.app')

@php
    if (!empty($data->description)) {
        $meta_desc = explode(".", $data->description);
        $description = $meta_desc[0]. "." .$meta_desc[1]. ".";
    } else {
        $description = '';
    }

    $title = str_replace('POSTCODE', $data->pin, seoManagement('postcode_detail')->title);
@endphp

@section('title'){{$title}}@endsection
@section('description'){{$description}}@endsection
<style>
    div.desc {
        margin-bottom: 15px;
    }
    .job-desc{
        height: 300px;
        overflow: hidden;
    }
</style>

@section('content')
    @php
    $businesses = [];

    foreach ($directories as $business) {
        $directoryLattitude = $business->lat;
        $directoryLongitude = $business->lon;
        $address = $business->address;

        if ($directoryLattitude == null || $directoryLongitude == null ) {
            $url = 'https://maps.google.com/maps/api/geocode/json?address=' . urlencode($address) . '&key=';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $responseJson = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($responseJson);

            if (count($response->results)>0) {
                $latitude = $response->results[0]->geometry->location->lat ?? '';
                $longitude = $response->results[0]->geometry->location->lng ?? '';

                $business->latitude = $latitude;
                $business->longitude = $longitude;

                // insert lat & lon into directories
                \DB::table('directories')->where('id', $business->id)->update([
                    'lat' => $latitude,
                    'lon' => $longitude
                ]);
            }
        } else {
            $business->latitude = $directoryLattitude;
            $business->longitude = $directoryLongitude;
        }

        array_push($businesses, $business);
    }
    @endphp

    @php
        $postcode_img = \App\Models\Suburb::select('image')->where('pin_code', $data->pin)->orderBy('population', 'desc')->first();
        $demoImage=DB::table('demo_images')->where('title', '=', 'postcode')->get();
        $demo=$demoImage[0]->image;
    @endphp

    <section class="inner_banner"
        @if($postcode_img->image)
            style="background: url({{asset('/admin/uploads/suburb/'.$postcode_img->image)}})"
        @else
            @if($data->image)
                style="background: url({{asset('/admin/uploads/pincode/images/'.$data->image)}})"
            @else
            @if($demo)
                   style="background: url({{URL::to('/').'/Demo/' .$demo}})"
            @else
            style="background: url({{asset('Directory/placeholder-image.png')}})"
            @endif
            @endif
        @endif
        >
        <div class="container position-relative d-flex justify-content-between">
            <div class="left-part">
                <h1 id="postcode">{{ $data ? $data->pin : '' }}</h1>
                <h4>{{ $data->state_name ? $data->state_name : '' }}</h4>
            </div>
            <div class="right-part">
                <div class="weather short-width">
                    <div id="openWeather-short"></div>
                </div>
            </div>
            <div class="page-search-block filterSearchBoxWraper">
                <form action="" id="checkout-form">
                    <div class="filterSearchBox">
                        <div class="row">
                            <div class="col-5 col-md fcontrol position-relative filter_selectWrap">
                                <div class="dropdown">
                                    <div class="form-floating drop-togg" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <input id="postcodefloting" type="text" class="form-control pl-3" name="directory_category" placeholder="Category" value="{{ request()->input('directory_category') }}" autocomplete="off">
                                        <input type="hidden" name="code" value="{{ request()->input('code') }}">
                                        <input type="hidden" name="type" value="{{ request()->input('type') }}">
                                        <label for="postcodefloting">Category</label>
                                    </div>
                                    <div class="respDrop"></div>
                                </div>
                            </div>
                            <div class="col-5 col-md fcontrol position-relative">
                                <div class="form-floating">
                                    <input type="search" name="keyword" class="form-control"
                                        placeholder="Search by keyword..." value="{{ request()->input('keyword') }}">
                                    <label for="searchbykeyword" placeholder="Nom">Search by keyword</label>
                                </div>
                            </div>
                            <input type="hidden" name="address" class="form-control" placeholder="Search by keyword..." value="{{ $data->pin}}">
                            <div class="col-2 col-sm-auto">
                                <a href="javascript:void(0);" id="btnFilter" class="w-100 btn btn-blue filterBtnOrange text-center ml-auto">
                                    <img src="{{ asset('front/img/search.svg') }}">
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section class="pb-4 pb-lg-5 our-process pt-5 mt-3">
        <div class="container">
        <ul class="breadcumb_list mb-4 pb-2">
            <li><a href="{!! URL::to('/') !!}">Home</a></li>
            <li>/</li>
            <li><a href="{{ route('postcode-index') }}">Postcode</a></li>
            <li>/</li>
            <li class="active">{{ $data ? $data->pin : '' }}</li>
        </ul>
       </div>
    </section>
    <section class="map_section pt-1">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <p>{{ $data ? $data->description : '' }}</p>
                </div>

                @if(count($directories) > 0)
                <div class="col-12">
                    <div class="map map-margintop">
                        <div id="mapShow" style="height: 600px;"></div>
                        <input type="hidden" id="googlemapaddress" value="{{ $data ? $data->pin : '' }}">
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>


    <section class="py-2 py-sm-4 py-lg-5 bg-light smallGapGrid">
        <div class="container">
			<div class="">
				@if (!empty(request()->input('code'))|| !empty(request()->input('keyword')))
				    @if ($directories->count() > 0)
                        <h3 class="mb-2 mb-sm-3">Directory with {{ request()->input('directory_category') ? '"'.request()->input('directory_category').'"' : '' }} {{ request()->input('keyword') ? ( !empty(request()->input('directory_category')) ? ' and "'.request()->input('keyword').'"' : '"'.request()->input('keyword').'"' ) : '' }}</h3>
				    @else
                        <h3 class="mb-2 mb-sm-3">No directory found with {{ request()->input('directory_category') ? '"'.request()->input('directory_category').'"' : '' }} {{ request()->input('keyword') ? ( !empty(request()->input('directory_category')) ? ' and "'.request()->input('keyword').'"' : '"'.request()->input('keyword').'"' ) : '' }}</h3>

				        <p class="mb-2 mb-sm-3 text-muted">Please try again with different Category or Keyword</p>
				    @endif
				@else
                    @if (count($directories) > 0)
				        <h3 class="mb-2 mb-sm-3">Directory</h3>
                    @else
				        <h3 class="mb-2 mb-sm-3">No directories found</h3>
                    @endif
				@endif
            </div>

            <div id="tab-contents">
                <div class="tab-content smallGapGrid" id="grid">
                    <div class="row Bestdeals">
                    @foreach($directories as $key => $business)
                        <div class="col-6 col-md-4 col-lg-4 mb-3 mb-lg-4">
                            <div class="card directoryCard border-0 v3card">
                                <div class="card-body">
                                    <h5 class="card-title"><a href="{{ URL::to('directory/'.$business->slug) }}" class="location_btn">{{ $business->name }}</a></h5>

                                    {!! directoryRatingHtml($business->rating) !!}

                                    <p><i class="fas fa-map-marker-alt"></i> {!! $business->address !!}</p>
                                    <input type="hidden" id="googlemapaddress" value="">
                                    <div class="directory_block">
                                        <div>
                                            @php
                                                $only_numbers = (int)filter_var($business->mobile, FILTER_SANITIZE_NUMBER_INT);
                                                if(strlen((string)$only_numbers) == 9)
                                                {
                                                    $only_number_to_array = str_split((string)$only_numbers);
                                                    $mobile_number = '(0'.$only_number_to_array[0].') '.$only_number_to_array[1].$only_number_to_array[2].$only_number_to_array[3].$only_number_to_array[4].$only_number_to_array[5].$only_number_to_array[6].$only_number_to_array[7].$only_number_to_array[8];
                                                }elseif(strlen((string)$only_numbers) == 10){
                                                    $only_number_to_array = str_split((string)$only_numbers);
                                                    $mobile_number = '('.$only_number_to_array[0].$only_number_to_array[1].$only_number_to_array[2].$only_number_to_array[3].') '.$only_number_to_array[4].$only_number_to_array[5].$only_number_to_array[6].$only_number_to_array[7].$only_number_to_array[8].$only_number_to_array[9];
                                                }
                                                else
                                                    $mobile_number = $business->mobile;
                                            @endphp
                                            <a href="tel:{{$mobile_number}}" class="g_l_icon"><i class="fas fa-phone-alt"></i>{{$mobile_number}}</a>
                                        </div>
                                        <div class="categoryB-list v3_flag">
                                            {!! directoryCategory($business->category_id) !!}
                                        </div>
                                    </div>
                                    <div class="v3readmore">
                                        <a href="{{ URL::to('directory/'.$business->slug) }}"><i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $directories->appends($_GET)->links() }}
                </div>
            </div>
        </div>
    </section>

    @if (count($reviews)>0)
    <section class="py-2 py-sm-4 py-lg-5 similar_postcode more-collection">
        <div class="container">
            <div class="row mb-0 mb-sm-4 justify-content-center">
                <div class="page_title text-center">
                    <h2 class="mb-2"><a href="{{route('review')}}" class="location_btn">Recent Reviews</a></h2>
                </div>
            </div>
            <div class="row">
            @foreach ($reviews as $key => $data)
            {{-- {{dd($data)}} --}}
            <div class="col-6 col-md-3 mb-2 mb-sm-4 mb-lg-3">
                <div class="card directory-single-review">
                    <div class="card-body">
                        <h5>{{ $data->author_name }}</h5>
                        <p>{{ $data->name }}</p>

                        <div class="rating">
                            @php
                                $rating = number_format($data->rating,1);
                                for ($i = 1; $i < 6; $i++) {
                                    if ($rating >= $i) {
                                        echo '<i class="fas fa-star"></i>';
                                    } elseif (($rating < $i) && ($rating > $i-1)) {
                                        echo '<i class="fas fa-star-half-alt"></i>';
                                    } else {
                                        echo '<i class="far fa-star"></i>';
                                    }
                                }
                            @endphp
                        </div>
                        @if(!empty($data->time))
                        <p>{{date('d/m/Y', $data->time) }}</p>
                        @else
                        <p>{{date('d/m/Y', strtotime($data->created_at)) }}</p>
                        @endif
                        <div class="desc">
                            @if(strlen($data->text) > 200)
                                <p>{{ substr($data->text,0,200) }} <small class="text text-primary showMore" style="cursor: pointer">...Read more</small></p>

                                <p style="display: none">{{$data->text}}<small class="text text-primary showLess" style="cursor: pointer">Read less</small></p>
                            @else
                                <p>{{$data->text}}</p>
                            @endif
                        </div>

                            {{-- review like/ dislike --}}
                            @if(Auth::guard('user')->check())
                                <a href="javascript:void(0)" class="location_btn ms-auto"
                                onclick="reviewLike({{ $data->id }})"
                                title="Like">

                                @php
                                    if(Auth::guard('user')->check()){
                                        $reviewExistsCheck = \App\Models\ReviewVote::where('review_id', $data->id)
                                            ->where('user_id',auth()->guard('user')->user()->id)
                                            ->where('vote_status',1)->first();
                                    } else {
                                        $reviewExistsCheck = \App\Models\ReviewVote::where('review_id', $data->id)
                                            ->where('user_id',auth()->guard('user')->user()->id)
                                            ->where('vote_status',0)->first();
                                        //$reviewExistsCheck ==null;
                                    }

                                    if ($reviewExistsCheck != null) {
                                        // if found
                                        $heartColor = '#ff6153';
                                    } else {
                                        // if not found
                                        $heartColor = 'none';
                                    }
                                @endphp
                                    <svg id="reviewlikeBtn_{{ $data->id }}_grid" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="{{ $heartColor }}" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                                    <span>{{ CountLikeReview($data->id)  }}</span>
                                </a>
                                <a href="javascript:void(0)" class="location_btn ms-auto"
                                onclick="reviewDisLike({{ $data->id }})"
                                title="DisLike">

                                @php
                                     if(Auth::guard('user')->check()){
                                        $reviewExistsCheck = \App\Models\ReviewVote::where('review_id', $data->id)
                                            ->where('user_id',auth()->guard('user')->user()->id)
                                            ->where('vote_status',0)->first();
                                    } else {
                                        $reviewExistsCheck = \App\Models\ReviewVote::where('review_id', $data->id)
                                            ->where('user_id',auth()->guard('user')->user()->id)
                                            ->where('vote_status',1)->first();
                                        //$reviewExistsCheck ==null;
                                    }
                                    if ($reviewExistsCheck != null) {
                                        // if found
                                        $heartColor = '#ff6153';
                                    } else {
                                        // if not found
                                        $heartColor = 'none';
                                    }
                                @endphp
                                    <svg id="reviewdislikeBtn_{{ $data->id }}_grid" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="{{ $heartColor }}" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-down"><path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path></svg>
                                    <span id="like_">{{ CountDisLikeReview($data->id)  }}</span>
                                </a>
                            @else
                                <a href="javascript:void(0)" class="ms-auto" title="Like" onclick="toastFire('warning', 'Login to continue');">
                                    <svg id="reviewlikeBtn_{{ $data->id }}_grid" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                                    <span>{{ CountLikeReview($data->id)  }}</span>
                                </a>
                                <a href="javascript:void(0)" class="location_btn ms-auto" title="Dislike" onclick="toastFire('warning', 'Login to continue');">
                                    <svg id="reviewlikeBtn_{{ $data->id }}_grid" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-down"><path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path></svg>
                                    <span>{{ CountDisLikeReview($data->id)  }}</span>
                                </a>
                            @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        </div>
    </section>
    @endif
    @if (count($jobs)>0)
    <section class="py-2 py-sm-4 py-lg-5 similar_postcode more-collection">
        <div class="container">
            <div class="row mb-0 mb-sm-4 justify-content-center">
                <div class="page_title text-center">
                    <h2 class="mb-2"><a href="{{route('front.job.index')}}" class="location_btn">Top Jobs</a></h2>
                </div>
            </div>
            <div class="row">
            @foreach ($jobs as $key => $data)
                <div class="col-6 col-md-3 mb-2 mb-sm-4 mb-lg-3">
                    <div class="smplace_card text-center">
                        <div class="job-desc job-desc--mod">
                            <h4 class="job__role">
                                <a href="{!! URL::to('jobs/' . $data->slug) !!}" class="location_btn">
                                    {{ $data->title ?? ''}}
                                </a>
                            </h4>
                            <h4 class="job__location">{{ $data->company_name?? '' }}</h4>
                            <p class="job__adress" title="{{$data->postcode ? $data->postcode : ''}}{{$data->suburb ? ', '.$data->suburb : ''}}{{$data->state ? ', '.$data->state : ''}}">
                                <i class="fas fa-map-marker-alt"></i>
                                {{$data->postcode ? $data->postcode : ''}}{{$data->suburb ? ', '.$data->suburb : ''}}{{$data->state ? ', '.$data->state : ''}}
                            </p>

                            <span class="badge jobType">Full Time</span>

                            <div class="desc job__desc">
                                <p>{!! $data->description ?? '' !!}</p>
                            </div>
                        </div>
                        <a type="button" class="job__list__btn text-right" style="font-size: 16px"
                            href="{!! URL::to('jobs/' . $data->slug) !!}">
                            Learn More
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        </div>
    </section>
    @endif

    @if ($suburbs->count() > 0)
        <section class="py-2 py-sm-4 py-lg-5 similar_postcode">
            <div class="container">
                <div class="row mb-0 mb-sm-4 justify-content-center">
                    <div class="page_title text-center">
                        <h2 class="mb-2">Similar places</h2>
                    </div>
                </div>

                <div class="row justify-content-center">
                    @foreach ($suburbs as $key => $blog)
                        <div class="col-6 col-md-3 mb-2 mb-sm-4 mb-lg-3">
                            <div class="smplace_card text-center">
                                @if(!$blog->image)
                                    @php
                                        $demoImage = DB::table('demo_images')->where('title', '=', 'suburb')->get();
                                        $demo = $demoImage[0]->image;
                                    @endphp
                                    <a href="{!! URL::to('suburb/' . $blog->slug) !!}" class="location_btn"><img src="{{URL::to('/').'/Demo/'}}{{$demo}}" class="card-img-top"></a>
                                @else
                                    <a href="{!! URL::to('suburb/' . $blog->slug) !!}" class="location_btn"><img src="{{ asset('/admin/uploads/suburb/' . $blog->image) }}" class="card-img-top"></a>
                                @endif

                                <h4><a href="{!! URL::to('suburb/' . $blog->slug) !!}" class="location_btn">{{ $blog->name }} </a></h4>
                                <p>{!! $blog->description !!}</p>
                                <h5>{{ $blog->pin_code }}</h5>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if(count($articles) > 0)
    <section class="py-2 py-sm-4 py-lg-5 bg-light">
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

            <div class="swiper Bestdeals">
                <div class="swiper-wrapper">
                    @foreach ($articles as $key => $blog)
                        <div class="swiper-slide">
                            <div class="card blogCart border-0">
                                <div class="bst_dimg">
                                    @if($blog->image)
                                        <img src="{{URL::to('/').'/Blogs/'}}{{$blog->image}}" class="card-img-top" alt="ltItem">
                                    @else
                                        @php
                                            $demoImage=DB::table('demo_images')->where('title', '=', 'article')->get();
                                            $demo=$demoImage[0]->image;
                                        @endphp
                                        <img src="{{URL::to('/').'/Demo/'}}{{$demo}}" class="card-img-top">
                                    @endif
                                    <div class="dateBox">
                                        <span class="date">{{ $blog->created_at->format('d') }}</span>
                                        <span class="month">{{ $blog->created_at->format('M') }}</span>
                                        <span class="year">{{ $blog->created_at->format('Y') }}</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="card-body-top">
                                        <h5 class="card-title m-0"><a href="{!! URL::to('article/' . $blog->slug ) !!}" class="location_btn">{{ $blog->title }}</a></h5>
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
                                        <a href="{!! URL::to('article/' . $blog->slug)!!}" class="readMoreBtn">Read Article <i class="fas fa-long-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif
@endsection

@push('scripts')
    <script src="https://maps.google.com/maps/api/js?key=" type="text/javascript"></script>
    <script async src="https://static.addtoany.com/menu/page.js"></script>
    <script>
        $('.showMore').click(function(){
            $(this).parent().hide();
            $(this).parent().next().show();
        })
        $('.showLess').click(function(){
            $(this).parent().hide();
            $(this).parent().prev().show();
        })
    </script>
    <script>
        function reviewLike(reviewId) {
            $.ajax({
                url: '{{ route('directory.review.like') }}',
                method: 'post',
                data: {
                    '_token': '{{ csrf_token() }}',
                    id: reviewId,
                },
                success: function(result) {
                    // alert(result);
                    if (result.type == 'add') {
                        // toastr.success(result.message);
                        toastFire("success", result.message);
                        $('#reviewlikeBtn_' + reviewId + '_grid').attr('fill', '#ff6153');
                        $('#reviewlikeBtn_' + reviewId + '_list').attr('fill', '#ff6153');
                        $('#reviewdislikeBtn_' + reviewId + '_grid').attr('fill', 'none');
                        $('#reviewdislikeBtn_' + reviewId + '_list').attr('fill', 'none');
                    } else {
                        toastFire("warning", result.message);
                        // toastr.error(result.message);
                        $('#reviewlikeBtn_' + reviewId + '_grid').attr('fill', 'none');
                        $('#reviewlikeBtn_' + reviewId + '_list').attr('fill', 'none');
                    }
                }
            });
        }
    </script>
    <script>
        function reviewDisLike(reviewId) {
            $.ajax({
                url: '{{ route('directory.review.dislike') }}',
                method: 'post',
                data: {
                    '_token': '{{ csrf_token() }}',
                    id: reviewId,
                },
                success: function(result) {
                    // alert(result);
                    if (result.type == 'add') {
                        // toastr.success(result.message);
                        toastFire("success", result.message);
                        $('#reviewdislikeBtn_' + reviewId + '_grid').attr('fill', '#ff6153');
                        $('#reviewdislikeBtn_' + reviewId + '_list').attr('fill', '#ff6153');
                        $('#reviewlikeBtn_' + reviewId + '_grid').attr('fill', 'none');
                        $('#reviewlikeBtn_' + reviewId + '_list').attr('fill', 'none');
                    } else {
                        toastFire("warning", result.message);
                        // toastr.error(result.message);
                        $('#reviewdislikeBtn_' + reviewId + '_grid').attr('fill', 'none');
                        $('#reviewdislikeBtn_' + reviewId + '_list').attr('fill', 'none');
                    }
                }
            });
        }

        // function googleLATLNGfetch() {
        //     const GoogleAPIKey = 'AIzaSyBgxDP3RxZCzlDJV3j9-mAWepNLWr5_aHA';
        //     const address = '{{$data->pin}}+{{$data->state_name}}';

        //     // geocoding API
        //     const geocodingURL = `https://maps.googleapis.com/maps/api/geocode/json?address=${address}&key=${GoogleAPIKey}`;

        //     $.ajax({
        //         url: geocodingURL,
        //         type: "GET",
        //         success: function (data) {
        //             let lat = results[0].geometry.location.lat();
        //             let lng = results[0].geometry.location.lng();

        //             weatherFetchUpdated(lat, lng);
        //         }
        //     });
        // }
        // function weatherFetchUpdated(lat, lng) {
        //     const APIKey = 'af58f6de0c0689247f2e20fac307a0dc';
        //     const foreCastdays = 7;
        //     // const weatherURL = `api.openweathermap.org/data/2.5/forecast/daily?lat=${lat}&lon=${lng}&cnt=${foreCastdays}&appid=${APIKey}`;
        //     const weatherURL = `api.openweathermap.org/data/2.5/forecast?lat=${lat}&lon=${lng}&appid=${APIKey}`;

        //     $.ajax({
        //         url: weatherURL,
        //         type: "GET",
        //         success: function (data) {
                    
        //         }
        //     });
        // }
        // googleLATLNGfetch();

        // temperature fetch
        function weatherData() {
            $.ajax({
                url:"https://api.openweathermap.org/data/2.5/weather?q={{$data->pin}}&appid=af58f6de0c0689247f2e20fac307a0dc",
                type: "GET",
                success: function (data) {
                    let temp = tempConvert(data.main.temp);
                    let icon = "https://openweathermap.org/img/wn/"+data.weather[0].icon+"@2x.png";
                    let beforeDecimal = temp.toString().split(".")[0];
                    let content = `
                        <div class="card">
                            <div class="card-body p-1 text-center">
                                <img src="${icon}" alt="weather-icon">
                                <h3>${beforeDecimal} &#8451;</h3>
                            </div>
                        </div>
                    `;

                    $('#openWeather-short').html(content);
                }
            })
        }
        weatherData();

        function tempConvert(kelvin) {
            return kelvin - 273.15;
        }

        @php
        $locations = [];
        foreach ($businesses as $business) {
           if($business->image = ''){
	        $img = "https://demo91.co.in/localtales-prelaunch/public/Directory/placeholder-image.png";
            }else{
                $img = "https://maps.googleapis.com/maps/api/streetview?size=640x640&location=".$business->latitude.",".$business->longitude."&fov=120&heading=0&key=";
            }

            $page_link = URL::to('directory/' . $business->slug );

            $data = [$business->name, floatval($business->latitude), floatval($business->longitude), $business->address, $page_link];
            array_push($locations, $data);
        }
        @endphp

        var locations = <?php echo json_encode($locations); ?>;

        if (locations.length > 0) {
            var map = new google.maps.Map(document.getElementById('mapShow'), {
                zoom: 15,
                center: new google.maps.LatLng(locations[0][1], locations[0][2]),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                "styles": [{
                    "featureType": "administrative",
                    "elementType": "labels.text.fill",
                    "stylers": [{
                        "color": "#444444"
                    }]
                }, {
                    "featureType": "landscape",
                    "elementType": "all",
                    "stylers": [{
                        "color": "#f2f2f2"
                    }]
                }, {
                    "featureType": "poi",
                    "elementType": "all",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }, {
                    "featureType": "road",
                    "elementType": "all",
                    "stylers": [{
                        "saturation": -100
                    }, {
                        "lightness": 45
                    }]
                }, {
                    "featureType": "road.highway",
                    "elementType": "all",
                    "stylers": [{
                        "visibility": "simplified"
                    }]
                }, {
                    "featureType": "road.arterial",
                    "elementType": "labels.icon",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }, {
                    "featureType": "transit",
                    "elementType": "all",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }, {
                    "featureType": "water",
                    "elementType": "all",
                    "stylers": [{
                        "color": "#4f595d"
                    }, {
                        "visibility": "on"
                    }]
                }],
            });

            var infowindow = new google.maps.InfoWindow();

            var marker, i;
            var iconBase = 'https://demo91.co.in/localtales-prelaunch/public/site/images/';

            for (i = 0; i < locations.length; i++) {
                const contentString =
                    '<div id="content">' +
                    '<div id="siteNotice">' +
                    "</div>" +
                    //'<img src="' + locations[i][4] + '" width="">' +

                    '<div class="mapPopContent"><div id="bodyContent"><a href="' + locations[i][4] +
                    '" target="_blank"><h6 id="firstHeading" class="firstHeading mb-2">' + locations[i][0] + '</h6></a>' +
                    '<p>' + locations[i][3] + '</p></div>' +

                    '<a href="' + locations[i][4] + '" target="_blank" class="directionBtn"><i class="fas fa-link"></i></a>' +
                    '</div></div>';

                const infowindow = new google.maps.InfoWindow({
                    content: contentString,
                });

                const marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map,
                    icon: iconBase + 'map_icon.png'
                });

                marker.addListener("click", () => {
                    infowindow.open({
                        anchor: marker,
                        map,
                        shouldFocus: false,
                    });
                });
            }
        }

        $('input[name="address"]').on('keyup', function() {
            var $this = 'input[name="address"]'

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
                            content +=
                                `<div class="dropdown-menu show w-100 postcode-dropdown" aria-labelledby="dropdownMenuButton">`;

                            $.each(result.data, (key, value) => {
                                content +=
                                    `<a class="dropdown-item" href="javascript: void(0)" onclick="fetchCode1(${value.pin})">${value.state}, ${value.pin}</a>`;
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

        function fetchCode1(code) {
            $('.postcode-dropdown').hide()
            $('input[name="address"]').val(code)
        }
        $('body').on('click', function() {
            //code
            $('.postcode-dropdown').hide();
        });

        $('input[name="directory_category"]').on('click', function() {
            var content = '';

            @php
                $primaryCat = \DB::table('directory_categories')->where('type', 1)->where('status', 1)->limit(5)->get();
            @endphp

            content += `<div class="dropdown-menu show w-100 postcode-dropdown">`;

            @foreach($primaryCat as $category)
                content += `<a class="dropdown-item" href="javascript: void(0)" onclick="fetchCode('{{$category->parent_category}}', {{$category->id}}, 'primary')">{{$category->parent_category}}</a>`;
            @endforeach

            content += `</div>`;
            $('.respDrop').html(content);
        });

        $('input[name="directory_category"]').on('keyup', function() {
            var $this = 'input[name="directory_category"]'

            if ($($this).val().length > 0) {
                $.ajax({
                    url: '{{ route("directory.category.ajax") }}',
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
                                var type = '';
                                if(value.type == "primary") {
                                    type1 = 'primary';
                                    type2 = 'secondary';
                                } else {
                                    type1 = 'secondary';
                                    type2 = 'business';
                                }

                                content += `<a class="dropdown-item" href="javascript: void(0)" onclick="fetchCode('${value.title}', ${value.id}, '${type1}')">${value.title}</a>`;

                                if (value.child.length > 0) {
                                    // content += `<h6 class="dropdown-header">Secondary</h6>`;

                                    $.each(value.child, (key1, value1) => {
                                        var url = "";

                                        if (type2 == 'business') {
                                            url = `{{url('/')}}/directory/${value1.slug}`;
                                        } else {
                                            url = "javascript: void(0)";
                                        }

                                        content += `<a class="dropdown-item ml-4" href="${url}" onclick="fetchCode('${value1.child_category}', ${value1.id}, '${type2}')">${value1.child_category}</a>`;
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

        function fetchCode(item, code, type) {
            $('.postcode-dropdown').hide()
            $('input[name="directory_category"]').val(item)
            $('input[name="code"]').val(code)
            $('input[name="type"]').val(type)
        }

        $(document).on("click", "#btnFilter", function() {
            $('#checkout-form').submit();
        });
        $(document).keypress(function(event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);  if(keycode == '13'){    $('#checkout-form').submit();
         }
        });
    </script>
@endpush
