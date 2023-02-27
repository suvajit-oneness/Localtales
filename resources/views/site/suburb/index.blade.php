@extends('site.app')

@section('title'){{seoManagement('suburb')->title}}@endsection
@section('description'){{seoManagement('suburb')->meta_desc}}@endsection

@section('content')
    <section class="inner_banner articles_inbanner"
        style="background: url({{ asset('site/images/banner') }}-image.webp) no-repeat center center; background-size:cover;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 mb-4">
                    <h1>Suburb</h1>
                </div>
                <div class="col-12 col-lg-12">
                    <div class="page-search-block filterSearchBoxWraper">
                        <div class="filterSearchBox">
                            <form action="" id="checkout-form">
                                <div class="filterSearchBox">
                                    <div class="row">
                                        <div class="col col-sm">
                                            <div class="form-floating">
                                                <input id="postcodefloting" type="text" class="form-control pl-3" name="key_details" placeholder="Postcode/ State" value="{{ request()->input('key_details') }}" autocomplete="off">
                                                <input type="hidden" name="keyword" value="{{ request()->input('keyword') }}">
                                                <label for="postcodefloting">Suburb, Postcode or State</label>
                                            </div>
                                        </div>
                                        <div class="respDrop"></div>
                                        <div class="col-auto col-sm-auto">
                                            <a href="javascript:void(0);" id="btnFilter" class="w-100 btn btn-blue text-center ml-auto"><img src="{{ asset('front/img/search.svg') }}" width="20px" height="20px" alt=""></a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- BLOG SEARCH RESULT --}}
    <section class="postcode_main pb-5">
        <div class="container">
            <div class="">
                 @if (!empty(request()->input('key_details'))|| !empty(request()->input('name')))
                    @if ($suburb->count() > 0)
                        <h3 class="mb-2 mb-sm-3">Results found for "{{ request()->input('key_details') }}"
                           {{ (!empty(request()->input('key_details')) && !empty(request()->input('name'))) ? '  ' : '' }}
                           {{ (request()->input('name')) }}</h3>
                    @else
                        <h3 class="mb-2 mb-sm-3">No Results found for
                           "{{ request()->input('key_details')}}" {{ (!empty(request()->input('key_details')) && !empty(request()->input('name'))) ? '  ' : '' }}  {{ (request()->input('name'))}}</h3>

                        <p class="mb-2 mb-sm-3 text-muted">Please try again with different Postcode or keyword</p>
                    @endif
                @else
                    <h3 class="mb-2 mb-sm-3">All Suburb</h3>
                    <p class="mb-2 mb-sm-3 text-muted">
                        Welcome to our Suburbs section. Here you can search for businesses, deals, events, and much more in your local community.
                    </p>
                @endif
            </div>
            <div class="row justify-content-center">
                @foreach ($suburb as $key => $blog)
                    @if($blog->status == 0) @continue @endif
                    <div class="col-6 col-md-4 mb-4">
                        <div class="smplace_card text-center">
                            @if($blog->image)
                                <img src="{{asset('/admin/uploads/suburb/'. $blog->image)}}" class="card-img-top">
                            @else
                                @php
                                    $demoImage = DB::table('demo_images')->where('title', '=', 'suburb')->get();
                                    $demo = $demoImage[0]->image;
                                @endphp
                                <img src="{{URL::to('/').'/Demo/'}}{{$demo}}" class="card-img-top">
                            @endif
                            <h4><a href="{!! URL::to('suburb/' . $blog->slug) !!}" class="location_btn">{{ $blog->name }} </a></h4>
                            <p>{!! $blog->description !!}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-center mt-4">{{ $suburb->appends($_GET)->links() }}</div>
        </div>
    </section>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).on("click", "#btnFilter", function() {
            $('#checkout-form').submit();
        });
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

                                }
                                else {
                            		content += `<a class="dropdown-item" href="javascript: void(0)" onclick="fetchCode('${value.state}', '${value.state} ${value.pin}', '${value.type}')"><strong>${value.state}</strong> ${value.pin}</a>`;
                            	}
                            })
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
    </script>
@endpush
