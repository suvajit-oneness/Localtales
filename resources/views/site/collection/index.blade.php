@extends('site.app')

@section('title'){{seoManagement('collection')->title}}@endsection
@section('description'){{seoManagement('collection')->meta_desc}}@endsection

@section('content')
<section class="inner_banner articles_inbanner" style="background: url({{asset('site/images/banner')}}-image.webp) no-repeat center center; background-size:cover;">
	<div class="container position-relative">
        <div class="row m-0 mb-4">
            <h1>Collection</h1>
        </div>
        <div class="page-search-block filterSearchBoxWraper" style="bottom: -83px;">
            <div class="filterSearchBox">
                <form action="" id="checkout-form">
                    <div class="filterSearchBox">
                        <div class="row">
                            <div class="col-12 col-sm mb-2 mb-sm-0">
                                {{-- <input type="" class="form-control" name="pin_code" placeholder="Postcode" value="{{ $request->pin_code ? $request->pin_code : '' }}"  autocomplete="off">
                                <div class="respDrop"></div> --}}
                                <div class="form-floating">
                                <input id="postcodefloting" type="text" class="form-control pl-3" name="key_details" placeholder="Postcode/ State" value="{{ request()->input('key_details') }}" autocomplete="off">
                                    <input type="hidden" name="keyword" value="{{ request()->input('keyword') }}">
                                    <label for="postcodefloting">Suburb or Postcode</label>
                                </div>
                                <div class="respDrop"></div>
                            </div>
                            <!-- <input id="searchbykeyword" type="hidden" name="suburb" class="form-control pl-3"  value="{{ request()->input('suburb') }}" placeholder="Search by suburb...">--}}
                            <div class="col-6 col-sm mb-2">
                                <div class="form-floating">
                                    <input id="searchbykeyword" type="text" name="category" class="form-control pl-3"  value="{{ request()->input('category') }}" placeholder="Search by Category...">
                                    <label for="searchbykeyword" placeholder="Nom">Category</label>
                                </div>
                            </div> -->
                            <div class="col col-sm">
                                <div class="form-floating">
                                    <input id="searchbykeyword" type="text" name="name" class="form-control pl-3" value="{{ request()->input('name') }}" placeholder="Search by keyword...">
                                    <label for="searchbykeyword" placeholder="Nom">Search by keyword</label>
                                </div>
                            </div>
                            <div class="col-auto col-sm-auto">
                                <a href="javascript:void(0);" id="btnFilter" class="w-100 btn btn-blue text-center ml-auto"><img src="{{ asset('front/img/search.svg')}}" width="20px" height="20px" alt=""></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
	</div>
</section>

