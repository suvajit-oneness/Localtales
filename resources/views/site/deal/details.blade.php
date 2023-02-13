@extends('site.app')
@section('title') {{ $deal->title }} @endsection
@section('content')
<style type="text/css">
	.swiper {
		width: 50%;
		height: 100%;
	}

	.swiper-slide {
		text-align: center;
		font-size: 18px;
		background: #fff;

		/* Center slide text vertically */
		display: -webkit-box;
		display: -ms-flexbox;
		display: -webkit-flex;
		display: flex;
		-webkit-box-pack: center;
		-ms-flex-pack: center;
		-webkit-justify-content: center;
		justify-content: center;
		-webkit-box-align: center;
		-ms-flex-align: center;
		-webkit-align-items: center;
		align-items: center;
	}

	.swiper-slide img {
		display: block;
		width: 70%;
		object-fit: cover;
	}

	.swiper {
		margin-left: initial !important;
	}
	.thumbnail-icon {
		max-width: 20px;
		margin-right: 10px;
	}
	.swiper-button-prev,
	.swiper-button-next {
		z-index: 100000;
		min-width: 30px!important;
		height: 30px!important;

		background: #111!important;
		border-radius: 50px;
		color: #fff!important;
	}
	.swiper-button-next::after,
	.swiper-button-prev::after {
		font-size: 12px!important;
	}
</style>
<!-- <section class="breadcumb_wrap">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<ul class="breadcumb_list">
					<li><a href="{!! URL::to('') !!}">Home</a></li>
					<li><img src="{{asset('site/images/down-arrow.png')}}"></li>
					<li><a href="{!! URL::to('deal-list') !!}">Deals</a></li>
					<li><img src="{{asset('site/images/down-arrow.png')}}"></li>
					<li>Deal Details</li>
				</ul>
			</div>
		</div>
	</div>
</section> --> <!--Breadcumb-->


<section class="details_banner">
	<figure>
		<img src="{{URL::to('/').'/uploads/deals/'}}{{$deal->image}}">
	</figure>
	<figcaption>
		<div class="container">
			<div class="details_info">
				<ul class="breadcumb_list">
					<li><a href="{!! URL::to('') !!}">Home</a></li>
					<li>/</li>
					<li><a href="{!! URL::to('deals') !!}">Deals</a></li>
					<li>/</li>
					<li>{{$deal->title}}</li>
				</ul>
					<div class="deal_header d-flex align-items-center justify-content-between">
						<h1 class="details_banner_heading">{{$deal->title}}</h1>

						<div class="col-auto align-self-center">
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
			</div>

			<div class="banner_meta_area new_banner_meta_area">
				<div class="row justify-content-between">
					<div class="banner_meta_item col-lg-2 col-md-4 col-sm-6 mb-3 mb-lg-0">
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
							<a href="{!! URL::to('category/' . $deal->category->parent_category_slug) !!}"><p>{{$deal->category->parent_category}}</p></a>
						</figcaption>
					</div>
					<div class="banner_meta_item col-lg-2 col-md-4 col-sm-6 mb-3 mb-lg-0">
						<figure>
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
						</figure>
						<figcaption>
							<h5>Address</h5>
							<p>{{$deal->full_address}}</p>
						</figcaption>
					</div>
					<div class="banner_meta_item col-lg-2 col-md-4 col-sm-6 mb-3 mb-lg-0">
						<figure>
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
						</figure>
						<figcaption>
							<h5>Price</h5>
							<p>$ {{$deal->price}}</p>
						</figcaption>
					</div>
					<div class="banner_meta_item col-lg-2 col-md-4 col-sm-6 mb-3 mb-lg-0">
						<figure>
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
						</figure>
						<figcaption>
							<h5>Promo Code</h5>
							<p>{{$deal->promo_code}}</p>
						</figcaption>
					</div>
					<div class="banner_meta_item col-lg-2 col-md-4 col-sm-6 mb-3 mb-lg-0">
						<figure>
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
						</figure>
						<figcaption>
							<h5>Expired</h5>
							<p>{{date("d-M-Y",strtotime($deal->expiry_date))}}</p>
						</figcaption>
					</div>
				</div>
			</div>
		</div>
	</figcaption>
</section>

