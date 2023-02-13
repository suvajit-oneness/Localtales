@extends('site.app')

@php
    if (!empty($collectionData->short_description)) {
        $meta_desc = explode(".", $collectionData->short_description);
        $description = $meta_desc[0]. "." .$meta_desc[1];
    } else {
        $description = '';
    }
@endphp

@section('title'){{$collectionData->title}}@endsection
@section('description'){{$description}}@endsection

{{-- @section('title') {{$collectionData->title }} @endsection
@php
if(!empty($collectionData->short_description)){
$meta_desc=explode(".",$collectionData->short_description);
$description= $meta_desc[0]. "." .$meta_desc[1]. ".";
}
else{
    $description= '';
}
@endphp
@section('description', $description) --}}

@section('content')
	@php
    // $locations = array();

    /* foreach($allCategoriesForMapView as $key => $business){
        $address = $business->directory->address;

        $url = "https://maps.google.com/maps/api/geocode/json?address=".urlencode($address)."&key=AIzaSyDegpPMIh4JJgSPtZwE6cfTjXSQiSYOdc4";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $responseJson = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($responseJson);

        $latitude = $response->results[0]->geometry->location->lat;
        $longitude = $response->results[0]->geometry->location->lng;

        $business->directory->latitude = $latitude;
        $business->directory->longitude = $longitude;
    }

    $latitude = 0.000;
    $longitude = 0.000;*/

    $businesses = [];

    foreach ($allCategoriesForMapView as $business) {
        $directoryLattitude = $business->directory->lat;
        $directoryLongitude = $business->directory->lon;
        $address = $business->directory->address;

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

                $business->directory->latitude = $latitude;
                $business->directory->longitude = $longitude;

                // insert lat & lon into directories
                \DB::table('directories')->where('id', $business->directory->id)->update([
                    'lat' => $latitude,
                    'lon' => $longitude
                ]);
            }
        } else {
            $business->directory->latitude = $directoryLattitude;
            $business->directory->longitude = $directoryLongitude;
        }

        array_push($businesses, $business);
    }

    $demoImage = DB::table('demo_images')->where('title', '=', 'collection')->get();
    $demo = $demoImage[0]->image;
    @endphp
    <section class="inner_banner collection_banner" @if($collectionData->image) style="background-image: url('{{URL::to('/').'/Collection/'}}{{$collectionData->image}}');" @else  style="background: url({{URL::to('/').'/Demo/'}}{{$demo}})" @endif>
        <div class="container position-relative">
            <div class="row text-center justify-content-center">
                <div class="col-12 col-lg-12">
                    <h1>{{ ucwords($collectionData->title) }}</h1>
                    <p> {{$collectionData->short_description }}</p>
                    <span>
                    @php
                        $category =  \App\Models\Collection::findOrFail($collectionData->id);
                        // dd($data)
                    @endphp
                    </span>
                </div>
            </div>

            <div class="collection_breadcumb page-search-block">
                <div class="row justify-content-between align-items-center">
                    <div class="col">
                        <div class="details_info mb-0">
                            <ul class="breadcumb_list mb-0">
                                <li><a href="{!! URL::to('') !!}">Home</a></li>
                                <li>/</li>
                                <li><a href="{{URL::to('/').'/collection'}}">Collection</a></li>
                                <li>/</li>
                                <li class="active"> {{ $collectionData->title }} </li>
                               {{-- @php
                                    $blogs = \App\Models\CollectionDirectory::where('collection_id',$collectionData->id)->with('directory')->get();
                                    $item=$blogs->count();
                                @endphp
                                @if($item==0)
                                    <li class="active"> {{str_replace('XX', ' ', $collectionData->title )}} </li>
                                @else
                                    <li class="active"> {{str_replace('XX', $item, $collectionData->title )}} </li>
                                @endif --}}
                            </ul>
                       </div>
                   </div>
                   <div class="col-auto">
                        <a href="javascript:void(0)" class="wishlist_button" onclick="collectionBookmark({{$category->id}})">
                            @php
                                $ip = $_SERVER['REMOTE_ADDR'];
                                if(auth()->guard('user')->check()) {
                                   $collectionExistsCheck = \App\UserCollection::where('collection_id', $category->id)->where('ip', $ip)->orWhere('user_id', auth()->guard('user')->user()->id)->first();
                                } else {
                                   $collectionExistsCheck = \App\UserCollection::where('collection_id', $category->id)->where('ip', $ip)->first();
                                }

                                if($collectionExistsCheck != null) {
                                    // if found
                                    $heartColor = "#fff";
                                } else {
                                    // if not found
                                    $heartColor = "none";
                                }
                            @endphp
                            <svg id="saveBtn" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="{{$heartColor}}" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </a>

                        {{-- <span class="save collectionSave">
                            @if ($businessSaved == 1)
                            <a href="{!! URL::to('site-delete-user-collection/'.$category->id) !!}" class="btn btn-blue wishlist  text-center"><img src="{{ asset('front/img/bookmark.png')}}" alt=""></a>
                            @else
                            <a href="{!! URL::to('site-save-user-collection/'.$category->id) !!}" class="btn btn-light text-center">
                                <img src="{{ asset('front/img/bookmark.png')}}" alt=""></a>
                            @endif
                        </span> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- @foreach($data as  $key => $blog) --}}
    <section class="collectionbreadcumbPadding pb-4 pb-lg-5">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12 col-lg-9 page-title">
                </div>
            </div>
            <div class="page-title best_deal mb-4 mb-lg-5">
                <h2>{!! html_entity_decode($collectionData->paragraph1_heading) !!}</h2>

                @php
                    $para1 = str_replace('"&gt;', '', $collectionData->paragraph1);
                @endphp

                <p>{!! str_limit(strip_tags($para1), $limit = 100000, $end = '...') !!}</p>
            </div>
            @if(count($directories)>0)
            <div class="d-flex justify-content-between align-items-center cafe-listing-nav">
                <ul class="d-flex" id="tabs-nav">
                   <li class="">
                        <a href="#grid">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        </a>
                    </li>
                   <li class="">
                        <a href="#map">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line></svg>
                        </a>
                    </li>
                </ul>
                <span>
                   {{$directories->total()}} Listed
                </span>
            </div>
            <h3 class="mb-3 mb-md-4">List of Directory</h3>
            <div id="tab-contents">
                <div class="tab-content smallGapGrid Bestdeals" id="grid">
                    <div class="row cafe-card">
                        @foreach($directories as $key => $directory)
                        <div class="col-6 col-md-4 col-lg-4 mb-3 mb-lg-4">
                            <div class="card directoryCard border-0 v3card">
                                <div class="card-body">
                                    <h5 class="card-title"><a href="{{ URL::to('directory/'.$directory->directory->slug) }}" class="location_btn">{{ $directory->directory->name }}</a></h5>
                                   @if($directory->directory->rating==0)
                                   <p>No ratings available </p>
                                   @elseif($directory->directory->rating==1)
                                    <p class="review">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <small>{{$directory->directory->rating}} Ratings</small>
                                    </p>
                                    @elseif($directory->directory->rating>1 && $directory->directory->rating<2)
                                    <p class="review">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fas fa-star-half-alt" style='color:#FFA701'></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <small>{{$directory->directory->rating}} Ratings</small>
                                    </p>
                                    @elseif($directory->directory->rating==2)
                                    <p class="review">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <small>{{$directory->directory->rating}} Ratings</small>
                                    </p>
                                    @elseif($directory->directory->rating>2 && $directory->directory->rating<3)
                                    <p class="review">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fas fa-star-half-alt" style='color:#FFA701'></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <small>{{$directory->directory->rating}} Ratings</small>
                                    </p>
                                    @elseif($directory->directory->rating==3)
                                    <p class="review">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star "></span>
                                        <span class="fa fa-star"></span>
                                        <small>{{$directory->directory->rating}} Ratings</small>
                                    </p>
                                     @elseif($directory->directory->rating>3 && $directory->directory->rating<4)
                                    <p class="review">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star-half-alt" style='color:#FFA701'></span>
                                        <span class="fa fa-star"></span>
                                        <small>{{$directory->directory->rating}} Ratings</small>
                                    </p>
                                    @elseif($directory->directory->rating==4)
                                    <p class="review">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star"></span>
                                        <small>{{$directory->directory->rating}} Ratings</small>
                                    </p>
                                    @elseif($directory->directory->rating>4 && $directory->directory->rating<5)
                                    <p class="review">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fas fa-star-half-alt" style='color:#FFA701'></span>
                                        <small>{{$directory->directory->rating}} Ratings</small>
                                    </p>
                                    @else
                                    <p class="review">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <small>{{$directory->directory->rating}} Ratings</small>
                                    </p>
                                    @endif
                                    <p><i class="fas fa-map-marker-alt"></i> {!! $directory->directory->address !!}</p>
                                    <input type="hidden" id="googlemapaddress" value="">
                                    <div class="directory_block">
                                        <div>
                                            @php
                                                $only_numbers = (int)filter_var($directory->directory->mobile, FILTER_SANITIZE_NUMBER_INT);
                                                if(strlen((string)$only_numbers) == 9)
                                                {
                                                    $only_number_to_array = str_split((string)$only_numbers);
                                                    $mobile_number = '(0'.$only_number_to_array[0].') '.$only_number_to_array[1].$only_number_to_array[2].$only_number_to_array[3].$only_number_to_array[4].$only_number_to_array[5].$only_number_to_array[6].$only_number_to_array[7].$only_number_to_array[8];
                                                }elseif(strlen((string)$only_numbers) == 10){
                                                    $only_number_to_array = str_split((string)$only_numbers);
                                                    $mobile_number = '('.$only_number_to_array[0].$only_number_to_array[1].$only_number_to_array[2].$only_number_to_array[3].') '.$only_number_to_array[4].$only_number_to_array[5].$only_number_to_array[6].$only_number_to_array[7].$only_number_to_array[8].$only_number_to_array[9];
                                                }
                                                else
                                                    $mobile_number = $directory->mobile;
                                            @endphp
                                            <a href="tel:{{$mobile_number}}" class="g_l_icon"><i class="fas fa-phone-alt"></i>{{$mobile_number}}</a>
                                            {{-- <!--<a href="{{$business->mobile}}" class="g_l_icon"><i class="fas fa-phone-alt"></i>{{str_replace('(' ,' ', $business->mobile )}}</a> --> --}}
                                        </div>
                                        <div class="categoryB-list v3_flag">
                                        @php
                                            if(!empty($directory->directory->category_id)) {
                                                $cat = substr($directory->directory->category_id, 0, -1);
                                                $displayCategoryName = '';
                                                foreach(explode(',', $cat) as $catKey => $catVal) {
                                                    $catDetails = \App\Models\DirectoryCategory::findOrFail($catVal);
                                                    $displayCategoryName .= '<a class="mb-2" href="'.route("category.directory", $catDetails->id).'">'.$catDetails->title.'</a>, ';
                                                }
                                                echo substr($displayCategoryName, 0, -2);
                                            }
                                        @endphp
                                        </div>
                                    </div>
                                    <div class="v3readmore">
                                        <a href="{{ URL::to('directory/'.$directory->directory->slug) }}"><i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endforeach
                    </div>
                    <div class="col-12">
                        <div class="d-flex justify-content-center mt-4">
                            {{ $directories->appends($_GET)->links() }}
                        </div>
                    </div>
                </div>

                <div class="tab-content smallGapGrid" id="map">
                    <div class="row justify-content-center">
                        <div class="col-12"></div>
                        <div class="col-12">
                            <div class="map">
                                <div id="mapShow" style="height: 600px;"></div>
                                <span id="latLngShow"></span>
                                <input type="hidden" id="googlemapaddress" value="">
                            </div>
                        </div>
                    </div>
                    {{-- <div class="collection_grid">
                        <div class="row cafe-card">
                            @foreach($directories as $key => $directory)
                            <div class="col-6 col-md-4 col-lg-4 mb-2 mb-md-3">
                                <div class="card directoryCard directory_block border-0 v3card">
                                    <div class="card-body">
                                        <h5 class="card-title"><a href="{{ URL::to('directory/'.$directory->directory->slug) }}" class="location_btn">{{ $directory->directory->name }}</a></h5>


                                        {!! directoryRatingHtml($business->rating) !!}
                                        <p><i class="fas fa-map-marker-alt"></i> {!! $directory->directory->address !!}</p>
                                        <input type="hidden" id="googlemapaddress" value="">
                                    <div>
                                    <div>
                                        @php
                                            $only_numbers = (int)filter_var($directory->directory->mobile, FILTER_SANITIZE_NUMBER_INT);
                                            if(strlen((string)$only_numbers) == 9)
                                            {
                                                $only_number_to_array = str_split((string)$only_numbers);
                                                $mobile_number = '(0'.$only_number_to_array[0].') '.$only_number_to_array[1].$only_number_to_array[2].$only_number_to_array[3].$only_number_to_array[4].$only_number_to_array[5].$only_number_to_array[6].$only_number_to_array[7].$only_number_to_array[8];
                                            }elseif(strlen((string)$only_numbers) == 10){
                                                $only_number_to_array = str_split((string)$only_numbers);
                                                $mobile_number = '('.$only_number_to_array[0].$only_number_to_array[1].$only_number_to_array[2].$only_number_to_array[3].') '.$only_number_to_array[4].$only_number_to_array[5].$only_number_to_array[6].$only_number_to_array[7].$only_number_to_array[8].$only_number_to_array[9];
                                            }
                                            else
                                                $mobile_number = $directory->mobile;
                                        @endphp
                                        <a href="tel:{{$mobile_number}}" class="g_l_icon"><i class="fas fa-phone-alt"></i>{{$mobile_number}}</a>
                                    </div>
                                    <div class="categoryB-list v3_flag">
                                    {!! directoryCategory($business->category_id) !!}
                                    </div>
                                </div>
                                <div class="v3readmore">
                                    <a href="{{ URL::to('directory/'.$directory->directory->slug) }}"><i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div> --}}
                </div>
            @endif
        </div>
    </section>
    {{-- @endforeach --}}

    <section class="py-2 py-sm-4 light-bg more-collection">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center cafe-listing-nav page-title">
                <h3>More Collections</h3>
            </div>
            <div class="row">
                @foreach($moreCollections as $key => $col)
                {{-- @php
                    $blogs = \App\Models\CollectionDirectory::where('collection_id',$col->id)->with('directory')->get();
                    $item=$blogs->count();
                @endphp --}}
                <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                    <div class="card collectionCard">
                        <a class="cardLink d-block" href="{!! URL::to('collection/' . $col->slug) !!}">
                            @if($col->image)
                                <img src="{{URL::to('/').'/Collection/'}}{{$col->image}}" alt="">
                            @else
                                <img src="{{asset('Directory/placeholder-image.png')}}" >
                            @endif
                            <div class="card-body">
                                <h4 class="location_btn"> {{$col->title }} </h4>
                                {{-- <h5><i class="fas fa-map-marker-alt"></i> {{ $col->address }}</h5> --}}
                                {{-- @if($item==0)
                                <h4 class="location_btn"> {{str_replace('XX', ' ', $col->title )}} </h4>
                                @else
                                <h4 class="location_btn"> {{str_replace('XX', $item, $col->title )}} </h4>
                                    @endif --}}
                                {{-- <div class="collectionPlaces">
                                    20 Places
                                    <i class="fas fa-caret-right"></i>
                                </div> --}}
                            </div>
                        </a>
                    </div>
                </div>
                <!-- <span>
                        {{$col->count()}} Places
                    </span> -->
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-2 py-sm-4 py-lg-5">
        <div class="container">
            <div class="row page-title">
                <div class="col-12 mb-4">
                    <h2>{!! html_entity_decode( $collectionData->paragraph2_heading ) !!}</h2>
                    {{-- <p> {!! html_entity_decode($collectionData->paragraph2 ) !!}</p> --}}
                    <p>{{ str_limit(strip_tags($collectionData->paragraph2), $limit = 100000, $end = '...') }}</p>
                </div>
                <div class="col-12 mb-4">
                    <h2>{!! html_entity_decode( $collectionData->paragraph3_heading ) !!}</h2>
                    {{-- <p> {!! html_entity_decode($collectionData->paragraph3 ) !!}</p> --}}
                    <p>{{ str_limit(strip_tags($collectionData->paragraph3), $limit = 100000, $end = '...') }}</p>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="https://maps.google.com/maps/api/js?key=" type="text/javascript"></script>

    <script type="text/javascript">
	@php
        $locations = [];
        foreach ($businesses as $business) {
           // $img = "https://maps.googleapis.com/maps/api/streetview?size=640x640&location=".$business->latitude.",".$business->longitude."&fov=120&heading=0&key=AIzaSyDegpPMIh4JJgSPtZwE6cfTjXSQiSYOdc4";
           if($business->directory->image = ''){
	        $img = "https://demo91.co.in/localtales-prelaunch/public/Directory/placeholder-image.png";
            }else{
                $img = "https://maps.googleapis.com/maps/api/streetview?size=640x640&location=".$business->directory->latitude.",".$business->directory->longitude."&fov=120&heading=0&key=";
            }

            //$page_link = URL::to('directory/' . $business->directory->slug );
            $page_link = URL::to('directory/' . $business->directory->slug );
            //dd($page_link);
            //$data = [$business->directory->name, floatval($business->directory->latitude), floatval($business->directory->longitude), $business->directory->address, $img, $page_link];
            $data = [$business->directory->name, floatval($business->directory->latitude), floatval($business->directory->longitude), $business->directory->address,$page_link];
            array_push($locations, $data);
        }
        @endphp

        var locations = <?php echo json_encode($locations); ?>;
        // console.log("businessLocations>>" + JSON.stringify(locations));
        // console.log(JSON.stringify(locations));

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
                '<div class="googleMapView content">' +
                //'<img src="' + locations[i][4] + '" class="w-100">' +
                '<div class="mapPopContent"><div id="bodyContent" class="bodyContent"><a href="' + locations[i][4] +
                '" target="_blank"><h6 class="firstHeading mb-2">' + locations[i][0] + '</h6></a>' +
                '<p>' + locations[i][3] + '</p></div>' +
                '<a href="' + locations[i][4] + '" target="_blank" class="directionBtn"><i class="fas fa-link"></i></a>' +
                '</div></div>';

                /*
                const contentString =
                    '<div id="content">' +
                    '<div id="siteNotice">' +
                    "</div>" +
                    '<img src="' + locations[i][4] + '" width="">' +

                    '<div class="mapPopContent"><div id="bodyContent"><a href="' + locations[i][5] +
                    '" target="_blank"><h6 id="firstHeading" class="firstHeading mb-2">' + locations[i][0] + '</h6></a>' +
                    '<p>' + locations[i][3] + '</p></div>' +

                    '<a href="' + locations[i][5] + '" target="_blank" class="directionBtn"><i class="fas fa-link"></i></a>' +
                    '</div></div>';
                */

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
    </script>

    <script>
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

        // collection bookmark/ save/ wishlist
        function collectionBookmark(collectionId) {
            $.ajax({
                url: '{{ route('user.collection.save.toggle') }}',
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
    </script>
@endpush
