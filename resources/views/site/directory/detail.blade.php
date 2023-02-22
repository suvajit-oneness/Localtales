@extends('site.app')

@php
    $title = seoManagement('directory_detail')->title;

    if (!empty($business->name)) {
        $business_name_replace = str_replace('BUSINESS_NAME_HERE', $business->name, $title);
    }

    if (!empty($business->category_id)) {
        $category_replace = str_replace('BUSINESS_CATEGORY_HERE', directoryCategoryStr($business->category_id), $business_name_replace);
    }

    if (!empty($business->address)) {
        $suburb_replace = str_replace('SUBURB', directoryAddressBreakup($business->address)[1], $category_replace);
        $postcode_replace = str_replace('POSTCODE', directoryAddressBreakup($business->address)[3], $suburb_replace);
    }

    $final_title = str_replace('&amp;', '&', $postcode_replace);
@endphp

@section('title'){!!$final_title!!}@endsection
@section('description'){{seoManagement('directory_detail')->meta_desc}}@endsection

@section('content')
<style>
    .wishlist {
        width: 70px;
    }
    .skeleton {
        background-color: #e2e5e7;
        background-image: linear-gradient(90deg, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.5), rgba(255, 255, 255, 0));
        background-size: 40px 100%;
        background-repeat: no-repeat;
        background-position: left -40px top 0;
        -webkit-animation: shine 1s ease infinite;
                animation: shine 1s ease infinite;
    }

    @-webkit-keyframes shine {
        to {
            background-position: right -40px top 0;
        }
    }

    @keyframes shine {
        to {
            background-position: right -40px top 0;
        }
    }
</style>

@php
    $locations = array();

    $address = $business->address;
    $directoryLattitude = $business->lat;
    $directoryLongitude = $business->lon;

    $orgId = $business->id;
    $orgAddress = $business->address;
    $orgCat = $business->category_id;

    if ($directoryLattitude == null || $directoryLongitude == null ) {
        $url = "https://maps.google.com/maps/api/geocode/json?address=".urlencode($address)."&key=";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $responseJson = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($responseJson);

        if($response->results) {
            $latitude = $response->results[0]->geometry->location->lat;
            $longitude = $response->results[0]->geometry->location->lng;

            // insert lat & lon into directories
            \DB::table('directories')->where('id', $business->id)->update([
                'lat' => $latitude,
                'lon' => $longitude
            ]);
        } else {
            $latitude = '';
            $longitude = '';
        }
    } else {
        $business->latitude = $directoryLattitude;
        $business->longitude = $directoryLongitude;
    }

    // $business->latitude = $latitude;
    // $business->longitude = $longitude;
@endphp

