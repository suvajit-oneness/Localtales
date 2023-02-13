@extends('admin.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    <div class="app-title">
        <div>
            @php
            if (!empty(request()->input('collection'))) {
            $cid = request()->input('collection');
            $data = App\Models\Collection::where('id', $cid)
                ->get();
            } else {
                $data = 'new';
                $cid ='';
            }
           @endphp
            <h1><i class="fa fa-tags"></i> Business under {{ $collection[0]->title }}</h1>
        </div>
    </div>
    @include('admin.partials.flash')
    @php
    if (!empty(request()->input('collection'))) {
        $cid = request()->input('collection');
        $data = App\Models\CollectionDirectory::where('collection_id', $cid)
            ->with('directory')
            ->get();
    } else {
        $data = 'new';
        $cid ='';
    }
    @endphp
    <div class="row">
        <div class="col-md-12">
            <h3 class="tile-title">
                <span class="top-form-btn">
                    <a class="btn btn-secondary" href="{{ route('admin.collectiondir.index') }}"><i
                            class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                </span>
            </h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mx-auto pt-5 border-right">
            <table class="table table-hover custom-data-table-style table-striped" id="collectionDirectorydetails">
                <thead>
                    <tr>
                        <th></th>
                        <th>SR No</th>
                        <th> Name </th>
                    </tr>
                </thead>
                <tbody id="unique-tr">
                    @foreach($data as $key => $blog)
                        <tr>
                            <td>
                                <input  class="tap-to-delete" type="checkbox"  value="{{$blog->id}}" name="directory_id[]" checked>
                            </td>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $blog->directory->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        <div class="col-md-6 mx-auto">
            <div class="tile border mt-5">
                {{-- <h3 class="tile-title">{{ $subTitle }}
                    <span class="top-form-btn">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save
                            Directory</button>
                        <a class="btn btn-secondary" href="{{ route('admin.collectiondir.index') }}"><i
                                class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3> --}}
                <hr>
                <form action="{{ route('admin.collectiondir.store') }}" method="POST" role="form"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="pin"> Collection <span class="m-l-5 text-danger">
                                    *</span></label>
                            <select class="form-control" name="collection_id">
                                <option value="">Select Collection...</option>
                                @foreach ($col as $index => $item)
                                    <option value="{{ $item->id }}" {{ $item->id == $cid ? 'selected' : '' }}>
                                        {{ $item->title }}</option>
                                @endforeach
                            </select>
                            @error('collection_id')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <input type="hidden" name="directory_id" id="directory_id" value="">
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label"> Directory <span class="m-l-5 text-danger">
                                    *</span></label>
                                    <div class="col-12 col-lg-12">
                                        <div class="page-search-block filterSearchBoxWraper">
                                            <div class="filterSearchBox">
                                                <form action="{{ route('admin.collectiondir.create') }}">
                                                    <div class="row">
                                                        <div class="col-6 mb-2 mb-sm-0 col-md fcontrol position-relative filter_selectWrap">
                                                            <div class="form-floating">
                                                                <input id="postcodefloting" type="text" class="form-control pl-3" name="key_details" placeholder="Postcode/ State" value="{{ request()->input('key_details') }}" autocomplete="off">
                                                                <input type="hidden" name="keyword" value="{{ request()->input('keyword') }}">
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
                                                                </div>
                                                                <div class="respDrop"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col col-md fcontrol position-relative filter_selectWrap">
                                                            <div class="form-floating">
                                                                <input type="text" id="keywordfloting" class="form-control pl-3" name="name" placeholder="rating" value="{{ request()->input('rating') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col col-md fcontrol position-relative filter_selectWrap">
                                                            <div class="form-floating">
                                                                <input type="text" id="keywordfloting" class="form-control pl-3" name="name" placeholder="Keyword" value="{{ request()->input('name') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="submit" class="btn btn-outline-danger btn-sm">Search </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="show_checkboxes" class="row">
                                    @if ($directoryList != 'new')
                                    @if(isset($request->code) || isset($request->keyword) ||isset($request->name)||isset($request->rating))
                                        @foreach ($directoryList as $value)
                                            <label id="directory_{{ $value->id }}" class="d-flex m-3"
                                                style="flex-direction: row-reverse; align-items: center;">{{ $value->name }}<input
                                                    checked type="checkbox" name="id[]"
                                                    onClick="removeCheckbox('{{ $value->id }}')"
                                                    value="{{ $value->id }}"></label>
                                        @endforeach
                                        @else
                                        @foreach ($directoryList as $value)
                                            <label id="directory_{{ $value->directory->id }}" class="d-flex m-3"
                                                style="flex-direction: row-reverse; align-items: center;">{{ $value->directory->name }}<input
                                                    checked type="checkbox" name="directory_id[]"
                                                    onClick="removeCheckbox('{{ $value->directory->id }}')"
                                                    value="{{ $value->directory->id }}"></label>
                                        @endforeach
                                    @endif
                                    @endif
                                </div>
                           {{--   <div id="show_checkboxes" class="row">
                                @if ($data != 'new')
                                    @foreach ($data as $value)
                                        <label id="directory_{{ $value->directory_id }}" class="d-flex m-3"
                                            style="flex-direction: row-reverse; align-items: center;">{{ $value->directory->name }}<input
                                                checked type="checkbox" name="directory_id[]"
                                                onClick="removeCheckbox('{{ $value->directory_id }}')"
                                                value="{{ $value->directory_id }}"></label>
                                    @endforeach
                                @endif
                            </div>
                            <div class="d-flex">
                            <input type="search" class="form-control dropdown-toggle" id="searchName" value=""
                                placeholder="Search Directory name" data-toggle="dropdown">
                                <button class="btn btn-primary p-1">
                                    <i class="fa fa-search"></i>
                                </button>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                   filter
                                  </button>
                            </div>
                            <div class="respDrop" style="position: relative;"></div>
                            @error('directory_id')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>--}}
                    </div>
                    <div class="col-auto">
                    <form action="{{ route('admin.collectiondir.create') }}">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <div class="form-floating">
                                <input id="postcodefloting" type="text" class="form-control pl-3" name="key_details" placeholder="Postcode/ State" value="{{ request()->input('key_details') }}" autocomplete="off">
                                                                <input type="hidden" name="keyword" value="{{ request()->input('keyword') }}">
                            </div>
                        </div>
                            <div class="respData"></div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-outline-danger btn-sm">Search Collection </button>
                            </div>
                        </div>
                    </form>
                </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save
                            Collection</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.collectiondir.index') }}"><i
                                class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="col-12 col-lg-12">
                    <div class="page-search-block filterSearchBoxWraper">
                        <div class="filterSearchBox">
                            <form action="">
                                <div class="row">
                                    <div class="col-6 mb-2 mb-sm-0 col-md fcontrol position-relative filter_selectWrap">
                                        <div class="form-floating">
                                            <input id="postcodefloting" type="text" class="form-control pl-3" name="key_details" placeholder="Postcode/ State" value="{{ request()->input('key_details') }}" autocomplete="off">
                                            <input type="hidden" name="keyword" value="{{ request()->input('keyword') }}">
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
                                            </div>
                                            <div class="respDrop"></div>
                                        </div>
                                    </div>
                                    <div class="col col-md fcontrol position-relative filter_selectWrap">
                                        <div class="form-floating">
                                            <input type="text" id="keywordfloting" class="form-control pl-3" name="name" placeholder="rating" value="{{ request()->input('rating') }}">
                                        </div>
                                    </div>
                                    <div class="col col-md fcontrol position-relative filter_selectWrap">
                                        <div class="form-floating">
                                            <input type="text" id="keywordfloting" class="form-control pl-3" name="name" placeholder="Keyword" value="{{ request()->input('name') }}">
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
            <div id="show_checkboxes" class="row">
                @if ($directoryList != 'new')
                    @foreach ($directoryList as $value)
                        <label id="directory_{{ $value->id }}" class="d-flex m-3"
                            style="flex-direction: row-reverse; align-items: center;">{{ $value->name }}<input
                                checked type="checkbox" name="id[]"
                                onClick="removeCheckbox('{{ $value->id }}')"
                                value="{{ $value->id }}"></label>
                    @endforeach
                @endif
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
@endsection
@push('scripts')
<script
  src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script type="text/javascript">
       /* $(document).on("click", "#btnFilter", function() {
            $('#checkout-form').submit();
        });*/
    </script>

    <script>
        // state, suburb, postcode data fetch
        $('#search').on('keyup', function() {
            $value = $(this).val();
            $.ajax({
                type: 'get',
                url: '{{ URL::to('admin/collectiondirectory') }}',
                data: {
                    'search': $value
                },
                success: function(data) {
                    $('input').html(data);
                }
            });
        })
    </script>
    <script>
        // store name search
        $('#searchName').on('keyup', function() {

            var $this = '#searchName'

            if ($($this).val().length > 0) {
                $.ajax({
                    url: '{{ route('directory.search') }}',
                    method: 'post',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        name: $($this).val(),

                    },
                    success: function(result) {
                        var content = '';
                        if (result.error === false) {
                            content +=
                                `<div class="dropdown-menu row show w-100 postcode-dropdown" style="display: flex; position: absolute; top: 0px;" aria-labelledby="dropdownMenuButton">`;

                            $.each(result.data, (key, value) => {
                                if ($('#directory_' + value.id).length > 0) {
                                    content +=
                                        `<label class="d-flex m-3" style="flex-direction: row-reverse; align-items: center;">${value.name}<input onClick="setDirectory('${value.name}','${value.id}', this)" type="checkbox" checked value="${value.id}" onChange="getResult(this)"></label>`
                                } else {
                                    content +=
                                        `<label class="d-flex m-3" style="flex-direction: row-reverse; align-items: center;" >${value.name}<input onClick="setDirectory('${value.name}','${value.id}', this)" type="checkbox" value="${value.id}" onChange="getResult(this)"></label>`
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

        function setDirectory(x, y, z) {
            if (z.checked == true) {
                let tableRow = $('#collectionDirectorydetails tr').length
                if ($('#directory_' + y).length <= 0) {
                    $('#unique-tr').append(`
                        <tr>
                            <td><input  class="tap-to-delete" type="checkbox"  value="${y}" name="directory_id[]" checked></td>
                            <td>${tableRow}</td>
                            <td>${x}</td>
                        </tr>
                    `)
                    $('#show_checkboxes').append(
                        `<label id="directory_${y}" class="d-flex m-3" style="flex-direction: row-reverse; align-items: center;" >${x}<input checked type="checkbox" name="directory_id[]" onClick="removeCheckbox('${y}')" value="${y}"></label>`
                    )
                } else {
                    console.log('Hello');
                    $('#directory_' + y).remove();
                }
            } else {
                $('#directory_' + y).remove();
            }
            $('#searchName').val('');
            $('.respDrop').html('');
            $('#searchName').focus();
        }

        function removeCheckbox(x) {
            $('#directory_' + x).remove();
        }

        function getResult(el) {
            console.log('outer');
            var markup = "<tr><td>1</td><td>value</td></tr>";
            if($(el).find('input').is(':checked')) {
                console.log("inner");
                $('#collectionDirectorydetails tbody').append(markup);
            }
        }
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
     /*   $(document).on("click", "#btnFilter", function() {
            $('#checkout-form').submit();
        });*/
    </script>

@endpush
