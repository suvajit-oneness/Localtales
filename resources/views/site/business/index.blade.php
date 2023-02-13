@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')


<style>
    .pagination {
        float: right;
    }
</style>
@php
$businesses = array();
foreach($businesses_datas as $business){
            $address = $business->address;

            $url = "https://maps.google.com/maps/api/geocode/json?address=".urlencode($address)."&key=AIzaSyDegpPMIh4JJgSPtZwE6cfTjXSQiSYOdc4";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $responseJson = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($responseJson);

            // echo "<pre>";
            // print_r($response);
            // die();
            if (count($response->results)>0) {
                
            
            $latitude = $response->results[0]->geometry->location->lat;
            $longitude = $response->results[0]->geometry->location->lng;

            $business->latitude = $latitude;
            $business->longitude = $longitude;
            }
            array_push($businesses,$business);
        }
@endphp
<section class="inner_banner" style="background: url({{asset('site/images/banner')}}-image.jpg) no-repeat center center; background-size:cover;">
	<div class="container position-relative">
			<h1>Local Directory</h1>
			<div class="page-search-block filterSearchBoxWraper">
                <div class="filterSearchBox">
                    <form action="">
                        <div class="row">
                            <div class="mb-2 mb-sm-0 col-6 col-sm-6 col-lg-4">
                                <div class="form-floating">
                                    <input id="postcodefloting" type="text" class="form-control pl-3" name="address" placeholder="Postcode/ State" value="{{ request()->input('address') }}" autocomplete="off">
                                    <label for="postcodefloting">Postcode/ State</label>
                                </div>
                                <div class="respDrop"></div>
                            </div>
                            <div class="mb-2 mb-sm-0 col-6 col-sm-6 col-lg-4 fcontrol position-relative filter_selectWrap filter_selectWrap2">
                                <div class="select-floating">
                                    <img src="{{ asset('front/img/grid.svg')}}">
                                    <label>Category</label>
                                    <select class="filter_select form-control" name="category_id">
                                        <option value="" hidden selected>Select Category...</option>
                                        @foreach ($categories as $index => $item)
                                            <option value="{{$item->id}}" {{ (request()->input('category_id') == $item->id) ? 'selected' : '' }}>{{ $item->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                             <div class="mb-2 mb-sm-0 col-6 col-sm-6 col-lg-4">
                                <div class="form-floating">
                                    <input type="text" id="keywordfloting" class="form-control pl-3" name="keyword" placeholder="Keyword" value="{{ request()->input('keyword') }}">
                                    <label for="keywordfloting">Keyword</label>
                                </div>
                            </div>
                            <!--<div class="mb-2 mb-sm-0 col-6 col-sm">-->
                            <!--    <div class="form-floating">-->
                            <!--        <input type="text" id="establishyearfloting" class="form-control pl-3" name="establish_year" placeholder="Establish Year" value="{{ request()->input('establish_year') }}">-->
                            <!--        <label for="establishyearfloting">Establish Year</label>-->
                            <!--    </div>-->
                            <!--</div>-->
                            <div class="col-5 col-sm">
                                <div class="form-floating">
                                    <input type="text" id="openhourfloting" class="form-control pl-3" name="opening_hour" placeholder="Opening Hour" value="{{ request()->input('opening_hour') }}">
                                    <label for="openhourfloting">Opening Hour</label>
                                </div>
                            </div>
                            <div class="col-5 col-sm fcontrol position-relative filter_selectWrap filter_selectWrap2">
                                <div class="select-floating">
                                    <img src="{{ asset('front/img/grid.svg')}}">
                                    <label>Sort by</label>
                                    <select class="filter_select form-control" name="sort">
                                        <option value="" hidden selected>Sort By...</option>
                                        <option value="time_asc" {{ (request()->input('sort') == "" || request()->input('sort') == "time_asc") ? 'selected' : '' }}>Oldest</option>
                                        <option value="time_desc" {{ (request()->input('sort') == "time_desc") ? 'selected' : '' }}>Newest</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-2 col-sm-auto">
                                <button class="btn btn-blue text-center ml-auto"><img src="{{asset('front/img/search.svg')}}"></button>
                            </div>
                        </div>
                        {{-- <a href="javascript:void(0);" id="btnFilter" class="btn btn-blue text-center ml-auto">Filter</a> --}}
                    </form>
                </div>

				{{-- <div class="col">
                    <div class="filter_btn">
                        <span>Apply Filter</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </div>
                </div>
                <div class="col-sm-auto">
                    <ul class="breadcumb_list">
                        <li><a href="{!! URL::to('') !!}">Home</a></li>
                        <li>/</li>
                        <li>Local Directory</li>
                    </ul>
                </div> --}}
			</div>
		</div>
	</div>
</section>



<section class="pb-4 pb-lg-5 searchpadding bg-light smallGapGrid">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-auto">
                <div class="best_deal page-title">
        			<h2> Directory </h2>
                </div>
            </div>
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
                        <li class="">
                            <a href="#map">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line></svg>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </div>

        <div id="tab-contents">
            <div class="tab-content smallGapGrid" id="grid">
                <div class="row Bestdeals">
                    {{-- <div class="swiper-wrapper"> --}}
                        @foreach($businesses as $key => $business)
                    {{-- dd{{ $dir}} --}}
                        <div class="col-6 col-md-4 col-lg-3 jQueryEqualHeight">
                            <div class="card directoryCard border-0">
                                <div class="bst_dimg">
                                   <img src="https://maps.googleapis.com/maps/api/streetview?size=640x640&location={{$business->latitude}},{{$business->longitude}}&fov=120&heading=0&key=AIzaSyDPuZ9AcP4PHUBgbUsT6PdCRUUkyczJ66I">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><a href="{!! URL::to('directory-details/'.$business->id.'/'.strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $business->name))) !!}" class="location_btn">{{ $business->name }}</a></h5>
                                    <p>{!! $business->address !!}</p>
                                    <input type="hidden" id="googlemapaddress" value="">
                                    {{-- <a href="#">Read More...</a> --}}

                                </div>
                            </div>
                        </div>

                    @endforeach



                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $businesses_datas->appends($_GET)->links() }}
                </div>
            </div>

            <div class="tab-content smallGapGrid Bestdeals" id="list">
                <div class="row">

                  <ul class="search_list_items search_list_items-mod">
                      @foreach($businesses as $key => $business)
                      <li>
                          <div class="location_img_wrap">
                             <img src="https://maps.googleapis.com/maps/api/streetview?size=640x640&location={{$business->latitude}},{{$business->longitude}}&fov=120&heading=0&key=AIzaSyDPuZ9AcP4PHUBgbUsT6PdCRUUkyczJ66I">
                          </div>
                          <div class="list_content_wrap">

                                <div class="location_meta">

                                    <figcaption>
                                        <div class="categoryB-list">
                                        @php
                                            if(!empty($business->category_id)) {
                                                $cat = substr($business->category_id, 0, -1);
                                                $displayCategoryName = '';
                                                foreach(explode(',', $cat) as $catKey => $catVal) {
                                                    $catDetails = \App\Models\DirectoryCategory::findOrFail($catVal);
                                                    $displayCategoryName .= '<a href="'.route("category.directory", $catDetails->id).'">'.$catDetails->title.'</a>, ';
                                                }
                                                echo substr($displayCategoryName, 0, -2);
                                            }
                                        @endphp
                                        </div>
                                        <h4 class="place_title bebasnew">{{$business->name}}</h4>
                                        {{-- <p>{{ $business->email }}</p> --}}
                                    </figcaption>
                                    <p class="history_details">{!!strip_tags(substr($business->description,0,300))!!}</p>
                                    <div class="d-flex location_details mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                                        <a href="#" class="history_details">{{$business->website}}</a>
                                    </div>
                                    <div class="d-flex location_details">
                                        <span><i class="fas fa-tag"></i></span>
                                        <p class="location mb-0">{{$business->category_tree}}</p>
                                    </div>
                                    <div class="d-flex location_details">
                                        <span><i class="fas fa-map-marker-alt"></i></span>
                                        <p class="location mb-0">{{$business->address}}</p>
                                    </div>
                                    <input type="hidden" id="googlemapaddress" value="{{ $business->address }}">
                                </div>
                                <div class="location_metaBOttom">
                                    <ul class="bBusinessMailPhone">
                                        <li><a href="#"><i class="fas fa-phone-alt"></i>{{$business->mobile}}</a></li>
                                    </ul>
                                    <a href="{!! URL::to('directory-details/'.$business->id.'/'.strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $business->name))) !!}" class="location_btn">View Details <img src="{{asset('site/images/right-arrow.png')}}"></a>
                                </div>

                          </div>
                      </li>
                      @endforeach

                  </ul>
                    <div class="col-12">
                        <div class="d-flex justify-content-center mt-4">
                            {{ $businesses_datas->appends($_GET)->links() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-content smallGapGrid Bestdeals" id="map">
                <div class="row justify-content-center">
                    <div class="col-12">

                    </div>
                    <div class="col-12">
                        <div class="map">
                            <div id="mapShow" style="height: 600px;"></div>
                            <span id="latLngShow"></span>
                            <input type="hidden" id="googlemapaddress" value="">
                        </div>
                    </div>
                </div>
            </div>

        </section>
<!--Search-list-->





</section>

@endsection
@push('scripts')

<script src="https://maps.google.com/maps/api/js?key=AIzaSyDegpPMIh4JJgSPtZwE6cfTjXSQiSYOdc4" type="text/javascript"></script>
<script type="text/javascript">
	@php
	$locations = array();
	foreach($businesses as $business){
	    /*if($business->image == 'placeholder-image.png'){
	        $img = "https://demo91.co.in/localtales-prelaunch/public/Directory/".$business->image;
	    }else{
	        $img = $business->image;
	    }*/
	    $img = "https://maps.googleapis.com/maps/api/streetview?size=640x640&location=".$business->latitude.",".$business->longitude."&fov=120&heading=0&key=AIzaSyDegpPMIh4JJgSPtZwE6cfTjXSQiSYOdc4";

	    $page_link = URL::to('directory-details/'.$business->id.'/'.strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $business->name)));

		$data = array($business->name,floatval($business->latitude),floatval($business->longitude),$business->address,$img,$page_link);
		array_push($locations,$data);
	}
	@endphp
	var locations = <?php echo json_encode($locations); ?>;
	console.log("businessLocations>>"+JSON.stringify(locations));

    console.log(JSON.stringify(locations));

    var map = new google.maps.Map(document.getElementById('mapShow'), {
      zoom: 8,
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
    // '<div id="content">' +
    // '<div id="siteNotice">' +
    // "</div>" +
    // '<img src="'+locations[i][4]+'" width=""><br/>' +
    // '<a href="'+locations[i][5]+'" target="_blank"><h6 id="firstHeading" class="firstHeading">'+locations[i][0]+'</h6></a>' +
    // '<div id="bodyContent"><p>' +locations[i][3]+'</p></div>' +
    //  '<a href="'+locations[i][5]+'" target="_blank" class="directionBtn"><i class="fas fa-directions"></i></a>' +
    // '</div>';
     '<div id="content">' +
    '<div id="siteNotice">' +
    "</div>" +
    '<img src="'+locations[i][4]+'" width="">' +

    '<div class="mapPopContent"><div id="bodyContent"><a href="'+locations[i][5]+'" target="_blank"><h6 id="firstHeading" class="firstHeading mb-2">'+locations[i][0]+'</h6></a>' +
    '<p>' +locations[i][3]+'</p></div>' +

     '<a href="'+locations[i][5]+'" target="_blank" class="directionBtn"><i class="fas fa-link"></i></a>' +
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
  </script>

    <script>
        // state, suburb, postcode data fetch
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
                            content += `<div class="dropdown-menu show w-100 postcode-dropdown" aria-labelledby="dropdownMenuButton">`;

                            $.each(result.data, (key, value) => {
                                content += `<a class="dropdown-item" href="javascript: void(0)" onclick="fetchCode(${value.pin})">${value.state}, ${value.suburb}, ${value.pin}</a>`;
                            })
                            content += `</div>`;
                            // $($this).parent().after(content);
                        } else {
                            content += `<div class="dropdown-menu show w-100 postcode-dropdown" aria-labelledby="dropdownMenuButton"><li class="dropdown-item">${result.message}</li></div>`;
                        }
                        $('.respDrop').html(content);
                    }
                });
            } else {
                $('.respDrop').text('');
            }
        });

        function fetchCode(code) {
            $('.postcode-dropdown').hide()
            $('input[name="address"]').val(code)
        }
    </script>
@endpush