<section class="details_banner">
    <figcaption>
        <div class="container">
            <div class="details_info py-2 py-lg-3 mb-0">
                <div class="row justify-content-between">
                    <div class="col-lg">
                        <ul class="breadcumb_list mb-2 mb-sm-4">
                            <li><a href="{!! URL::to('') !!}">Home</a></li>
                            <li>/</li>
                            <li>
                                <a href="{!! URL::to('directory') !!}">
                                    {!! directoryCategory($business->category_id) !!}
                                </a>
                            </li>
                            <li>/</li>
                            <li>{{ $business->name }}</li>
                        </ul>
                        <h1 class="details_banner_heading">{{ $business->name }}</h1>
                    </div>
                    <div class="col-auto align-self-center">
                        <a href="javascript:void(0)" class="wishlist_button" onclick="directoryBookmark({{$business->id}})">
                            @php
                                $ip = $_SERVER['REMOTE_ADDR'];
                                if(auth()->guard('user')->check()) {
                                    $collectionExistsCheck = \App\Models\Userbusiness::where('directory_id', $business->id)->where('ip', $ip)->orWhere('user_id', auth()->guard('user')->user()->id)->first();
                                } else {
                                    $collectionExistsCheck = \App\Models\Userbusiness::where('directory_id', $business->id)->where('ip', $ip)->first();
                                }

                                if($collectionExistsCheck != null) {
                                    // if found
                                    $heartColor = "#ffffff";
                                } else {
                                    // if not found
                                    $heartColor = "none";
                                }
                            @endphp
                            <svg id="saveBtn" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="{{$heartColor}}" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </a>

                        <div class="share-btns">
                            <div class="dropdown">
                                <button class="share_button dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#898989" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share-2"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                    <div class="w-100 pl-2">
                                        <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                            <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
                                            <a class="a2a_button_facebook"></a>
                                            <a class="a2a_button_twitter"></a>
                                            <a class="a2a_button_email"></a>
                                            <a class="a2a_button_whatsapp"></a>
                                            <a class="a2a_button_pinterest"></a>
                                            <a class="a2a_button_linkedin"></a>
                                            <a class="a2a_button_telegram"></a>
                                            <a class="a2a_button_facebook_messenger"></a>
                                            <a class="a2a_button_google_gmail"></a>
                                            <a class="a2a_button_reddit"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row directory__social mt-3">
                    <div class="col-12">
                        <ul>
                            @if(!empty($business->facebook_link))
                            <li>
                                <a href="{{$business->facebook_link}}" target="_blank">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </li>
                            @endif
                            @if(!empty($business->twitter_link))
                            <li>
                                <a href="{{$business->twitter_link}}" target="_blank">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </li>
                            @endif
                            @if(!empty($business->instagram_link))
                            <li>
                                <a href="{{$business->instagram_link}}" target="_blank">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <div class="banner_meta_area">
                <div class="banner_meta_item">
                    <figure>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                        </svg>
                    </figure>
                    <figcaption>
                        <h5>Category</h5>
                        {!! directoryCategory($business->category_id) !!}
                    </figcaption>
                </div>
                <div class="banner_meta_item">
                    <figure>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-map-pin">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </figure>
                    <figcaption>
                        <h5>Address</h5>
                        <p>{{ $business->address }}</p>
                        <input type="hidden" id="googlemapaddress" value="{{ $business->address }}">
                    </figcaption>
                </div>
                <div class="banner_meta_item">
                    <figure>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                    </figure>
                    <figcaption>
                        <h5>Website</h5>
                        <p style="text-transform:none;"> @php
                            if (($business->website == "NA" || $business->website == "")) {
                                echo '';
                            } else {
                                echo '
                                <a href="'.$business->website.'" target="_blank" class="">'.$business->website.'</a>';
                            }
                        @endphp</p>
                    </figcaption>
                </div>
            </div>
        </div>
    </figcaption>
</section>

<section class="letest-offer">
    @php  @endphp
    <div class="container">
        <div class="row">
            <div class="col-md-6 details_left">
                <div class="tab-content descriptionContent">
                    <div class="descriptonBox" id="service">
                        <h4>Service Description</h4>
                        @if($business->service_description=='')
                            N/A
                        @else
                            {!! $business->service_description !!}
                        @endif
                    </div>
                    <div class="descriptonBox" id="description">
                        <h4>Description</h4>
                        @if($business->description =='')
                            N/A
                        @else
                        {!! $business->description !!}
                        @endif
                    </div>
                    <div class="descriptonBox" id="hours" aria-labelledby="hours-tab">
                        <h4>Opening Hours</h4>
                        <table class="table table-sm table-hover">
                                     <tr>
                                <td>Monday</td>
                                @if($business->monday=='NA' || $business->monday=='')
                                    <td>N/A</td>
                                @else
                                    <td>{{ str_replace('Monday: ', '', $business->monday) }}</td>
                                @endif
                            </tr>
                            <tr>
                                <td>Tuesday</td>
                                @if($business->tuesday=='NA' || $business->tuesday=='')
                                    <td>N/A</td>
                                @else
                                    <td>{{ str_replace('Tuesday: ', '', $business->tuesday) }}</td>
                                @endif
                            </tr>
                            <tr>
                                <td>Wednesday</td>
                                @if($business->wednesday=='NA' || $business->wednesday=='')
                                    <td>N/A</td>
                                @else
                                    <td>{{ str_replace('Wednesday: ', '', $business->wednesday) }}</td>
                                @endif
                            </tr>
                            <tr>
                                <td>Thursday</td>
                                @if($business->thursday=='NA' || $business->thursday=='')
                                    <td>N/A</td>
                                @else
                                    <td>{{ str_replace('Thursday: ', '', $business->thursday) }}</td>
                                @endif
                            </tr>
                            <tr>
                                <td>Friday</td>
                                @if($business->friday=='NA' || $business->friday=='')
                                    <td>N/A</td>
                                @else
                                    <td>{{ str_replace('Friday: ', '', $business->friday) }}</td>
                                @endif
                            </tr>
                            <tr>
                                <td>Saturday</td>
                                @if($business->saturday=='NA' || $business->saturday=='')
                                    <td>N/A</td>
                                @else
                                    <td>{{ str_replace('Saturday: ', '', $business->saturday) }}</td>
                                @endif
                            </tr>
                            <tr>
                                <td>Sunday</td>
                                @if($business->sunday=='NA'  || $business->sunday=='')
                                    <td>N/A</td>
                                @else
                                    <td>{{ str_replace('Sunday: ', '', $business->sunday) }}</td>
                                @endif
                            </tr>
                            <tr>
                                <td>Public Holiday</td>
                                @if($business->public_holiday=='NA' || $business->public_holiday=='')
                                    <td>N/A</td>
                                @else
                                    <td>{{ $business->public_holiday }}</td>
                                @endif
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6 details_left">
                <div class="directory-map">
                    <div id="mapShow" style="height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row mb-0 mb-sm-4 justify-content-center">
            <div class="page_title text-center">
                <h2 class="mb-2">Review Summary</h2>
            </div>
        </div>
    </div>
