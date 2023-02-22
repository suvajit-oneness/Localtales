@extends('admin.app')
@section('title') Review @endsection

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file"></i> Review</h1>
            <p>List of all reviews</p>
        </div>
    </div>

    @include('business.partials.flash')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        @forelse ($review as $data)
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
                                                <p>{{ substr($data->text,0,200) }}... <small class="text-underline text-primary showMore" style="cursor: pointer">Read more</small></p>

                                                <p style="display: none">{{$data->text}}<small class="text-underline text-primary showLess" style="cursor: pointer">Read less</small></p>
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
                        @empty
                            <p class="text-center text-muted">No reviews yet</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div><br>
@endsection

@push('scripts')
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
@endpush