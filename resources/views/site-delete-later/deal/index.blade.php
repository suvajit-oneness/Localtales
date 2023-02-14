@extends('site.app')
@section('title'){{seoManagement('deal')->title}}@endsection
@section('description'){{seoManagement('deal')->meta_desc}}@endsection
@section('content')
<!-- <style type="text/css">
#mapShow
{
    filter: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg"><filter id="g"><feColorMatrix type="matrix" values="0.3 0.3 0.3 0 0 0.3 0.3 0.3 0 0 0.3 0.3 0.3 0 0 0 0 0 1 0"/></filter></svg>#g');
    -webkit-filter: grayscale(100%);
    filter: grayscale(100%);
    filter: progid:DXImageTransform.Microsoft.BasicImage(grayScale=1);
}
</style> -->

<section class="inner_banner" style="background: url({{asset('site/images/banner')}}-image.jpg) no-repeat center center; background-size:cover;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 mb-4">
                <h1>Local Deals</h1>
            </div>
            <div class="col-12 col-lg-12">
                <div class="page-search-block filterSearchBoxWraper">
                    <div class="filterSearchBox">
                        <form action="">
                            <div class="row">
                                <div class="col-6 mb-2 mb-sm-0 col-md fcontrol position-relative filter_selectWrap">
                                    <div class="form-floating">
                                        <input id="postcodefloting" type="text" class="form-control pl-3" name="key_details" placeholder="Postcode/ State" value="{{ request()->input('key_details') }}" autocomplete="off">
                                        <input type="hidden" name="keyword" value="{{ request()->input('keyword') }}">
                                        <label for="postcodefloting">Suburb or Postcode</label>
                                    </div>
                                    <div class="respData"></div>
                                </div>
                                 {{-- <div class="col-6 col-sm fcontrol position-relative filter_selectWrap filter_selectWrap2 mb-2 mb-sm-0">
                                    <div class="select-floating">
                                        <img src="{{ asset('front/img/grid.svg')}}">
                                        <label>Category</label>
                                        <select class="filter_select form-control" name="category_id">
                                            <option value="" hidden selected>Select Category...</option>
                                        </select>
                                    </div>
                                </div>--}}
                                <div class="col-6 mb-2 mb-sm-0 col-md fcontrol position-relative filter_selectWrap">
                                    <div class="dropdown">
                                        <div class="form-floating drop-togg" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <input id="categoryfloting" type="text" class="form-control pl-3" name="directory_category" placeholder="Category" value="{{ request()->input('directory_category') }}" autocomplete="off">
                                            <input type="hidden" name="code" value="{{ request()->input('code') }}">
                                            <input type="hidden" name="type" value="{{ request()->input('type') }}">
                                            <label for="categoryfloting">Category</label>
                                        </div>
                                        <div class="respDrop"></div>
                                    </div>
                                </div>
                                <div class="col col-md fcontrol position-relative filter_selectWrap">
                                    <div class="form-floating">
                                        <input type="text" id="keywordfloting" class="form-control pl-3" name="name" placeholder="Keyword" value="{{ request()->input('name') }}">
                                        <label for="keywordfloting">Keyword</label>
                                    </div>
                                </div>
								<div class="col col-md fcontrol position-relative filter_selectWrap">
									{{-- <label for="keywordfloting">Expiry</label> --}}
                                    <div class="form-floating">
                                        <input type="text" name="expiry_date" id="datepicker" placeholder="Expiry Date" class="form-control pl-3" value="{{ request()->input('expiry_date') }}">
                                        <label for="expiry_date">{{ request()->input('expiry_date') ? date('d-m-Y', strtotime(request()->input('expiry_date'))) : 'Expiry Date' }}</label>
                                    </div>
                                </div>

                                <div class="col-auto col-sm-auto">
                                    <button class="btn btn-blue text-center ml-auto"><img src="{{asset('front/img/search.svg')}}"></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- displaying directories --}}
