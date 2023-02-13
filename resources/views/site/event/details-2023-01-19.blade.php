@extends('site.app')
@section('title')
    {{ $pageTitle }}
@endsection
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
    @php
        $locations = [];
        
        $address = $event->full_address;
        $directoryLattitude = $event->lat;
        $directoryLongitude = $event->lon;
        
        $orgId = $event->id;
        $orgAddress = $event->full_address;
        $orgCat = $event->category_id;
        
        if ($directoryLattitude == null || $directoryLongitude == null) {
            $url = 'https://maps.google.com/maps/api/geocode/json?address=' . urlencode($address) . '&key=';
        
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $responseJson = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($responseJson);
        
            if ($response->results) {
                $latitude = $response->results[0]->geometry->location->lat;
                $longitude = $response->results[0]->geometry->location->lng;
        
                // insert lat & lon into directories
                \DB::table('events')
                    ->where('id', $event->id)
                    ->update([
                        'lat' => $latitude,
                        'lon' => $longitude,
                    ]);
            } else {
                $latitude = '';
                $longitude = '';
            }
        } else {
            $event->latitude = $directoryLattitude;
            $event->longitude = $directoryLongitude;
        }
        
        // $business->latitude = $latitude;
        // $business->longitude = $longitude;
        
    @endphp
    <section class="details_banner">
        <figure>
            @if ($event->image)
                <img src="{{ URL::to('/') . '/uploads/events/' }}{{ $event->image }}">
            @else
                <img src="{{ asset('Directory/placeholder-image.png') }}" class="card-img-top" alt="">
            @endif
        </figure>
        <figcaption class="pt-4 pt-sm-5">
            <div class="container">
                <div class="details_info">
                    <ul class="breadcumb_list mb-4">
                        <li><a href="{!! URL::to('') !!}">Home</a></li>
                        <li>/</li>
                        <li><a href="{!! URL::to('events') !!}">Events</a></li>
                        <li>/</li>
                        <li>{{ ucwords($event->title) }}</li>
                    </ul>
                    <div class="deal_header d-flex align-items-center justify-content-between">
                        <h1 class="details_banner_heading mb-4">{{ $event->title }}</h1>
                        <div class="col-auto align-self-center">
                            <div class="share-btns">
                                <div class="dropdown">
                                    <button class="share_button dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="#898989" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-share-2">
                                            <circle cx="18" cy="5" r="3"></circle>
                                            <circle cx="6" cy="12" r="3"></circle>
                                            <circle cx="18" cy="19" r="3"></circle>
                                            <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                                            <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                                        </svg>
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
                        <div class="banner_meta_item col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3 mb-lg-0">
                            <figure>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-list">
                                    <line x1="8" y1="6" x2="21" y2="6"></line>
                                    <line x1="8" y1="12" x2="21" y2="12"></line>
                                    <line x1="8" y1="18" x2="21" y2="18"></line>
                                    <line x1="3" y1="6" x2="3.01" y2="6"></line>
                                    <line x1="3" y1="12" x2="3.01" y2="12"></line>
                                    <line x1="3" y1="18" x2="3.01" y2="18"></line>
                                </svg>
                            </figure>
                            <figcaption>
                                <h5>Category</h5>
                                <p>
                                    {!! eventcategory($event->category_id) !!}
                                </p>
                            </figcaption>
                        </div>
                        <div class="banner_meta_item col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3 mb-lg-0">
                            <figure>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar">
                                    <rect x="3" y="4" width="18" height="18" rx="2"
                                        ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </figure>
                            <figcaption>
                                <h5>Date</h5>
                                <p>
                                    Start: {{ date('j M, Y', strtotime($event->start_date)) }}
                                    <br>
                                    End: {{ date('j M, Y', strtotime($event->end_date)) }}
                                </p>
                            </figcaption>
                        </div>
                        <div class="banner_meta_item col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3 mb-lg-0">
                            <figure>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                            </figure>
                            <figcaption>
                                <h5>Timing</h5>
                                <p>Start: {{ date('h:i a', strtotime($event->start_time)) }}<br />End:
                                    {{ date('h:i a', strtotime($event->end_time)) }}</p>
                            </figcaption>
                        </div>
                        @if ($event->type == 'in person')
                            <div class="banner_meta_item col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3 mb-lg-0">
                                <figure>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                        <circle cx="12" cy="10" r="3"></circle>
                                    </svg>
                                </figure>
                                <figcaption>
                                    <h5>Location</h5>
                                    <p>{{ $event->suburb }}</p>
                                </figcaption>
                            </div>
                        @else
                            <div class="banner_meta_item col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3 mb-lg-0">
                                <figure>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="#fff">
                                        <path
                                            d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm95.8 32.6L272 480l-32-136 32-56h-96l32 56-32 136-47.8-191.4C56.9 292 0 350.3 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-72.1-56.9-130.4-128.2-133.8z" />
                                    </svg>
                                </figure>
                                <figcaption>
                                    <h5>Link</h5>
                                    <p><a href="{{ $event->link }}" target="_blank">Click Here</a></p>
                                </figcaption>
                            </div>
                        @endif
                        <div class="banner_meta_item col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3 mb-lg-0">
                            <figure>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" fill="#fff">
                                    <path
                                        d="M96 224c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm448 0c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm32 32h-64c-17.6 0-33.5 7.1-45.1 18.6 40.3 22.1 68.9 62 75.1 109.4h66c17.7 0 32-14.3 32-32v-32c0-35.3-28.7-64-64-64zm-256 0c61.9 0 112-50.1 112-112S381.9 32 320 32 208 82.1 208 144s50.1 112 112 112zm76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C179.6 288 128 339.6 128 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2zm-223.7-13.4C161.5 263.1 145.6 256 128 256H64c-35.3 0-64 28.7-64 64v32c0 17.7 14.3 32 32 32h65.9c6.3-47.4 34.9-87.3 75.2-109.4z" />
                                </svg>
                            </figure>
                            <figcaption>
                                <h5>Type</h5>
                                <p>{{ $event->type }}</p>
                            </figcaption>
                        </div>
                        @if (!empty($event->contact_email))
                            <div class="banner_meta_item col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-3 mb-lg-0">
                                <figure>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="#fff">
                                        <path
                                            d="M464 64H48C21.49 64 0 85.49 0 112v288c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V112c0-26.51-21.49-48-48-48zm0 48v40.805c-22.422 18.259-58.168 46.651-134.587 106.49-16.841 13.247-50.201 45.072-73.413 44.701-23.208.375-56.579-31.459-73.413-44.701C106.18 199.465 70.425 171.067 48 152.805V112h416zM48 400V214.398c22.914 18.251 55.409 43.862 104.938 82.646 21.857 17.205 60.134 55.186 103.062 54.955 42.717.231 80.509-37.199 103.053-54.947 49.528-38.783 82.032-64.401 104.947-82.653V400H48z" />
                                    </svg>
                                </figure>
                                <figcaption>
                                    <h5>Host email</h5>
                                    <p>{{ $event->contact_email }}</p>
                                </figcaption>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </figcaption>
    </section>


    <section class="letest-offer">
        <div class="container">
            <?php /* ?> ?> ?>
            <div class="row m-0 mt-5 mb-5">
                <div class="col-12 col-md-6 bg-bipblue p-4">
                    <ul class="detail-evtext">
                        <li>
                            <p class="w-100 catagoris_ev">
                                <span><img src="{{ URL::to('/') . '/categories/' }}{{ $event->category->image }}"
                                        class="mr-2"> {{ $event->category->title }}</span>
                                <span class="float-right w-142">
                                    <small class="d-block">START : {{ date('h:i a', strtotime($event->start_time)) }}
                                    </small>
                                    <small>END : {{ date('h:i a', strtotime($event->end_time)) }} </small>
                                </span>
                            </p>
                            <a href="#">
                                <h1>{{ $event->title }}</h1>
                            </a>
                            <h6>Address</h6>
                            <p class="text-white">
                                {{ $event->address }}
                                <br>
                                Start Date : {{ date('d-M-Y', strtotime($event->start_date)) }}
                                <br>
                                End Date : {{ date('d-M-Y', strtotime($event->end_date)) }}
                            </p>
                        <li>
                    </ul>
                </div>
                <div class="col-12 col-md-6 p-0 image-part"
                    style="background:url({{ URL::to('/') . '/events/' }}{{ $event->image }});">
                    <!-- <a href="javascript:void(0);" class="all_pic shadow-lg">View All 3 Images</a> -->
                </div>
            </div>
            <?php */ ?>

            <div class="row">
                <div class="col-md-12 details_left">
                    <!-- <div class="price-deat">
              <h1>$ 200<span>Inc. of all taxes<span></h1>
             </div> -->

                    <ul class="nav nav-tabs details_tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#deals" role="tab">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path
                                        d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                    </path>
                                </svg> <span>Service Description</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#about" role="tab"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-file-text">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg> Directories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#photos" role="tab"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-phone">
                                    <path
                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                    </path>
                                </svg> <span>Contact Details</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#images" role="tab">  <img src="{{ URL::to('/') . '/uploads/events/thumbnail.png'}}" class="thumbnail-icon"><span>Image gallery</span></a>
                        </li>
                    </ul><!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="deals" role="tabpanel">
                            <!-- <h5>{{ $event->title }}</h5> -->
                            {!! $event->description !!}
                        </div>
                        <div class="tab-pane" id="about" role="tabpanel">
                            <ul class="deals-contant">
                                @php
                                    $eventBusiness = eventBusinessDetails($event->directory_id);
                                    //dd($eventBusiness);
                                @endphp

                                {{-- grid view --}}

                                <div class="row Bestdeals">
                                    @foreach ($eventBusiness as $key => $business)
                                        <div class="col-6 col-md-4 col-lg-4 mb-3 mb-lg-4">
                                            <div class="card directoryCard directory_block border-0 v3card">
                                                <div class="card-body">
                                                    <h5 class="card-title"><a
                                                            href="{{ URL::to('directory/' . $business->slug) }}"
                                                            class="location_btn">{{ $business->name }}</a></h5>

                                                    {!! directoryRatingHtml($business->rating) !!}

                                                    <p><i class="fas fa-map-marker-alt"></i> {!! $business->address !!}</p>

                                                    <div class="directory_block">
                                                        <div>
                                                            @php
                                                                $only_numbers = (int) filter_var($business->mobile, FILTER_SANITIZE_NUMBER_INT);
                                                                if (strlen((string) $only_numbers) == 9) {
                                                                    $only_number_to_array = str_split((string) $only_numbers);
                                                                    $mobile_number = '(0' . $only_number_to_array[0] . ') ' . $only_number_to_array[1] . $only_number_to_array[2] . $only_number_to_array[3] . $only_number_to_array[4] . $only_number_to_array[5] . $only_number_to_array[6] . $only_number_to_array[7] . $only_number_to_array[8];
                                                                } elseif (strlen((string) $only_numbers) == 10) {
                                                                    $only_number_to_array = str_split((string) $only_numbers);
                                                                    $mobile_number = '(' . $only_number_to_array[0] . $only_number_to_array[1] . $only_number_to_array[2] . $only_number_to_array[3] . ') ' . $only_number_to_array[4] . $only_number_to_array[5] . $only_number_to_array[6] . $only_number_to_array[7] . $only_number_to_array[8] . $only_number_to_array[9];
                                                                } else {
                                                                    $mobile_number = $business->mobile;
                                                                }
                                                            @endphp
                                                            <a href="tel:{{ $mobile_number }}" class="g_l_icon"><i
                                                                    class="fas fa-phone-alt"></i>{{ $mobile_number }}</a>
                                                        </div>
                                                        <div class="categoryB-list v3_flag">
                                                            {!! directoryCategory($business->category_id) !!}

                                                        </div>
                                                    </div>
                                                    {{-- <div class="v3readmore">
																	
																	<a href="{{ URL::to('directory/'.$business->slug) }}" class="location_btn"><i class="fa fa-arrow-right"></i></a>
																</div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>



                            </ul>
                        </div>
                        <div class="tab-pane" id="photos" role="tabpanel">
                            <table class="table table-sm table-hover">
                                <tr>
                                    <td>Website: </td>
                                    <td> <a href="#">{{ $event->website ? $event->website : 'N/A' }} </a></td>
                                </tr>
                                <tr>
                                    <td>Contact Email: </td>
                                    <td> <a href="#">{{ $event->contact_email ? $event->contact_email : 'N/A' }}
                                        </a></td>
                                </tr>
                                <tr>
                                    <td>Contact No: </td>
                                    <td> <a href="#">{{ $event->contact_phone ? $event->contact_phone : 'N/A' }}
                                        </a></td>
                                </tr>
                                <tr>
                                    <td>Address: </td>
                                    <td> <a href="#">{{ $event->full_address ? $event->full_address : 'N/A' }} </a>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="tab-pane" id="images" role="tabpanel">
                            <div class="swiper mySwiper">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="{{ URL::to('/') . '/uploads/events/' }}{{ $event->image1 }}"
                                            width="200px">
                                    </div>
                                    <div class="swiper-slide">
                                        @if ($event->image2)
                                            <img src="{{ URL::to('/') . '/uploads/events/' }}{{ $event->image2 }}"
                                                width="200px">
                                        @endif
                                    </div>
                                    <div class="swiper-slide">
                                        @if ($event->image3)
                                            <img src="{{ URL::to('/') . '/uploads/events/' }}{{ $event->image3 }}"
                                                width="200px">
                                        @endif
                                    </div>
                                </div>

                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="mt-4 text-right">
              <a href="javascript:void(0);" class="orange-btm load_btn" id="load-more2">DETAILS</a>
              <a href="javascript:void(0);" class="blue-btn load_btn" id="load-more2">+ Add</a>
             </div> -->
                </div>
                <!-- <div class="col-md-6 details_left">
            <div class="directory-map">
             <div id="mapShow" style="width: 100%; height: 400px;"></div>
            </div>
           </div>  -->
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
    <script src="https://maps.google.com/maps/api/js?key=" type="text/javascript"></script>
    <script async src="https://static.addtoany.com/menu/page.js"></script>
    <script type="text/javascript">
        @php
            $locations = [];
            $data = [$event->title, floatval($event->lat), floatval($event->lon)];
            array_push($locations, $data);
        @endphp
        var locations = <?php echo json_encode($locations); ?>;
        console.log("dealLocations>>" + JSON.stringify(locations));

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
        var iconBase = 'https://localtales.com/public/site/images/map_icon.png';

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
