@extends('site.app')
@section('title')Doctors & Hospitals @endsection
@section('description')
@endsection
<style>
    div.desc {
        margin-bottom: 15px;
    }
    .job-desc{
        height: 300px;
        overflow: hidden;
    }
</style>
@section('content')
    <section class="inner_banner articles_inbanner"
        style="background: url({{ asset('site/images/banner') }}-image.jpg) no-repeat center center; background-size:cover;">
        <div class="container position-relative">
            <div class="row m-0 mb-4">
                <h1>Doctors & Hospitals</h1>
            </div>
            <div class="page-search-block filterSearchBoxWraper" style="bottom: -83px;">
                <div class="filterSearchBox">
                    <form action="" id="checkout-form">
                        <div class="filterSearchBox">
                            <div class="row">
                                <div class="col-12 col-sm mb-2 mb-sm-0">
                                    <div class="form-floating">
                                        <input id="postcodefloting" type="text" class="form-control pl-3"
                                            name="key_details" placeholder="Postcode/ State"
                                            value="{{ request()->input('key_details') }}" autocomplete="off">
                                        <input type="hidden" name="keyword" value="{{ request()->input('keyword') }}">
                                        <label for="postcodefloting">Suburb or Postcode</label>
                                    </div>
                                    <div class="respDrop"></div>
                                </div>

                                {{-- <div class="mb-sm-0 col col-lg fcontrol position-relative filter_selectWrap filter_selectWrap2">
                                    <div class="select-floating">
                                        <div class="select-floating-admin">
                                            <select name="code" id="category" placeholder="Category"
                                                class="filter_select form-control @error('category') is-invalid @enderror">
                                                <option value="" hidden selected>Select a Category</option>
                                                @foreach ($category as $data)
                                                    <option value="{{ $data->id }}"
                                                        {{ request()->input('code') == $data->id ? 'selected' : '' }}>
                                                        {{ ucwords($data->title) }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <p class="small text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="col col-sm">
                                    <div class="form-floating">
                                        <input id="searchbykeyword" type="text" name="name" class="form-control pl-3"
                                            value="{{ request()->input('name') }}" placeholder="Search by keyword...">
                                        <label for="searchbykeyword" placeholder="Nom">Search by title</label>
                                    </div>
                                </div>
                                
                                <div class="col-auto col-sm-auto">
                                    <a href="javascript:void(0);" id="btnFilter"
                                        class="w-100 btn btn-blue text-center ml-auto"><img
                                            src="{{ asset('front/img/search.svg') }}"></a>
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
                <li class="active">Doctors & Hospitals</li>
            </ul>

            <div class="">
				@if (!empty(request()->input('keyword'))|| !empty(request()->input('name')))
				    @if ($newsList->count() > 0)
                        <h2 class="mb-2 mb-sm-3">Doctors & Hospitals found</h2>
				    @else
                        <h2 class="mb-2 mb-sm-3">No Doctors & Hospitals found</h2>

				        <p class="mb-2 mb-sm-3 text-muted">Please try again with different  filter</p>
				    @endif
                {{-- @else
                    <h2>No Job found</h2> --}}
				@endif
            </div>
            @if (count($doctorList) > 0)
            <section class="py-2 py-sm-2 py-lg-2 similar_postcode">
                <div class="row">
                    @foreach ($doctorList as $key => $data)
                    <div class="col-6 col-md-3 mb-2 mb-sm-4 mb-lg-3">
                        <div class="card directory-single-review">
                            <div class="card-body">
                              
                                <h5>{{ $data->title }}</h5>
                                <p>{{ $data->street_address.', '.$data->suburb.', '.$data->state.', '.$data->postcode }}</p>
                                <p>{{ $data->type }}</p>
                                <p>{{date('d/m/Y', strtotime($data->created_at)) }}</p>
                                <div class="desc">
                                    @if(strlen($data->description) > 200)
                                        <p>{{ substr($data->description,0,200) }} <small class="text text-primary More" style="cursor: pointer">...Read more</small></p>
        
                                        <p style="display: none">{{$data->descriptions}}<small class="text text-primary Less" style="cursor: pointer">Read less</small></p>
                                    @else
                                        <p>{{$data->description}}</p>
                                    @endif
                                </div>
                                <a type="button" class="job__list__btn text-right" style="font-size: 16px"
                                    href="{{route('doctors.detail',$data->slug)}}">
                                    Learn More
                                    </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>

            @endif
            <div class="d-flex justify-content-center mt-4">
                {{ $doctorList->appends($_GET)->links() }}
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script async src="https://static.addtoany.com/menu/page.js"></script>
<script>
    $('.showMore').click(function(){
        $(this).parent().hide();
        $(this).parent().next().show();
    })    
    $('.showLess').click(function(){
        $(this).parent().hide();
        $(this).parent().prev().show();
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
                            content +=
                                `<div class="dropdown-menu show w-100 postcode-dropdown" aria-labelledby="dropdownMenuButton">`;

                            $.each(result.data, (key, value) => {
                                if (value.type == 'pin') {
                                    content +=
                                        `<a class="dropdown-item" href="javascript: void(0)" onclick="fetchCode(${value.pin}, '${value.pin}', '${value.type}')"><strong>${value.pin}</strong></a>`;
                                } else if (value.type == 'suburb') {
                                    content +=
                                        `<a class="dropdown-item" href="javascript: void(0)" onclick="fetchCode('${value.suburb}', '${value.suburb}, ${value.short_state} ${value.pin}', '${value.type}')"><strong>${value.suburb}</strong>, ${value.short_state} ${value.pin}</a>`;
                                } else {
                                    content += ``;
                                }
                            })

                            if (result.data.length == 1) {
                                content = '';
                            }

                            content += `</div>`;
                        } else {
                            content +=
                                `<div class="dropdown-menu show w-100 postcode-dropdown" aria-labelledby="dropdownMenuButton"><li class="dropdown-item">${result.message}</li></div>`;
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
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                $('#checkout-form').submit();
            }
        });
    </script>
@endpush