<section class="pb-4 pb-lg-5 searchpadding bg-light smallGapGrid">
    <div class="container">
        <ul class="breadcumb_list mb-4">
            <li><a href="{!! URL::to('/') !!}">Home</a></li>
            <li>/</li>
            @if (!empty(request()->input('code'))|| !empty(request()->input('keyword'))|| !empty(request()->input('name')))
                @if ($deals->count() > 0)
                  <li class="active">Deals</li>
                @else
                   <li class=""><a href="{!! URL::to('/deals') !!}">Deals</a></li>
                   <li>/</li>
                   <li class="active">No Deals found</li>
                @endif
            @else
                <li class="active">Deals</li>
            @endif
        </ul>

        <div class="row justify-content-between">
            <div class="col-auto">
                <div class="best_deal page-title">
                    @if (!empty(request()->input('code'))|| !empty(request()->input('keyword'))|| !empty(request()->input('name')))
                        @if ($deals->count() > 0)
                            <h2 class="mb-2 mb-sm-3">Deals found </h2>
                        @else
                            <h2 class="mb-2 mb-sm-3">No Deals found  </h2>

                            <p class="mb-2 mb-sm-3 text-muted">Please try again with different Category or Keyword</p>
                        @endif
                    @else
                        @if (count($deals) > 0)
                            <h2></h2>
                        @else
                            <h2>No Deals found</h2>
                        @endif
                    @endif
                </div>
            </div>
            @if (count($deals) > 0)
            <div class="col-auto">
                <div class="d-flex cafe-listing-nav">
                    <ul class="d-flex" id="tabs-nav">
                       <li class="">
                            <a href="#grid">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                            </a>
                        </li>
                        <li class="">
                            <a href="#list">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                            </a>
                        </li>
                        {{-- <li class="">
                            <a href="#map">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line></svg>
                            </a>
                        </li> --}}
                    </ul>
                </div>
            </div>
            @endif
        </div>
		<div id="tab-contents" class="deals_section">
            {{-- grid view --}}
            <div class="tab-content smallGapGrid" id="grid">
				<div class="row">
					@foreach($deals as $key => $deal)
					<div class="col-12 col-md-6 col-lg-4 mb-3 mb-lg-4">
						<div class="card directoryCard directory_block border-0 v3card">
							<div class="card-body">
								<div class="location_img_wrap-event">
									@if($deal->image!='')<a class="d-block" href="{!! URL::to('deals/'.$deal->slug) !!}"><img src="{{URL::to('/').'/uploads/deals/'}}{{$deal->image}}"></a>@endif
								</div>
								<div class="list_content_wrap row m-0">
									<div class="col-12 p-0">

										<div class="location_meta">
											<figcaption>
												<a href="{!! URL::to('deals/'.$deal->slug) !!}"><h4 class="place_title bebasnew">{{$deal->title}}</h4></a>
												<p style="text-transform: capitalize!important;">{!! dealCategory($deal->category_id) !!}</p>
											</figcaption>
										</div>
								    </div>
							    </div>
								<p class="history_details">{!!strip_tags(substr($deal->short_description,0,500))!!}...</p>
								<div class="location_meta">
									<div class="location_details">
										<span><i class="fas fa-map-marker-alt"></i></span>
										<p class="location">{{$deal->full_address}}</p>
									</div>
									<a href="{!! URL::to('deals/'.$deal->slug) !!}" class="location_btn">View Details <img src="{{asset('site/images/right-arrow.png')}}"></a>
								</div>

							</div>
						</div>
					</div>
					@endforeach
				</div>
				<div class="col-12">
					<div class="d-flex justify-content-center mt-4">
						{{ $deals->appends($_GET)->links() }}
					</div>
				</div>
			</div>
            <div class="tab-content smallGapGrid Bestdeals list__deals" id="list">
                <div class="row">
                    <ul class="search_list_items search_list_items-mod v3_list_view pre_event">
                        @foreach($deals as $key => $deal)
                            <li class="directory_listblock">
                                <div class="location_img_wrap">
                                    @if($deal->image!='')<a class="d-block" href="{!! URL::to('deals/'.$deal->slug) !!}"><img src="{{URL::to('/').'/uploads/deals/'}}{{$deal->image}}"></a>@endif
                                </div>
                                <div class="list_content_wrap grid-deal row m-0">
                                    <div class="location_meta">
                                        <div class="location_details">
                                            <span><i class="fas fa-map-marker-alt"></i></span>
                                            <p class="location">{{$deal->full_address}}</p>
                                        </div>
                                        <figcaption>
                                            <a href="{!! URL::to('deals/'.$deal->slug) !!}"><h4 class="place_title bebasnew">{{$deal->title}}</h4></a>
                                            <p style="text-transform: capitalize!important;">{!! dealCategory($deal->category_id) !!}</p>
                                        </figcaption>
                                    </div>
                                    <p class="history_details">{!!strip_tags(substr($deal->short_description,0,500))!!}...</p>
                                    <a href="{!! URL::to('deals/'.$deal->slug) !!}" class="location_btn">View Details <img src="{{asset('site/images/right-arrow.png')}}"></a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <!-- <a href="#" class="orange-btm load_btn">View All</a> -->
                    <div class="col-12">
                        <div class="d-flex justify-content-center mt-4">
                            {{ $deals->appends($_GET)->links() }}
                        </div>
                    </div>
                </div>
                {{-- <div class="tab-pane fade" id="map" role="tabpanel" aria-labelledby="map-tab">
                    <div class="directory-map">
                        <div id="mapShow" style="width: 100%; height: 600px;"></div>
                    </div>
                </div> --}}
			</div>
		</div>
	</div>
