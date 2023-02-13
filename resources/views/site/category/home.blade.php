@extends('site.app')

@section('title'){{seoManagement('category_2')->title}}@endsection
@section('description'){{seoManagement('category_2')->meta_desc}}@endsection

{{-- @section('title')
@php
$meta_title=DB::table('seo_management')->where('page', '=', 'category_2')->get();
$title=$meta_title[0]->title;
$description=$meta_title[0]->meta_desc;
@endphp
 {{$title}}
@endsection --}}

@section('content')
    <section class="inner_banner articles_inbanner" style="background: url({{ asset('site/images/banner') }}-image.jpg) no-repeat center center; background-size:cover;">
        <div class="container position-relative">
            @if (!empty(request()->input('title')))
                @if ($data->count() > 0)
                    <h1> {{ (request()->input('title')) ? request()->input('title') : '' }} </h1><br>
                @endif
            @else
                <h1>Category</h1><br>
            @endif
            <div class="page-search-block filterSearchBoxWraper" style="bottom: -83px;">
                <form action="" id="checkout-form">
                    <div class="filterSearchBox">
                        <div class="row">
                            <div class="mb-sm-0 col col-lg fcontrol position-relative filter_selectWrap filter_selectWrap2">
                                {{-- <div class="select-floating">
                                    <img src="{{ asset('front/img/grid.svg')}}">
                                    <label>Category</label>
                                    <select class="filter_select form-control" name="title">
                                        <option value="" hidden selected>Select Category...</option>
                                        @foreach ($allCategories as $index => $item)
                                            <option value="{{$item->parent_category}}" {{ (request()->input('parent_category') == $item->parent_category) ? 'selected' : '' }}>{{ $item->parent_category }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <div class="dropdown">
                                    <div class="form-floating drop-togg" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <input id="postcodefloting" type="text" class="form-control pl-3" name="title" placeholder="Category" value="{{ request()->input('title') }}" autocomplete="off">
                                        <input type="hidden" name="code" value="{{ request()->input('code') }}">
                                        <input type="hidden" name="type" value="{{ request()->input('type') }}">
                                        <label for="postcodefloting">Category</label>
                                    </div>
                                    <div class="respDrop"></div>
                                </div>
                            </div>
                            {{-- <div class="col-auto">
                                <a href="javascript:void(0);" id="btnFilter" class="w-100 btn btn-blue text-center ml-auto"><img src="{{ asset('front/img/search.svg')}}"></a>
                            </div> --}}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="py-2 py-sm-4 py-lg-5">
        <div class="container pt-4">
            <div class="d-flex justify-content-between align-items-center cafe-listing-nav pb-0">
                <ul class="d-flex" id="tabs-nav">
                    <li class="active">
                        @if (!empty(request()->input('title')))
                            @if ($data->count() > 0)
                                <h3 class="mb-2 mb-sm-3">Results found for "{{ (request()->input('title')) ? request()->input('title') : '' }}"</h3>
                            @else
                                <h3 class="mb-2 mb-sm-3">No results found for {{ (request()->input('title')) ? request()->input('title') : '' }} </h3>
                            @endif
                        @else
                            <h3 class="mb-2 mb-sm-3">All Category</h3>
                        @endif

                        <p class="mb-2 mb-sm-3 text-muted">
                            Welcome to our Category section. Here you can search for businesses near you by category.
                        </p>
                    </li>
                </ul>
            </div>

            <div class="row justify-content-center">
                @foreach ($data as $key => $category)
                    <div class="col-6 col-md-4 mb-4">
                        <div class="smplace_card text-center">
                            @if (!empty($category->parent_category_image))
                                <img  src="{{URL::to('/').'/categories/'}}{{$category->parent_category_image}}">
                            @else
                                @php
                                    $demoImage = DB::table('demo_images')->where('title', '=', 'category')->get();
                                    $demo = $demoImage[0]->image;
                                @endphp

                                <img src="{{URL::to('/').'/Demo/'}}{{$demo}}" class="card-img-top">
                            @endif
                            <h4><a href="{!! URL::to('category/' . $category->parent_category_slug) !!}" class="location_btn">{{ $category->parent_category }} </a></h4>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $data->appends($_GET)->links() }}
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).on("click", "#btnFilter", function() {
            $('#checkout-form').submit();
        });
    </script>
    <script>
     $('body').on('click', function() {
        //code
        $('.postcode-dropdown').hide();
    });

    $('input[name="title"]').on('click', function() {
        var content = '';

        @php
            $primaryCat = \DB::table('directory_categories')->where('type', 1)->where('status', 1)->limit(5)->get();
        @endphp

        content += `<div class="dropdown-menu show w-100 postcode-dropdown">`;

        @foreach($primaryCat as $category)
            content += `<a class="dropdown-item" href="{{ URL::to('category/'.$category->parent_category_slug) }}" onclick="fetchCode('{{$category->parent_category}}', {{$category->id}}, 'primary')">{{$category->parent_category}}</a>`;
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
                            content += `<div class="dropdown-menu show w-100 postcode-dropdown">`;

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
                                `<div class="dropdown-menu show w-100 postcode-dropdown" aria-labelledby="dropdownMenuButton"><li class="dropdown-item">${result.message}</li></div>`;
                        }
                        $('.respDrop').html(content);
                    }
                });
            } else {
                $('.respDrop').text('');
            }
        });
        $('input[name="title"]').on('keyup', function() {
            var $this = 'input[name="title"]'

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
                            content += `<div class="dropdown-menu show w-100 postcode-dropdown">`;

                            $.each(result.data, (key, value) => {
                                var type = '';
                                if(value.type == "primary") {
                                    type1 = 'primary';
                                    type2 = 'secondary';
                                } else {
                                    type1 = 'secondary';
                                    type2 = 'business';
                                }
                                console.log(type2);
                                        var url = "";
                                        // if (type1 == 'primary') {
                                        //     url = `{{url('/')}}/category/${value.slug}`;
                                        // } else {
                                        //     url = `{{url('/')}}/category/${value.slug}`;
                                        // }

                                        if (type1 == 'primary') {
                                            url = `{{url('/')}}/category/${value.slug}`;
                                        } else {
                                            url =  `{{url('/')}}/category/${value.slug}`;
                                        }
                                        if (type2 == 'secondary') {
                                            url = `{{url('/')}}/category/${value.slug}`;
                                        } else {
                                            url = `{{url('/')}}/category/${value.slug}`;
                                        }

                                content += `<a class="dropdown-item" href="${url}" onclick="fetchCode('${value.title}', ${value.id}, '${type1}')">${value.title}</a>`;

                                if (value.child.length > 0) {
                                    // content += `<h6 class="dropdown-header">Secondary</h6>`;

                                    $.each(value.child, (key1, value1) => {
                                        var url = "";

                                        if (type2 == 'business') {
                                            url = `{{url('/')}}/directory/${value1.slug}`;
                                        } else {
                                            url =  `{{url('/')}}/category/${value1.child_category_slug}`;
                                        }

                                        content += `<a class="dropdown-item ml-4" href="${url}" onclick="fetchCode('${value1.child_category}', ${value1.id}, '${type2}')">${value1.child_category}</a>`;
                                    })
                                }
                            })

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

        function fetchCode(item, code, type) {
            $('.postcode-dropdown').hide()
            $('input[name="title"]').val(item)
            $('input[name="code"]').val(code)
            $('input[name="type"]').val(type)
        }
        $(document).keypress(function(event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);  if(keycode == '13'){    $('#checkout-form').submit();
         }
        });
</script>
@endpush
