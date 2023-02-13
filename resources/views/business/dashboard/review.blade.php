@extends('business.app')
@section('title') Review @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file"></i> Review</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <span class="top-form-btn">
                    <a class="btn btn-secondary" href="{{ route('business.dashboard') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Back</a>
                </span>
            </div>
        </div>
    </div>
    @include('business.partials.flash')

    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10">
                            
                            <p>Rating : {{ Auth::guard('business')->user()->rating ?? ''}}{!! directoryRatingHtml(Auth::guard('business')->user()->rating) !!}</p>

                            <p>Review</p>
                            @php
                                $googleReviews = \DB::select("SELECT review_json as google_review FROM directory_reviews WHERE dir_id = '". Auth::guard('business')->user()->id ."' ");
                                if (count($googleReviews)>0) {
                                    $jsonToArr = json_decode($googleReviews[0]->google_review, true);
                                }
                            @endphp

                            @if(isset($jsonToArr))
                            @foreach($jsonToArr as $googleReviewKey => $googleReview)
                                <div class="reviewList">
                                    <div class="reviewListImg">
                                        <img src="{{asset('Directory/userDefualt.png')}}" alt="">
                                    </div>
                                    <div class="reviewListText">
                                        <div class="reviewListTextTop">
                                            <h3>{{ $googleReview['author_name'] }}</h3>
                                            <div class="date">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                                {{ date('j F, Y', substr($googleReview['time'], 0, 10)) }}
                                            </div>
                                        </div>
                                        <div class="reviewListTextRating">
                                            @php
                                                $rating = number_format($googleReview['rating'],1);
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
                                        <p>{{ $googleReview['text'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                            @else
                            <p>No Reviews Available</p>
                            @endif
                            @foreach($review as $cat)
                                <div class="reviewList">
                                    <div class="reviewListImg">
                                        <img src="{{asset('Directory/userDefualt.png')}}" alt="">
                                    </div>
                                    <div class="reviewListText">
                                        <div class="reviewListTextTop">
                                            <h3>{{ $cat->name }}</h3>
                                            <div class="date">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                                {{ date('j F, Y', strtotime($cat->created_at)) }}
                                            </div>
                                        </div>
                                        <div class="reviewListTextRating">
                                            @php
                                                $rating = number_format($cat->rating,1);
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
                                        <p>{{ $cat->comment }}</p>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><br>
@endsection