</section>
<!--Search-list-->
@if (!empty(request()->input('keyword')))
@if ($deals->count() == 0)
   @if(count($resp)>0)
        <section class="py-2 py-sm-4 py-lg-5 ">
            <div class="container">
                <div class="page-title best_deal">
                    <h2>Deals closeby</h2>
                </div>
                <div>
                    <div class="">
                        <div class="row">
                            @foreach($resp as $key => $deal)
                            {{-- {{dd($deal)}} --}}
                            <div class="col-12 col-md-6 col-lg-4 mb-3 mb-lg-4">
                                <div class="card h-100 directoryCard directory_block border-0 v3card">
                                    <div class="card-body">
                                        <div class="location_img_wrap-event">
                                            @if($deal['image']!='')<a class="d-block" href="{!! URL::to('deals/'.$deal['slug']) !!}"><img src="{{URL::to('/').'/uploads/deals/'}}{{$deal['image']}}"></a>@endif
                                        </div>
                                        <div class="list_content_wrap row m-0">
                                            <div class="col-12 p-0">

                                                <div class="location_meta">
                                                    <figcaption>
                                                        <a href="{!! URL::to('deals/'.$deal['slug']) !!}"><h4 class="place_title bebasnew">{{$deal['title']}}</h4></a>
                                                        @foreach($deal['category'] as $key => $cat)
                                                        <p style="text-transform: capitalize!important;">{{$cat['child_category']}}</p>
                                                        @endforeach
                                                    </figcaption>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="history_details">{!!strip_tags(substr($deal['short_description'],0,500))!!}...</p>
                                        <div class="location_meta">
                                            <div class="location_details">
                                                <span><i class="fas fa-map-marker-alt"></i></span>
                                                <p class="location">{{$deal['full_address']}}</p>
                                            </div>
                                            <a href="{!! URL::to('deals/'.$deal['slug']) !!}" class="location_btn">View Details <img src="{{asset('site/images/right-arrow.png')}}"></a>
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
    @else
    <section class="py-2 py-sm-4 py-lg-5 smallGapGrid">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-auto">
                    <div class="best_deal page-title">
                        <h2>Deals closeby</h2>
                        <p class="mb-2 mb-sm-3">No closeby deals found  </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
