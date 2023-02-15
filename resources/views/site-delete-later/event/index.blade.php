@extends('site.app')
@section('title'){{seoManagement('event')->title}}@endsection
@section('description'){{seoManagement('event')->meta_desc}}@endsection

@section('content')
{{-- filters --}}
<section class="inner_banner" style="background: url({{asset('site/images/banner')}}-image.jpg) no-repeat center center; background-size:cover;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 mb-4">
                <h1>Local Events</h1>
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
                                @php
                                $orgAddress = $request->keyword;
                                @endphp
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
            @if ($events->count() > 0)
              <li class="active">Events</li>
            @else
               <li class=""><a href="{!! URL::to('/events') !!}">Events</a></li>
               <li>/</li>
               <li class="active">No Events found</li>
            @endif
        @else
            <li class="active">Events</li>
        @endif
        </ul>
        <div class="row justify-content-between">
            <div class="col-auto">
                <div class="best_deal page-title">
                    @if (!empty(request()->input('code'))|| !empty(request()->input('keyword'))|| !empty(request()->input('name')))
                        @if ($events->count() > 0)
                            <h2 class="mb-2 mb-sm-3">Events found </h2>
                        @else
                            <h2 class="mb-2 mb-sm-3">No Events found  </h2>

                            <p class="mb-2 mb-sm-3 text-muted">Please try again with different Category or Keyword</p>
                        @endif
                    @else
                        @if (count($events) > 0)
                            <h2></h2>
                        @else
                            <h2>No Events found</h2>
                        @endif
                    @endif
                </div>
            </div>
            @if (count($events) > 0)
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

        <div id="tab-contents">
            {{-- grid view --}}
            <div class="tab-content smallGapGrid" id="grid">
                <div class="row">
                    @foreach($events as $key => $event)
                        <div class="col-12 col-md-6 col-lg-4 mb-3 mb-lg-4">
                            <div class="card directoryCard directory_block border-0 v3card">

                                <div class="location_img_wrap-event m-0">
                                    @if($event->image!='')<a class="d-block" href="{!! URL::to('events/'.$event->slug) !!}"><img src="{{URL::to('/').'/uploads/events/'}}{{$event->image}}"></a>@endif
                                </div>
                                <div class="card-body event-card-content">
                                    <h2 class="card-title"><a href="{!! URL::to('events/'.$event->slug) !!}">{{$event->title}}</a></h2>
                                    <h3 style="text-transform: capitalize!important;">{!! eventcategory($event->category_id) !!}</h3>

                                    <p>
                                        {!!strip_tags(substr($event->short_description,0,300))!!}
                                    </p>
                                    <ul>
                                        <li>
                                            <i class="fas fa-calendar"></i>
                                            <p>
                                                {{ date('j M, Y', strtotime($event->start_date)) }} - {{ date('j M, Y', strtotime($event->end_date)) }}
                                            </p>
                                        </li>
                                        @if(!empty($event->contact_email))
                                        <li>
                                            <i class="far fa-envelope"></i>
                                            <p>
                                                {{$event->contact_email}}
                                            </p>
                                        </li>
                                        @endif
                                        <li>
                                            <i class="fas fa-clock"></i>
                                            <p>
                                                {{ date('g:i A', strtotime($event->start_time)) }} - {{ date('g:i A', strtotime($event->end_time)) }}
                                            </p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $events->appends($_GET)->links() }}
                </div>
            </div>

            {{-- list view --}}
            <div class="tab-content smallGapGrid Bestdeals" id="list">
                <div class="row">
                  <ul class="search_list_items search_list_items-mod v3_list_view pre_event">
					@foreach($events as $key => $event)
                    <li class="directory_listblock">
                        <div class="location_img_wrap">
                            @if($event->image!='')<a class="d-block" href="{!! URL::to('events/'.$event->slug) !!}"><img src="{{URL::to('/').'/uploads/events/'}}{{$event->image}}"></a>@endif
                        </div>

                        <div class="list_content_wrap event-card-content d-block">
                            <h3>{!! eventcategory($event->category_id) !!}</h3>
                            <h2 class="card-title w-100"><a href="{!! URL::to('events/'.$event->slug) !!}">{{$event->title}}</a></h2>
                            <p class="mb-0">
                                {!!strip_tags(substr($event->short_description,0,300))!!}
                            </p>
                            <ul>
                                <li>
                                    <i class="fas fa-calendar"></i>
                                    <p>
                                        {{ date('j M, Y', strtotime($event->start_date)) }} - {{ date('j M, Y', strtotime($event->end_date)) }}
                                    </p>
                                </li>
                                @if(!empty($event->contact_email))
                                        <li>
                                            <i class="far fa-envelope"></i>
                                            <p>
                                                {{$event->contact_email}}
                                            </p>
                                        </li>
                                @endif
                                <li>
                                    <i class="fas fa-clock"></i>
                                    <p>
                                        {{ date('g:i A', strtotime($event->start_time)) }} - {{ date('g:i A', strtotime($event->end_time)) }}
                                    </p>
                                </li>
                            </ul>
                            <a href="http://54.206.45.247/deal/lorem-food-hub" class="location_btn">View Details <img src="http://54.206.45.247/site/images/right-arrow.png"></a>
                        </div>
                    </li>
                        @endforeach
                  </ul>
                    <div class="col-12">
                        <div class="d-flex justify-content-center mt-4">
                            {{ $events->appends($_GET)->links() }}
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
                            {{-- <input type="hidden" id="googlemapaddress" value=""> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@if (!empty(request()->input('keyword')))
@if ($events->count() == 0)
   @if(count($resp)>0)
        <section class="py-2 py-sm-4 py-lg-5 smallGapGrid">
            <div class="container">
                <div class="page-title best_deal">
                    <h2>Events closeby</h2>
                </div>
                <div>
                    <div class="smallGapGrid active">
                        <div class="row" id="relatedDirectories">
                            @foreach($resp as $key => $event)
                            {{-- {{dd($event)}} --}}
                                <div class="col-12 col-md-6 col-lg-4 mb-3 mb-lg-4">
                                    <div class="card directoryCard directory_block border-0 v3card">

                                        <div class="location_img_wrap-event m-0">
                                            @if($event['image']!='')<a class="d-block" href="{!! URL::to('events/'.$event['slug']) !!}"><img src="{{URL::to('/').'/uploads/events/'}}{{$event['image']}}"></a>@endif
                                        </div>
                                        <div class="card-body event-card-content">
                                            @foreach($event['category'] as $key => $cat)
                                            <h3>{{$cat['child_category']}}</h3>
                                            @endforeach
                                            <h2 class="card-title"><a href="{!! URL::to('events/'.$event['slug']) !!}">{{$event['name']}}</a></h2>
                                            <p>
                                                {!!strip_tags(substr($event['short_description'],0,300))!!}
                                            </p>
                                            <ul>
                                                <li>
                                                    <i class="fas fa-calendar"></i>
                                                    <p>
                                                        {{ date('j M, Y', strtotime($event['start_date'])) }} - {{ date('j M, Y', strtotime($event['end_date'])) }}
                                                    </p>
                                                </li>
                                                @if(!empty($event->contact_email))
                                                <li>
                                                    <i class="far fa-envelope"></i>
                                                    <p>
                                                        {{$event['contact_email']}}
                                                    </p>
                                                </li>
                                                @endif
                                                <li>
                                                    <i class="fas fa-clock"></i>
                                                    <p>
                                                        {{ date('g:i A', strtotime($event['start_time'])) }} - {{ date('g:i A', strtotime($event['end_time'])) }}
                                                    </p>
                                                </li>
                                            </ul>
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
                        <h2>Events closeby</h2>

                        <p class="mb-2 mb-sm-3">No closeby events found  </p>
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
    <script src="https://maps.google.com/maps/api/js?key=" type="text/javascript"></script>


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

                                    // $.each(value.child, (key1, value1) => {
                                    //     var url = "";

                                    //     if (type2 == 'business') {
                                    //         url = `{{url('/')}}/directory/${value1.slug}`;
                                    //     } else {
                                    //         url = "javascript: void(0)";
                                    //     }

                                    //     content += `<a class="dropdown-item ml-4" href="${url}" onclick="fetchCode('${value1.child_category}', ${value1.id}, '${type2}')">${value1.child_category}</a>`;
                                    // })
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
