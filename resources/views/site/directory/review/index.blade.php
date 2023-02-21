@extends('site.app')
@section('title')Reviews @endsection
@section('description')
@endsection
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
    <section class="inner_banner articles_inbanner"
        style="background: url({{ asset('site/images/banner') }}-image.jpg) no-repeat center center; background-size:cover;">
        <div class="container position-relative">
            <div class="row m-0 mb-4">
                <h1>Recent Reviews</h1>
            </div>
            <div class="page-search-block filterSearchBoxWraper" style="bottom: -83px;">
                <div class="filterSearchBox">
                    <form action="" id="checkout-form">
                        <div class="filterSearchBox">
                            <div class="row">
                                <div class="col-12 col-sm mb-2 mb-sm-0">
                                    <div class="form-floating">
                                        <input id="postcodefloting" type="text" class="form-control pl-3"
                                            name="key_details" placeholder="Postcode/ State"
                                            value="{{ request()->input('key_details') }}" autocomplete="off">
                                        <input type="hidden" name="keyword" value="{{ request()->input('keyword') }}">
                                        <label for="postcodefloting">Suburb or Postcode</label>
                                    </div>
                                    <div class="respDrop"></div>
                                </div>

                                {{-- <div class="mb-sm-0 col col-lg fcontrol position-relative filter_selectWrap filter_selectWrap2">
                                    <div class="select-floating">
                                        <div class="select-floating-admin">
                                            <select name="code" id="category" placeholder="Category"
                                                class="filter_select form-control @error('category') is-invalid @enderror">
                                                <option value="" hidden selected>Select a Category</option>
                                                @foreach ($category as $data)
                                                    <option value="{{ $data->id }}"
                                                        {{ request()->input('code') == $data->id ? 'selected' : '' }}>
                                                        {{ ucwords($data->title) }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <p class="small text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="col col-sm">
                                    <div class="form-floating">
                                        <input id="searchbykeyword" type="text" name="name" class="form-control pl-3"
                                            value="{{ request()->input('name') }}" placeholder="Search by keyword...">
                                        <label for="searchbykeyword" placeholder="Nom">Search by Directory</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <select name="orderBy" id="orderBy" class="form-control form-control-sm">
                                        <option value="" hidden selected>Sort by</option>
                                        <option value="" disabled>Select</option>
                                        <option value="date_desc" {{ ($request->orderBy == "date_desc") ? 'selected' : '' }}>Latest review</option>
                                        <option value="rating_desc" {{ ($request->orderBy == "rating_desc") ? 'selected' : '' }}>Highest rating</option>
                                        <option value="rating_asc" {{ ($request->orderBy == "rating_asc") ? 'selected' : '' }}>Lowest rating</option>
                                    </select>
                                    {{-- <label for="searchbykeyword" placeholder="Nom">Sort by</label> --}}
                                </div>
                                <div class="col-auto col-sm-auto">
                                    <a href="javascript:void(0);" id="btnFilter"
                                        class="w-100 btn btn-blue text-center ml-auto"><img
                                            src="{{ asset('front/img/search.svg') }}"></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-5 light-bg more-collection more_collection_bredcumb more-collection__mobile">
        <div class="container">
            <ul class="breadcumb_list mb-4">
                <li><a href="{!! URL::to('/') !!}">Home</a></li>
                <li>/</li>
                <li class="active">Reviews</li>
            </ul>

            <div class="">
				@if (!empty(request()->input('orderBy'))|| !empty(request()->input('keyword'))|| !empty(request()->input('name')))
				    @if ($reviewList->count() > 0)
                        <h2 class="mb-2 mb-sm-3">Reviews found</h2>
				    @else
                        <h2 class="mb-2 mb-sm-3">No Reviews found</h2>

				        <p class="mb-2 mb-sm-3 text-muted">Please try again with different  filter</p>
				    @endif
                {{-- @else
                    <h2>No Job found</h2> --}}
				@endif
            </div>
            @if (count($reviewList) > 0)
            <section class="py-2 py-sm-2 py-lg-2 similar_postcode">
                <div class="row">
                    @foreach ($reviewList as $key => $data)
                        <div class="col-6 col-md-3 mb-2 mb-sm-4 mb-lg-3">
                            <div class="card directory-single-review">
                                <div class="card-body">
                                    <h5>{{ $data->author_name }}</h5>

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
                                        @guest
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
                                        @endguest
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            @endif
            <div class="d-flex justify-content-center mt-4">
                {{ $reviewList->appends($_GET)->links() }}
            </div>
        </div>
    </section>

@endsection

@push('scripts')
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
</script>
    <script>
        $('body').on('click', function() {
            //code
            $('.postcode-dropdown').hide();
        });

        // state, suburb, postcode data fetch
        $('input[name="key_details"]').on('keyup', function() {
            var $this = 'input[name="key_details"]'

            if ($($this).val().length > 0) {
                $('input[name="keyword"]').val($($this).val())
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
                                if (value.type == 'pin') {
                                    content +=
                                        `<a class="dropdown-item" href="javascript: void(0)" onclick="fetchCode(${value.pin}, '${value.pin}', '${value.type}')"><strong>${value.pin}</strong></a>`;
                                } else if (value.type == 'suburb') {
                                    content +=
                                        `<a class="dropdown-item" href="javascript: void(0)" onclick="fetchCode('${value.suburb}', '${value.suburb}, ${value.short_state} ${value.pin}', '${value.type}')"><strong>${value.suburb}</strong>, ${value.short_state} ${value.pin}</a>`;
                                } else {
                                    content += ``;
                                }
                            })

                            if (result.data.length == 1) {
                                content = '';
                            }

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

        function fetchCode(keyword, details, type) {
            $('.postcode-dropdown').hide()
            $('input[name="keyword"]').val(keyword)
            $('input[name="key_details"]').val(details)
        }
        $(document).on("click", "#btnFilter", function() {
            $('#checkout-form').submit();
        });
        $(document).keypress(function(event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                $('#checkout-form').submit();
            }
        });
    </script>
@endpush
