@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
            <p>{{ $subTitle }}</p>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <table class="table table-hover custom-data-table-style table-striped table-col-width" id="sampleTable">
                    <tbody>
                        {{-- {{dd($deal->business)}} --}}
                        <tr>
                            <td>Deal Title</td>
                            <td>{{ empty($deal['title'])? null:$deal['title'] }}</td>
                        </tr>
                        <tr>
                            <td>Deal Image</td>
                            <td>@if($deal->image!='')
                                <img style="width: 150px;height: 100px;" src="{{URL::to('/').'/uploads/deals/'}}{{$deal->image}}">
                                @endif</td>
                        </tr>
                        {{-- <tr>
                            <td>Category</td>
                            <td>{{ empty($deal->category['title'])? null:($deal->category['title']) }}</td>
                        </tr> --}}
                        <tr>
                            <td>Address</td>
                            <td>{{ empty($deal['address'])? null:($deal['address']) }}</td>
                        </tr>
                        <tr>
                            <td>Latitude</td>
                            <td>{{ empty($deal['lat'])? null:($deal['lat']) }}</td>
                        </tr>
                        <tr>
                            <td>Longitude</td>
                            <td>{{ empty($deal['lon'])? null:($deal['lon']) }}</td>
                        </tr>
                        <tr>
                            <td>Expiry Date</td>
                            <td>{{ empty($deal['expiry_date'])? null:(date("d-M-Y",strtotime($deal['expiry_date']))) }}</td>
                        </tr>
                        <tr>
                            <td>Short Description</td>
                            <td>{!! empty($deal['short_description'])? null:($deal['short_description']) !!}</td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td>{!! empty($deal['description'])? null:($deal['description']) !!}</td>
                        </tr>
                        <tr>
                            <td>Price</td>
                            <td>${{ empty($deal['price'])? null:($deal['price']) }}</td>
                        </tr>
                        <tr>
                            <td>Promo Code</td>
                            <td>{{ empty($deal['promo_code'])? null:($deal['promo_code']) }}</td>
                        </tr>
                        <tr>
                            <td>How To Redeem</td>
                            <td>{!! empty($deal['how_to_redeem'])? null:($deal['how_to_redeem']) !!}</td>
                        </tr>

                    </tbody>
                </table>
            </div>
            @php
               $dealBusiness=dealBusinessDetails($deal->directory_id);
               //dd($dealBusiness);
            @endphp
            @foreach ($dealBusiness as $business)
                
            
            <div class="tile">
                <table class="table table-hover custom-data-table-style table-striped table-col-width" id="sampleTable">
                    <tbody>
                        <tr>
                            <td>Business Name</td>
                            <td>{{ $business->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Owner Name</td>
                            <td>{{ $business->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Email Id</td>
                            <td>{{ $business->email ??  '' }}</td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>{{ $business->mobile ??  '' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @endforeach
            @if(count($dealReview)>0)
            <div class="card">
                <div class="card-body">
                    <h3>Rating & Review</h3>
                    <div class="row">
                        @foreach($dealReview as $review)
                        <div class="col-lg-6">
                            <div class="posted_reviews">
                                <div class="single_review">
                                    <div class="review-top">
                                        <div class="deals_avatar">
                                            {!! dealreviewUserName($review->name) !!}
                                        </div>
                                        <div>
                                            <h4>{{$review->name}}</h4>
                                            <div class="stars">
                                                {!! directoryRatingHtml($review->rating) !!}
                                                <small>
                                                    {{-- <i class="fas fa-circle"></i> --}}
                                                    {{ date('j M, Y', strtotime($review->created_at)) }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <p>
                                        {{$review->comment}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="col-12 mt-3">
            <a class="btn btn-secondary" href="{{ route('admin.deal.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Back</a>
        </div>
    </div>
@endsection