<section class="pb-5 light-bg more-collection more_collection_bredcumb more-collection__mobile">
    <div class="container">
        <ul class="breadcumb_list mb-4">
            <li><a href="{!! URL::to('/') !!}">Home</a></li>
            <li>/</li>
            <li class="active">Collection</li>
        </ul>

        <div class="d-flex justify-content-between align-items-center cafe-listing-nav">
            <ul class="d-flex" id="tabs-nav">
               <li class="active">
                    <a href="#all-collections">
                        @if (!empty($request->name) || !empty($request->keyword) || !empty($request->suburb) || !empty($request->category))
                            @if ($data->count() > 0)
                                Collections with {{ ($request->name) ? 'keyword '.$request->name : '' }} {{ (isset($request->name) && isset($request->keyword) && isset($request->suburb)) ? ' & ' : '' }} {{ ($request->state) ? 'state "'.$request->state.'"' : '' }} {{ ($request->keyword) ? 'keyword "'.$request->keyword.'"' : '' }} {{ ($request->suburb) ? 'suburb "'.$request->suburb.'"' : '' }} {{ ($request->category) ? 'category "'.$request->category.'"' : '' }}
                            @else
                                No collections found for {{ ($request->name) ? 'keyword '.$request->name : '' }} {{ (isset($request->name) && isset($request->keyword) && isset($request->suburb)) ? ' & ' : '' }} {{ ($request->keyword) ? 'keyword "'.$request->keyword.'"' : '' }} {{ ($request->suburb) ? 'suburb "'.$request->suburb.'"' : '' }} {{ ($request->category) ? 'category "'.$request->category.'"' : '' }}
                            @endif
                        @else
                            All Collections
                        @endif
                    </a>
                </li>
               <li class="">
                    <a href="#saved-collections">
                        Saved collection
                    </a>
                </li>
            </ul>
        </div>

        <div id="tab-contents">
            <div class="tab-content" id="all-collections" style="">
                <div class="row">
                    @foreach($data as $collectionKey => $collectionVal)
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                            <div class="card collectionCard">
                                <a class="cardLink d-block" href="{!! URL::to('collection/' . $collectionVal->slug) !!}">
                                    @if($collectionVal->image)
                                        <img src="{{URL::to('/').'/Collection/'}}{{$collectionVal->image}}" alt="">
                                    @else
                                    @php
                                        $demoImage=DB::table('demo_images')->where('title', '=', 'collection')->get();
                                        $demo=$demoImage[0]->image;
                                        //dd($demoImage);
                                    @endphp
                                        <img src="{{URL::to('/').'/Demo/'}}{{$demo}}">
                                    @endif

                                    <div class="card-body">
                                        <h4 class="location_btn">{{ ucwords(str_replace('XX', ' ', $collectionVal->title)) }}</h4>
                                    </div>
                                </a>
                            </div>
                        </div>
                        {{-- @php
                            $blogs = \App\Models\CollectionDirectory::where('collection_id',$collectionVal->id)->with('directory')->get();
                            $item = $blogs->count();

                        @endphp
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                            <div class="card collectionCard">
                                <a class="cardLink d-block" href="{!! URL::to('collection/' . $collectionVal->slug) !!}">
                                    @if($collectionVal->image)
                                        <img src="{{URL::to('/').'/Collection/'}}{{$collectionVal->image}}" alt="">
                                    @else
                                    @php
                                        $demoImage=DB::table('demo_images')->where('title', '=', 'collection')->get();
                                        $demo=$demoImage[0]->image;
                                        //dd($demoImage);
                                    @endphp
                                            <img src="{{URL::to('/').'/Demo/'}}{{$demo}}">
                                    @endif
                                    @if($item==0)
                                        <div class="card-body">
                                            <h4 class="location_btn">{{str_replace('XX', ' ', $collectionVal->title )}}</h4>
                                        </div>
                                    @else
                                        <div class="card-body">
                                            <h4 class="location_btn">{{str_replace('XX', $item, $collectionVal->title )}}</h4>
                                        </div>
                                    @endif
                                </a>
                            </div>
                        </div> --}}
                    @endforeach
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $data->appends($_GET)->links() }}
                </div>
            </div>

            <div class="tab-content" id="saved-collections" style="">
                <div class="row">
                    @php
                        $ip = $_SERVER['REMOTE_ADDR'];

                        if (auth()->guard('user')->check()) {
                            $savedData = \App\UserCollection::where('user_id', auth()->guard('user')->user()->id)->orWhere('ip', $ip)->get();
                        } else {
                            $savedData = \App\UserCollection::where('ip', $ip)->get();
                        }
                    @endphp

                    @forelse($savedData as $savedCollectionKey => $savedCollectionVal)
                        @if(!$savedCollectionVal->collection)
                            <p></p>
                        @else
                            <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                                <div class="card collectionCard">
                                    <a class="cardLink d-block" href="{!! URL::to('collection/' . $savedCollectionVal->collection->slug) !!}">
                                        @if($savedCollectionVal->collection->image!='')
                                        <img src="{{URL::to('/').'/Collection/'}}{{$savedCollectionVal->collection->image}}" alt="">
                                        @else
                                        @php
                                        $demoImage=DB::table('demo_images')->where('title', '=', 'collection')->get();
                                        $demo=$demoImage[0]->image;
                                        //dd($demoImage);
                                        @endphp
                                            <img src="{{URL::to('/').'/Demo/'}}{{$demo}}">
                                         @endif
                                        <div class="card-body">
                                            <h4 class="location_btn">{{ $savedCollectionVal->collection->title }}</h4>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="col-12">
                            <p>Nothing here! Go &amp; save some collections to access them quicker</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</section>

@endsection

@push('scripts')
    <script>
        $('body').on('click', function() {
            //code
            $('.postcode-dropdown').hide();
        });

       // state, suburb, postcode data fetch
       $('input[name="key_details"]').on('keyup', function() {
            var $this = 'input[name="key_details"]'

            if ($($this).val().length > 0) {
                $('input[name="keyword"]').val($($this).val())
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
                                    content += `<a class="dropdown-item" href="javascript: void(0)" onclick="fetchCode(${value.pin}, '${value.pin}', '${value.type}')"><strong>${value.pin}</strong></a>`;
                            	} else if(value.type == 'suburb') {
                            		content += `<a class="dropdown-item" href="javascript: void(0)" onclick="fetchCode('${value.suburb}', '${value.suburb}, ${value.short_state} ${value.pin}', '${value.type}')"><strong>${value.suburb}</strong>, ${value.short_state} ${value.pin}</a>`;
                                } else {
                                    content += ``;
                                }
                            })

                            if(result.data.length == 1) {
                                content = '';
                            }

                            content += `</div>`;
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

        function fetchCode(keyword, details, type) {
            $('.postcode-dropdown').hide()
            $('input[name="keyword"]').val(keyword)
            $('input[name="key_details"]').val(details)
        }
        $(document).on("click", "#btnFilter", function() {
            $('#checkout-form').submit();
        });
        $(document).keypress(function(event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);  if(keycode == '13'){    $('#checkout-form').submit();
         }
        });

    </script>
@endpush