<section class="letest-offer">
	<div class="container">
		<?php /* ?>
		<div class="row m-0 mt-5 mb-5">
			<div class="col-12 col-md-6 bg-bipblue p-4">
				<ul class="detail-evtext">
					<li>
						<p class="w-100 catagoris_ev">
							<span><img src="{{URL::to('/').'/categories/'}}{{$deal->category->image}}" class="mr-2"> {{$deal->category->title}}</span>
							<span class="float-right w-142">
								<small class="d-block">Expires : {{date("d-M-Y",strtotime($deal->expiry_date))}} </small>

							</span>
						</p>
						<a href="#"><h1>{{$deal->title}}</h1></a>
						<h6>Address</h6>
						<p class="text-white">
							Address : {{$deal->address}}<br>
							Price : $ {{$deal->price}} <br>
							Promo Code : {{$deal->promo_code}}
						</p>
					<li>
				</ul>
			</div>
			<div class="col-12 col-md-6 p-0 image-part" style="background:url({{URL::to('/').'/deals/'}}{{$deal->image}});">
				<!-- <a href="javascript:void(0);" class="all_pic shadow-lg">View All 3 Images</a> -->
			</div>
		</div>
		<?php */ ?>

		<div class="row flex-sm-row-reverse mt-4 mb-5 justify-content-center align-items-start">
			<div class="col-md-6 mb-3 mb-sm-0">
				<div class="swiper mySwiper w-100">
					<div class="swiper-wrapper">
						@if ($deal->image1)
							<div class="swiper-slide">
								<img src="{{ URL::to('/') . '/uploads/deals/' }}{{ $deal->image1 }}" width="200px">
							</div>
						@endif

						@if ($deal->image2)
							<div class="swiper-slide">
								<img src="{{ URL::to('/') . '/uploads/deals/' }}{{ $deal->image2 }}" width="200px">
							</div>
						@endif

						@if ($deal->image3)
						<div class="swiper-slide">
							<img src="{{ URL::to('/') . '/uploads/deals/' }}{{ $deal->image3 }}" width="200px">
						</div>
						@endif
					</div>

					<div class="swiper-button-next"></div>
					<div class="swiper-button-prev"></div>
				</div>
			</div>

			<div class="col-md-6 details_left">
				<?php /*
				<!-- <div class="price-deat">
					<h1>$ 200<span>Inc. of all taxes<span></h1>
				</div> -->
				<!-- @if($dealSaved==1)
				<a href="{!! URL::to('site-delete-user-deal/'.$deal->id) !!}" class="btn btn-blue text-center">Remove</a>
				@else
				<a href="{!! URL::to('site-save-user-deal/'.$deal->id) !!}" class="btn btn-blue text-center">Save Deal</a>
				@endif -->
				*/ ?>
				<ul class="nav nav-tabs details_tabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#deals" role="tab"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg> <span>Highlight</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#about" role="tab"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg> <span>Description</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#photos" role="tab"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tag" style="max-width: 18px;flex: 0 0 100%;"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg> <span>How To Redeem</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#reviews" role="tab">
							<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
							<span>Reviews</span></a>
					</li>
					{{-- <li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#images" role="tab"><img src="{{ URL::to('/') . '/uploads/events/thumbnail.png'}}" class="thumbnail-icon"><span>Image gallery</span></a>
					</li> --}}
				</ul>
				<div class="tab-content deal__details">
					<div class="tab-pane active" id="deals" role="tabpanel">
						<div class="verified-reviews">
							{!!$deal->short_description!!}
						</div>
					</div>
					<div class="tab-pane" id="about" role="tabpanel">
						{!!$deal->description!!}
					</div>
					<div class="tab-pane" id="photos" role="tabpanel">
						{!!$deal->how_to_redeem!!}
					</div>
					<div class="tab-pane" id="reviews" role="tabpanel">
						<div class="row justify-content-between">
							<div class="col-auto">
								<div class="dealsRating">
									<span>{{ getReviewDetails($deal->id)['average_star_count'] }}</span>
									<div>
										{!! dealRatingHtml(getReviewDetails($deal->id)['average_star_count']) !!}
										@if(getReviewDetails($deal->id)['total_reviews'] > 0)
											@if(getReviewDetails($deal->id)['total_reviews'] == 1)
												<small>{{ getReviewDetails($deal->id)['total_reviews'] }} Review</small>
											@else
												<small>{{ getReviewDetails($deal->id)['total_reviews'] }} Reviews</small>
											@endif
										@endif
									</div>
								</div>
							</div>
						</div>
						@if(getReviewDetails($deal->id)['total_reviews'] > 0)
						<div class="verified-reviews">
							<svg viewBox="0 0 45 43" xmlns="http://www.w3.org/2000/svg" focusable="false" role="img" aria-labelledby="verified-template" class="verified-badge-svg">
								<g fill="none" fill-rule="evenodd">
									<path d="M45 21.25c0 2.257-2.895 4.035-3.565 6.072-.694 2.11.564 5.224-.731 6.98-1.31 1.776-4.707 1.55-6.505 2.841-1.78 1.279-2.606 4.545-4.744 5.23-2.064.661-4.668-1.48-6.955-1.48s-4.89 2.141-6.955 1.48c-2.138-.685-2.964-3.951-4.744-5.23-1.798-1.291-5.196-1.065-6.505-2.84-1.295-1.757-.037-4.87-.731-6.98C2.895 25.284 0 23.506 0 21.25c0-2.257 2.895-4.035 3.565-6.072.694-2.11-.564-5.224.731-6.98 1.31-1.776 4.707-1.55 6.505-2.841 1.78-1.279 2.606-4.545 4.744-5.23 2.064-.661 4.668 1.48 6.955 1.48s4.89-2.141 6.955-1.48c2.138.685 2.964 3.951 4.744 5.23 1.798 1.291 5.196 1.065 6.505 2.84 1.295 1.757.037 4.87.731 6.98.67 2.038 3.565 3.816 3.565 6.073"></path>
									<path d="M18.346 30.29a1.417 1.417 0 0 1-1.08-.412l-4.848-5.575a1.432 1.432 0 0 1 0-2.022 1.424 1.424 0 0 1 2.017 0l3.976 4.571L30.816 14.42a1.424 1.424 0 0 1 2.016 0 1.433 1.433 0 0 1 0 2.022L19.426 29.878a1.413 1.413 0 0 1-1.08.412z" class="checkmark"></path>
								</g>
							</svg>

							<div class="verified-badge-content">
								<h6>
									100% Verified Reviews
								</h6>
								{{-- <p>
									All Deal reviews are from people who have redeemed deals with this merchant. Review requests are sent by email to customers who purchased the deal.
								</p> --}}
							</div>

						</div>
						@endif
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
							{{-- <div class="col-lg-6">
								<div class="posted_reviews">
									<div class="single_review">
										<div class="review-top">
											<div class="deals_avatar">
												SB
											</div>
											<div>
												<h4>Suvajit Bardhan</h4>
												<div class="stars">
													<i class="fas fa-star"></i>
													<i class="fas fa-star"></i>
													<i class="fas fa-star"></i>
													<i class="fas fa-star"></i>
													<i class="far fa-star"></i>
													<small>
														<i class="fas fa-circle"></i>
														4 Hours ago
													</small>
												</div>
											</div>
										</div>
										<p>
											Lorem ipsum dolor sit, amet consectetur adipisicing elit.
											Ipsa repellat eveniet repellendus atque ullam necessitatibus
											rem voluptates dolore odit corporis.
										</p>
									</div>
								</div>
							</div> --}}
						</div>

						<form method="post" action="{{route('deal.review')}}" id="dealForm">@csrf
							<input type="hidden" name="deal_id" id="selectedLongitude" value="{{$deal->id}}">
							<div class="reviwbox mt-4">
								<div class="row">
									<h2 class="col-12 mb-3">Review</h2>
									<div class="form-group col-md-6">
										<label for="Name">Name:</label>
										<input type="text" class="form-control" name="name" id="name" @if(Auth::check())value="{{Auth::guard('user')->user()->name }}"@endif>

									</div>
									<div class="form-group col-md-6">
										<label for="email">Email:</label>
										<input type="text" class="form-control" name="email" id="email" @if(Auth::check())value="{{Auth::guard('user')->user()->email}}"@endif>

									</div>
									<div class="form-group col-md-12">
										<label for="comment">Comment:</label>
										<textarea type="text" class="form-control" name="comment" id="comment"></textarea>

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
										<button type="submit" class="btn btn-primary reviewBtn" dealBtn>Save changes</button>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane" id="images" role="tabpanel">
						<div class="swiper mySwiper">
							<div class="swiper-wrapper">
								@if ($deal->image1)
									<div class="swiper-slide">
										<img src="{{ URL::to('/') . '/uploads/deals/' }}{{ $deal->image1 }}" width="200px">
									</div>
								@endif

								@if ($deal->image2)
									<div class="swiper-slide">
										<img src="{{ URL::to('/') . '/uploads/deals/' }}{{ $deal->image2 }}" width="200px">
									</div>
								@endif

								@if ($deal->image3)
								<div class="swiper-slide">
									<img src="{{ URL::to('/') . '/uploads/deals/' }}{{ $deal->image3 }}" width="200px">
								</div>
								@endif
							</div>

							<div class="swiper-button-next"></div>
							<div class="swiper-button-prev"></div>
						</div>
					</div>
				</div>
			</div>

				<!-- <div class="mt-4 text-right">
					<a href="javascript:void(0);" class="orange-btm load_btn" id="load-more2">DETAILS</a>
					<a href="javascript:void(0);" class="blue-btn load_btn" id="load-more2">+ Add</a>
				</div> -->
			{{-- <div class="col-md-6 details_left">
				<div class="directory-map">
					<div id="mapShow" style="width: 100%; height: 400px;"></div>
				</div>
			</div> --}}
			<!-- <div class="col-md-4 p-0 details_right">
				<div class="card position-relative">
					<div class="card-header text-center border-0 bg-bipblue text-white">
						<h4>Your Bookings</h4>
					</div>
					<div class="card-body p-0">
						<div class="bg-light p-3 text-center">
							<h5>Please add an option <span class="d-block">Your order is empty</span></h5>
						</div>
						<div class="p-3">
							<h4><span>Total</span> : $0</h4>
						</div>
					</div>
					<div class="card-footer border-0 p-0">
						<a href="javascript:void(0);" class="orange-btm load_btn" id="load-more2">BOOK NOW</a>
					</div>
				</div>
			</div> -->
		</div>
	</div>