@endif
@endif
@endsection
@push('scripts')
<script src="https://maps.google.com/maps/api/js?key=AIzaSyDPuZ9AcP4PHUBgbUsT6PdCRUUkyczJ66I" type="text/javascript"></script>
<script type="text/javascript">
	@php
	$locations = array();
	foreach($deals as $deal){
		$data = array($deal->title,floatval($deal->lat),floatval($deal->lon));
		array_push($locations,$data);
	}
	@endphp
	var locations = <?php echo json_encode($locations); ?>;
	console.log("dealLocations>>"+JSON.stringify(locations));

    console.log(JSON.stringify(locations));

    if(locations.length>0){
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

	      google.maps.event.addListener(marker, 'click', (function(marker, i) {
	        return function() {
	          infowindow.setContent(locations[i][0]);
	          infowindow.open(map, marker);
	        }
	      })(marker, i));
	    }
	}

    $(document).ready(function(){
    	$('#btnFilter').on("click",function(){
    		$('#checkout-form').submit();
    	})
    })
  </script>
  <script>
        $('body').on('click', function() {
            //code
            $('.postcode-dropdown').hide();
        });

        // state, suburb, postcode data fetch
        $('input[name="key_details"]').on('keyup', function() {
            var $this = 'input[name="key_details"]'
            $('input[name="keyword"]').val($($this).val())

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
                            	if(value.type == 'pin') {
                                    content += `<a class="dropdown-item" href="javascript: void(0)" onclick="fetchdata(${value.pin}, '${value.pin}', '${value.type}')"><strong>${value.pin}</strong></a>`;
                            	} else if(value.type == 'suburb') {
                            		content += `<a class="dropdown-item" href="javascript: void(0)" onclick="fetchdata('${value.suburb}', '${value.suburb}, ${value.short_state} ${value.pin}', '${value.type}')"><strong>${value.suburb}</strong>, ${value.pin}, ${value.short_state} </a>`;
                                } else {
                                    content += ``;
                                }
                            })

                           /* if(result.data.length == 1) {
                                content = '';
                            }*/

                            content += `</div>`;
                        } else {
                            content += `<div class="dropdown-menu show w-100 postcode-dropdown" aria-labelledby="dropdownMenuButton"><li class="dropdown-item">${result.message}</li></div>`;
                        }
                        $('.respData').html(content);
                    }
                });
            } else {
                $('.respData').text('');
            }
        });

        function fetchdata(keyword, details, type) {
            $('.postcode-dropdown').hide()
            $('input[name="keyword"]').val(keyword)
            $('input[name="key_details"]').val(details)
        }
        $('body').on('click', function() {
            //code
            $('.category-dropdown').hide();
        });


        $('input[name="directory_category"]').on('click', function() {
            var content = '';

            @php
                $primaryCat = \DB::table('directory_categories')->where('type', 1)->where('status', 1)->limit(5)->get();
            @endphp

            content += `<div class="dropdown-menu show w-100 category-dropdown">`;

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
                            content += `<div class="dropdown-menu show w-100 category-dropdown">`;

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


                            })
                            content += `</div>`;

                        } else {
                            content +=
                                `<div class="dropdown-menu show w-100 category-dropdown" aria-labelledby="dropdownMenuButton"><li class="dropdown-item">${result.message}</li></div>`;
                        }
                        $('.respDrop').html(content);
                    }
                });
            } else {
                $('.respDrop').text('');
            }
        });

        function fetchCode(item, code, type) {
            $('.category-dropdown').hide()
            $('input[name="directory_category"]').val(item)
            $('input[name="code"]').val(code)
            $('input[name="type"]').val(type)
        }
        $(document).on("click", "#btnFilter", function() {
            $('#checkout-form').submit();
        });
    </script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
    $( function() {
        $( "#datepicker" ).datepicker();
    } );
  </script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endpush