</section>

<section class="py-2 py-sm-4 py-lg-5">
    <div class="container">
        <div class="row mb-0 mb-sm-4 justify-content-center">
            <div class="page_title text-center">
                <h2 class="mb-2"><a href="{{route('review')}}" class="location_btn">Recent Reviews </a></h2>
            </div>
        </div>

        <div class="row">
            <div class="reviewListWrap col">
                <section class="py-2 py-sm-2 py-lg-2 similar_postcode">
                    <div class="row">
                        @foreach($review as $data)
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
                                        @if(Auth::guard('user')->check())
                                            <a href="javascript:void(0)" class="location_btn ms-auto" onclick="reviewLike({{ $data->id }})" title="Like">

                                            @php
                                                if(Auth::guard('user')->check()){
                                                    $reviewExistsCheck = \App\Models\ReviewVote::where('review_id', $data->id)
                                                        ->where('user_id',auth()->guard('user')->user()->id)
                                                        ->where('vote_status',1)->first();
                                                } else {
                                                    $reviewExistsCheck = \App\Models\ReviewVote::where('review_id', $data->id)
                                                        // ->where('user_id',auth()->guard('user')->user()->id)
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
                                            <a href="javascript:void(0)" class="location_btn ms-auto" onclick="reviewDisLike({{ $data->id }})" title="DisLike">

                                            @php
                                                 if(Auth::guard('user')->check()){
                                                    $reviewExistsCheck = \App\Models\ReviewVote::where('review_id', $data->id)
                                                        ->where('user_id',auth()->guard('user')->user()->id)
                                                        ->where('vote_status',0)->first();
                                                } else {
                                                    $reviewExistsCheck = \App\Models\ReviewVote::where('review_id', $data->id)
                                                        // ->where('user_id',auth()->guard('user')->user()->id)
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
                                            <a href="javascript:void(0)" class="location_btn ms-auto" title="Like" onclick="toastFire('warning', 'Login to continue');">
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
                </section>
            </div>
        </div>

        <form method="post" action="{{route('directory.review.store')}}" id="reviewForm">@csrf
            <input type="hidden" name="directory_id" id="" value="{{$business->id}}">
            <div class="reviwbox mt-4">
                <div class="row">
                    <h2 class="col-12 mb-3">Review</h2>
                    <div class="form-group col-md-12">
                        <label for="Name">Name:</label>
                        <input type="text" class="form-control" name="author_name" id="author_name">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="comment">Comment:</label>
                        <textarea type="text" class="form-control" name="text" id="text"></textarea>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="rating">Rating:</label>
                        <div class="star-rating">
                            <input id="star-5" type="radio" name="rating" value="5" />
                            <label for="star-5" title="5 stars">
                                <i class="active fa fa-star" aria-hidden="true"></i>
                            </label>
                            <input id="star-4" type="radio" name="rating" value="4" />
                            <label for="star-4" title="4 stars">
                                <i class="active fa fa-star" aria-hidden="true"></i>
                            </label>
                            <input id="star-3" type="radio" name="rating" value="3" />
                            <label for="star-3" title="3 stars">
                                <i class="active fa fa-star" aria-hidden="true"></i>
                            </label>
                            <input id="star-2" type="radio" name="rating" value="2" />
                            <label for="star-2" title="2 stars">
                                <i class="active fa fa-star" aria-hidden="true"></i>
                            </label>
                            <input id="star-1" type="radio" name="rating" value="1" />
                            <label for="star-1" title="1 star">
                                <i class="active fa fa-star" aria-hidden="true"></i>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-login" id="reviewBtn">Save changes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<section class="py-2 py-sm-4 py-lg-5 smallGapGrid">
    <div class="container">
        <div class="page-title best_deal">
            <h2>Related Businesses</h2>
        </div>

        <div id="tab-contents">
            <div class=" smallGapGrid active" id="grid">
                <div class="row Bestdeals" id="relatedDirectories">
                    @for ($i = 0; $i < 6; $i++)
                    <div class="col-6 col-md-4 col-lg-4 mb-3 mb-lg-4">
                        <div class="card directoryCard directory_block border-0 v3card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="#" class="skeleton" style="display: inline-block; max-width: 160px; height: 23px;"></a>
                                </h5>
                                <p class="review skeleton" style="height: 22px"></p>
                                <p class="skeleton" style="height: 22px"></p>
                                <p class="skeleton" style="height: 24px"></p>

                                <div class="categoryB-list v3_flag">
                                    <span href="#" class="skeleton mb-2 mr-2" style="display: inline-block; width: 100%; max-width: 180px; height: 23px;"></span>
                                    <span href="#" class="skeleton mb-2" style="display: inline-block; width: 100%; max-width: 84px; height: 23px;"></span>
                                    <span href="#" class="skeleton mb-2" style="display: inline-block; width: 100%; max-width: 122px; height: 23px;"></span>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>

    </div>
</section>

<section class="py-2 py-sm-4 py-lg-5 smallGapGrid">
    <div class="container">
        <div class="page-title best_deal">
            <h2>Nearby Businesses</h2>
        </div>

        @php
            $nearbyProducts = \App\Models\Directory::where('address', 'LIKE', '%'.substr($business->address, -4).'%')->where('id', '!=', $business->id)->limit(6)->get();
        @endphp

        <div id="tab-contents">
        <div class=" smallGapGrid active" id="grid">
        <div class="row Bestdeals nearby-business">
        @php
        $businesses = [];
        foreach ($nearbyProducts as $business) {
            $address = $business->address;
            array_push($businesses, $business);
        }
        @endphp
            @foreach($businesses as $key => $business)
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
    </div>
</section>
@endsection

@push('scripts')
    <script src="https://maps.google.com/maps/api/js?key=" type="text/javascript"></script>
    <script async src="https://static.addtoany.com/menu/page.js"></script>
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

        $('.showMore').click(function(){
            $(this).parent().hide();
            $(this).parent().next().show();
        })
        $('.showLess').click(function(){
            $(this).parent().hide();
            $(this).parent().prev().show();
        })

        $(document).on('submit', '#reviewForm', (event) => {
            event.preventDefault();

            $.ajax({
                url: "{{ route('directory.add.review.ajax') }}",
                type: "POST",
                data: {
                    _token: "{{csrf_token()}}",
                    author_name: $('#reviewForm input[name="author_name"]').val(),
                    directory_id: $('#reviewForm input[name="directory_id"]').val(),
                    rating: $('#reviewForm input[name="rating"]:checked').val(),
                    text: $('#reviewForm textarea[name="text"]').val(),
                },
                beforeSend: function() {
                    $('#reviewBtn').attr('disabled', true).html('Adding...');
                },
                success: function(result) {
                    if (result.error === false) {
                        toastFire('success', result.message);
                    } else {
                        toastFire('warning', result.message);
                    }

                    $('#reviewBtn').attr('disabled', false).html('Review added');
                }
            });
        });

        // AutoComplete Start
        var geocoder = new google.maps.Geocoder();
        var address = $("#googlemapaddress").val();

        geocoder.geocode( { 'address': address}, function(results, status) {
            // console.log(results);
            if (status == google.maps.GeocoderStatus.OK) {
                var latitude = results[0].geometry.location.lat();
                var longitude = results[0].geometry.location.lng();
                console.log(latitude, longitude);
                $("#latLngShow").html('lat: ' + latitude + '<br>lng: ' + longitude)
                var map = new google.maps.Map(document.getElementById('mapShow'), {
                    zoom: 16,
                    center: new google.maps.LatLng(latitude, longitude),
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

                //map marker show
                var infowindow = new google.maps.InfoWindow();

                var marker, i;
                // var iconBase = 'http://cp-33.hostgator.tempwebhost.net/~a1627unp/dev/localtales_v2/public/site/images/';
                var iconBase = 'https://demo91.co.in/localtales-prelaunch/public/site/images/map_icon.png';

                for (i = 0; i < locations.length; i++) {
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(latitude, longitude),
                        map: map,
                        icon: iconBase
                        // icon: iconBase + 'map_icon.png'
                    });

                    google.maps.deal.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                            infowindow.setContent(latitude, longitude);
                            infowindow.open(map, marker);
                        }
                    })(marker, i));
                }
            }
        });

        @php
            $locations = [];
            $data = [$business->title, floatval($business->lat), floatval($business->lon)];
            array_push($locations, $data);
        @endphp
        var locations = <?php echo json_encode($locations); ?>;
        console.log("dealLocations>>" + JSON.stringify(locations));

        console.log(JSON.stringify(locations));
    </script>

    <script>
        // directory bookmark/ save/ wishlist
        function directoryBookmark(collectionId) {
            $.ajax({
                url: '{{ route('user.directory.save.toggle') }}',
                method: 'post',
                data: {
                    '_token': '{{ csrf_token() }}',
                    id: collectionId,
                },
                success: function(result) {
                    // alert(result);
                    if (result.type == 'add') {
                        toastr.success(result.message);
                        $('#saveBtn').attr('fill', '#fff');
                    } else {
                        toastr.error(result.message);
                        $('#saveBtn').attr('fill', 'none');
                    }
                }
            });
        }

        // related business
        function relatedBusiness(collectionId) {
            $.ajax({
                url: '{{ route('directory.related') }}',
                method: 'post',
                data: {
                    '_token': '{{ csrf_token() }}',
                    address: '{{$orgAddress}}',
                    category: '{{$orgCat}}',
                    id: '{{$orgId}}',
                },
                success: function(result) {
                    var content = '';
                    if(result.error == false) {
                        $.each(result.resp, (key, value) => {
                            if (key === 6) return false;

                            content += `
                            <div class="col-6 col-md-4 col-lg-4 mb-3 mb-lg-4">
                                <div class="card directoryCard directory_block border-0 v3card">
                                    <div class="card-body">
                                        <h5 class="card-title"><a href="{{url('/')}}/directory/${value.slug}" class="location_btn">${value.name}</a></h5>
                                        ${value.rating}
                                        <p><i class="fas fa-map-marker-alt"></i> ${value.address}</p>
                                        <div>
                                            <div>
                                                <a href="tel:${value.mobile}" class="g_l_icon"><i class="fas fa-phone-alt"></i>${value.mobile}</a>
                                            </div>
                                            <div class="categoryB-list v3_flag">`;
                                                // category show
                                                $.each(value.category, (catKey, catVal) => {
                                                    if (catVal.child_category == "" || catVal.child_category == null) {
                                                        content += `
                                                        <a class="mb-2" href="{{url('/')}}/${catVal.slug}">${catVal.title}</a>,
                                                        `;
                                                    } else {
                                                        content += `
                                                        <a class="mb-2" href="{{url('/')}}/${catVal.child_category_slug}">${catVal.child_category}</a>,
                                                        `;
                                                    }
                                                })
                                                // <p>${value.category_id}</p>
                                            content += `
                                            </div>
                                        </div>
                                        <div class="v3readmore">
                                            <a href="{{url('/')}}/directory/${value.slug}"><i class="fa fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;
                        });
                    }

                    $('#relatedDirectories').html(content);
                }
            });
        }

        relatedBusiness();
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // tooltip
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

        // sweetalert fires | type = success, error, warning, info, question
        function toastFire(type = 'success', title, body = '') {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: type,
                title: title,
                text: body,
                showConfirmButton: false,
                confirmButtonColor: '#c10909',
                timer: 1000
            })
        }

        // on session toast fires
        @if (Session::get('success'))
            toastFire('success', '{{ Session::get('success') }}');
        @elseif (Session::get('failure'))
            toastFire('danger', '{{ Session::get('failure') }}');
        @endif

        $(document).on('submit', '#claimForm', (event) => {
            event.preventDefault();
			const cartSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>';

            $.ajax({
                url: "{{ route('add.claim.ajax') }}",
                type: "POST",
                data: {
                    _token: "{{csrf_token()}}",
                    directory_id: $('#claimForm input[name="directory_id"]').val(),
                    user_name: $('#claimForm input[name="user_name"]').val(),
                    user_email: $('#claimForm input[name="user_email"]').val(),
                    comment: $('#claimForm textarea[name="comment"]').val(),
                },
                beforeSend: function() {
                    $('.claimBtn').attr('disabled', true).html(cartSvg+' Adding....');
                },
                success: function(result) {
                    if (result.error === false) {
                        $('.minihelpBtn').html(cartSvg+'<span class="badge badge-danger">'+result.count+'</span>');
                        toastFire('success', result.message);
                    } else {
                        toastFire('warning', result.message);
                    }
                    $('.claimBtn').attr('disabled', false).html(cartSvg+' Comment added');
                }
            });
        });
    </script>
    <script src="{{ asset('frontend/dist/owl.carousel.min.js') }}"></script>

   
@endpush