</section>
@endsection
@push('scripts')
<script src="https://maps.google.com/maps/api/js?key=AIzaSyDPuZ9AcP4PHUBgbUsT6PdCRUUkyczJ66I" type="text/javascript"></script>
<script async src="https://static.addtoany.com/menu/page.js"></script>
<script>
	$(document).on('submit', '#dealForm', (event) => {
		   event.preventDefault();

		   const cartSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>';

		   $.ajax({
			   url: "{{ route('add.deal.ajax') }}",
			   type: "POST",
			   data: {
				   _token: "{{csrf_token()}}",
				   name: $('#dealForm input[name="name"]').val(),
				   email: $('#dealForm input[name="email"]').val(),
				   deal_id: $('#dealForm input[name="deal_id"]').val(),
				   rating: $('#dealForm input[name="rating"]:checked').val(),
				   comment: $('#dealForm textarea[name="comment"]').val(),
			   },
			   beforeSend: function() {
				   $('.dealBtn').attr('disabled', true).html(cartSvg+' Adding....');
			   },
			   success: function(result) {
				   if (result.error === false) {
					   $('.minidealBtn').html(cartSvg+'<span class="badge badge-danger">'+result.count+'</span>');
					   toastFire('success', result.message);
				   } else {
					   toastFire('warning', result.message);
				   }
				   $('.dealBtn').attr('disabled', false).html(cartSvg+' Review added');
			   }
		   });
	   });
</script>

<script type="text/javascript">
	@php
	$locations = array();
	$data = array($deal->title,floatval($deal->lat),floatval($deal->lon));
	array_push($locations,$data);
	@endphp
	var locations = <?php echo json_encode($locations); ?>;
	console.log("dealLocations>>"+JSON.stringify(locations));

    console.log(JSON.stringify(locations));

    var map = new google.maps.Map(document.getElementById('mapShow'), {
      zoom: 16,
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

    var iconBase = 'http://cp-33.hostgator.tempwebhost.net/~a1627unp/dev/localtales_v2/public/site/images/';

    for (i = 0; i < locations.length; i++) {
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map,
        icon: iconBase + 'map_icon.png'
      });

      google.maps.deal.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
  </script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    </script>
@endpush
