@extends('site.app')

@section('title'){{seoManagement('directory')->title}}@endsection
@section('description'){{seoManagement('directory')->meta_desc}}@endsection


@php
    $directories = array();

    foreach($directoryList as $business){
        $directoryLattitude = $business->lat ? $business->lat : '';
        $directoryLongitude = $business->lon ? $business->lon : '';
        $address = $business->address;

        if (!empty($directoryLattitude) || !empty($directoryLongitude) ) {
            $url = "https://maps.google.com/maps/api/geocode/json?address=".urlencode($address)."&key=";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $responseJson = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($responseJson);

            if (count($response->results)>0) {
                $latitude = $response->results[0]->geometry->location->lat;
                $longitude = $response->results[0]->geometry->location->lng;

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

        array_push($directories, $business);
    }
@endphp

@section('content')
<section class="inner_banner" style="background: url({{asset('site/images/banner')}}-image.jpg) no-repeat center center; background-size:cover;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 mb-4">
                <h1>Local Directory</h1>
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
        <div class="">
            @if (!empty(request()->input('code'))|| !empty(request()->input('keyword'))|| !empty(request()->input('name')))
                @if ($directoryList->count() > 0)
                    <h2 class="mb-2 mb-sm-3">Directory with {{ request()->input('directory_category') ? '"'.request()->input('directory_category').'"' : '' }} {{ request()->input('keyword') ?  ( !empty(request()->input('directory_category')) ? ' and "'.request()->input('keyword').'"' : '"'.request()->input('keyword').'"' ) : '' }} {{ request()->input('name') ?  ( !empty(request()->input('directory_category')) ? ' and "'.request()->input('name').'"' : '"'.request()->input('name').'"' ) : '' }}</h2>
                @else
                    <h2 class="mb-2 mb-sm-3">No directory found with {{ request()->input('directory_category') ? '"'.request()->input('directory_category').'"' : '' }} {{ request()->input('keyword') ? ( !empty(request()->input('directory_category')) ? ' and "'.request()->input('keyword').'"' : '"'.request()->input('keyword').'"' ) : '' }} {{ request()->input('name') ? ( !empty(request()->input('directory_category')) ? ' and "'.request()->input('name').'"' : '"'.request()->input('name').'"' ) : '' }}</h2>

                    <p class="mb-2 mb-sm-3 text-muted">Please try again with different Category or Keyword</p>
                @endif
            @else
                @if (count($directories) > 0)
                    <h2 class="mb-2 mb-sm-3">Directory</h2>
                @else
                    <h2 class="mb-2 mb-sm-3">No directories found</h2>
                @endif
            @endif
        </div>
        <div class="row justify-content-between">
            <div class="col-auto">
                <div class="best_deal page-title"></div>
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
            {{-- grid view --}}
            <div class="tab-content smallGapGrid" id="grid">
                <div class="row Bestdeals">
                    @foreach($directoryList as $key => $business)
                        <div class="col-6 col-md-4 col-lg-4 mb-3 mb-lg-4">
                            <div class="card directoryCard directory_block border-0 v3card">
                                <div class="card-body">
                                    <h5 class="card-title"><a href="{{ URL::to('directory/'.$business->slug) }}" class="location_btn">{{ $business->name }}</a></h5>

                                    {!! directoryRatingHtml(number_format(getDirectoryReviewDetails($business->id)['average_star_count'],1)) !!}
                                    <p><i class="fas fa-map-marker-alt"></i> {!! $business->address !!}</p>

                                    <div class="directory_block">
                                        <div>
                                            @php
                                                $only_numbers = (int)filter_var($business->mobile, FILTER_SANITIZE_NUMBER_INT);
                                                if(strlen((string)$only_numbers) == 9) {
                                                    $only_number_to_array = str_split((string)$only_numbers);
                                                    $mobile_number = '(0'.$only_number_to_array[0].') '.$only_number_to_array[1].$only_number_to_array[2].$only_number_to_array[3].$only_number_to_array[4].$only_number_to_array[5].$only_number_to_array[6].$only_number_to_array[7].$only_number_to_array[8];
                                                } elseif(strlen((string)$only_numbers) == 10) {
                                                    $only_number_to_array = str_split((string)$only_numbers);
                                                    $mobile_number = '('.$only_number_to_array[0].$only_number_to_array[1].$only_number_to_array[2].$only_number_to_array[3].') '.$only_number_to_array[4].$only_number_to_array[5].$only_number_to_array[6].$only_number_to_array[7].$only_number_to_array[8].$only_number_to_array[9];
                                                } else {
                                                    $mobile_number = $business->mobile;
                                                }
                                            @endphp
                                            <a href="tel:{{$mobile_number}}" class="g_l_icon"><i class="fas fa-phone-alt"></i>{{$mobile_number}}</a>
                                        </div>
                                        <div class="categoryB-list v3_flag">
                                            {!! directoryCategory($business->category_id) !!}
                                        </div>
                                    </div>
                                    <div class="v3readmore">
                                        <a href="{{ URL::to('directory/'.$business->slug) }}" class="location_btn"><i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $directoryList->appends($_GET)->links() }}
                </div>
            </div>

            {{-- list view --}}
            <div class="tab-content smallGapGrid Bestdeals" id="list">
                <div class="row">
                  <ul class="search_list_items search_list_items-mod v3_list_view">
                      @foreach($directoryList as $key => $business)
                      <li class="directory_listblock">
                            <div class="list_content_wrap">
                                <div class="location_meta">
                                    <figcaption>
                                        <h4 class="place_title bebasnew">{{$business->name}}</h4>

                                        <div class="mb-3">{!! directoryRatingHtml($business->rating) !!}</div>

                                        <div class="d-flex location_details">
                                            <div>        @php
                                                $only_numbers = (int)filter_var($business->mobile, FILTER_SANITIZE_NUMBER_INT);
                                                if(strlen((string)$only_numbers) == 9) {
                                                    $only_number_to_array = str_split((string)$only_numbers);
                                                    $mobile_number = '(0'.$only_number_to_array[0].') '.$only_number_to_array[1].$only_number_to_array[2].$only_number_to_array[3].$only_number_to_array[4].$only_number_to_array[5].$only_number_to_array[6].$only_number_to_array[7].$only_number_to_array[8];
                                                } elseif(strlen((string)$only_numbers) == 10) {
                                                    $only_number_to_array = str_split((string)$only_numbers);
                                                    $mobile_number = '('.$only_number_to_array[0].$only_number_to_array[1].$only_number_to_array[2].$only_number_to_array[3].') '.$only_number_to_array[4].$only_number_to_array[5].$only_number_to_array[6].$only_number_to_array[7].$only_number_to_array[8].$only_number_to_array[9];
                                                } else {
                                                    $mobile_number = $business->mobile;
                                                }
                                            @endphp
                                            <a href="tel:{{$mobile_number}}" class="g_l_icon"><i class="fas fa-phone-alt"></i>{{$mobile_number}}</a></div>
                                            <div class="d-flex location_details mb-2 mb-md-0 ml-0 ml-md-2 mt-1 mt-md-0">
                                                @php
                                                    if (($business->website == "NA" || $business->website == "")) {
                                                        echo '';
                                                    } else {
                                                        echo '
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                                                        <a href="'.$business->website.'" target="_blank" class="history_details">'.$business->website.'</a>';
                                                    }
                                                @endphp
                                            </div>
                                        </div>
                                    </figcaption>

                                    <div class="d-flex location_details">
                                        <span><i class="fas fa-map-marker-alt"></i></span>
                                        <p class="location mb-0">{{$business->address}}</p>
                                    </div>

                                    <div class="categoryB-list">
                                    {!! directoryCategory($business->category_id) !!}
                                    </div>
                                    <div class="v3readmore">
                                        <a href="{{ URL::to('directory/'.$business->slug) }}"><span>View Details</span> <i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                      </li>
                      @endforeach
                  </ul>
                    <div class="col-12">
                        <div class="d-flex justify-content-center mt-4">
                            {{ $directoryList->appends($_GET)->links() }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- map view --}}
            <div class="tab-content smallGapGrid Bestdeals" id="map">
                <div class="row justify-content-center">
                    <div class="col-12"></div>
                    <div class="col-12">
                        <div class="map">
                            <div id="mapShow" style="height: 600px;"></div>
                            <span id="latLngShow"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@push('scripts')
    <script src="https://maps.google.com/maps/api/js?key=&v=weekly" type="text/javascript"></script>

    <script>
        @php
        $locations = array();
        foreach($directories as $business) {
            $page_link = URL::to('directory/'.strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $business->name)));

            // dd($business->latitude);

            if(!empty($business->latitude) || !empty($business->longitude)){
                $data = array($business->name,floatval($business->latitude),floatval($business->longitude),$business->address,$page_link);
            } else {
                $data = array($business->name, 0.00, 0.00, $business->address, $page_link);
            }
            array_push($locations, $data);
        }
        @endphp

        var locations = <?php echo json_encode($locations); ?>;

        var map = new google.maps.Map(document.getElementById('mapShow'), {
            zoom: 13,
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
        const trafficLayer = new google.maps.TrafficLayer();

        trafficLayer.setMap(mapShow);
        var infowindow = new google.maps.InfoWindow();

        var marker, i;
        var iconBase = 'https://demo91.co.in/localtales-prelaunch/public/site/images/';

        for (i = 0; i < locations.length; i++) {
            const contentString =
            '<div id="content">' +
            '<div id="siteNotice">' +
            "</div>" +
            //'<img src="'+locations[i][4]+'" width="">' +
            '<div class="mapPopContent"><div id="bodyContent"><a href="'+locations[i][4]+'"><h6 id="firstHeading" class="firstHeading mb-2">'+locations[i][0]+'</h6></a>' +
            '<p>' +locations[i][3]+'</p></div>' +
            '<a href="'+locations[i][4]+'" class="directionBtn"><i class="fas fa-link"></i></a>' +
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
        function getLocation() {
            if (navigator.geolocation) {
                const geolocation = navigator.geolocation.getCurrentPosition(showLOcation);
            } else {
                console.log("failed");
            }
        }
        getLocation()
        function showLOcation(position) {
            console.log("position", position);
            if (position.coords?.latitude && position.coords?.longitude) {
                $.ajax({
                    url: `https://maps.googleapis.com/maps/api/geocode/json?latlng=${position.coords?.latitude},${position.coords?.longitude}&key=`,
                    // url: `https://maps.googleapis.com/maps/api/geocode/json?latlng=-33.878844,151.210072&key=AIzaSyDegpPMIh4JJgSPtZwE6cfTjXSQiSYOdc4`,
                    method: 'get',
                    data: {},
                    success: function(result) {
                        console.log("location", result);
                        let address = result?.results[0]?.address_components;
                        console.log("address", address);
                        const postcode = address.filter(e => e.types.includes("postal_code"))
                        console.log("postcode", postcode);
                        localStorage.setItem("postcode", postcode[0].long_name)
                        console.log(localStorage.getItem("postcode")+"here");
                    }
                })
            }
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
@endpush
