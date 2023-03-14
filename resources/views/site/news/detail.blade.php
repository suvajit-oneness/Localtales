@extends('site.app')
@section('title'){{ $news->title }}@endsection
@section('description')

@section('content')
    <section class="artiledetails_banner mb-3 mb-sm-4">
      
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-12">
                    <div class="pt-4">
                        <ul class="breadcumb_list mb-2 mb-sm-4">
                            <li><a href="{!! URL::to('') !!}">Home</a></li>
                            <li>/</li>
                            <li><a href="{!! URL::to('news') !!}">News</a></li>
                            <li>/</li>
                            <li>{{ $news->title }}</li>
                        </ul>
                    </div>
                </div>

                {{-- {{dd( $news)}} --}}

                <div class="col-12 col-md-6">
                    <div class="job__details pt-0">
                        <img src="{{$news->image}}" height="100" width="500">
                        <h1 class="">{{  $news->title }}</h1>
                        <div class="job-details-heading">
                            <div class="job-details-heading-left mb-2">
                            </div>
                        </div>
                        <div class="row align-items-center">
                            
                            <div class="col-auto">
                                <ul class="articlecat">
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"    class="feather feather-map-pin">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                        {{ $news->postcode ?  $news->postcode : ''}}{{ $news->suburb ? ', '. $news->suburb : ''}}{{ $news->state ? ', '. $news->state : ''}}
                                    </li>
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar">
                                            <rect x="3" y="4" width="18" height="18" rx="2"
                                                ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        {{  $news->created_at->format('d M Y') }}
                                    </li>
                                    <li>
                                        <div class="share-btns ml-3">
                                            <div class="dropdown">
                                                <button class="share_button dropdown-toggle px-0" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="#898989" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-share-2">
                                                        <circle cx="18" cy="5" r="3"></circle>
                                                        <circle cx="6" cy="12" r="3"></circle>
                                                        <circle cx="18" cy="19" r="3"></circle>
                                                        <line x1="8.59" y1="13.51" x2="15.42" y2="17.49">
                                                        </line>
                                                        <line x1="15.41" y1="6.51" x2="8.59" y2="10.49">
                                                        </line>
                                                    </svg>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right"
                                                    aria-labelledby="dropdownMenuButton">
                                                    <div class="w-100 pl-2">
                                                        <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                                            <a class="a2a_button_facebook"></a>
                                                            <a class="a2a_button_twitter"></a>
                                                            <a class="a2a_button_whatsapp"></a>
                                                            <a class="a2a_button_pinterest"></a>
                                                            <a class="a2a_button_linkedin"></a>
                                                            <a class="a2a_button_telegram"></a>
                                                            <a class="a2a_button_reddit"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    <!-- for sticky image half or full -->
    <hr>
    <section class="py-2 py-sm-4 job-details-sec">
        <div class="container">
           <div class="row">
                <div class="col-12">
                    <div class="full-job-desc">
                        <h3 class="job-desc-heading"></h3>
                        <p>{!!  $news->description ?  $news->description : 'NA' !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script async src="https://static.addtoany.com/menu/page.js"></script>
    
@endpush
