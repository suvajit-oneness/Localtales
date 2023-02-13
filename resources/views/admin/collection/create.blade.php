@extends('admin.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}
                    <span class="top-form-btn">
                        <a class="btn btn-secondary" href="{{ route('admin.collection.index') }}"><i
                                class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('admin.collection.store') }}" method="POST" role="form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="control-label" for="meta_key">Keyword <span class="m-l-5 text-danger">
                                *</span></label>
                        <input class="form-control @error('meta_key') is-invalid @enderror" type="text" name="meta_key"
                            id="meta_key" value="{{ old('meta_key') }}" />
                        @error('meta_key')
                            <p class="small text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="title"> Collection Name <span
                                    class="m-l-5 text-danger">*</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title"
                                id="title" value="{{ old('title') }}" />
                            @error('title')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        {{--  <div class="tile-body">
                            <div class="form-group">
                                <label class="control-label" for="pin"> Suburb <span class="m-l-5 text-danger">
                                        *</span></label>
                                <select class="form-control" name="suburb">
                                    <option value="" hidden selected>Select Suburb...</option>
                                    @foreach ($suburb as $index => $item)
                                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('suburb')
                                    <p class="small text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>--}}
                        <div class="page-search-block filterSearchBoxWraper" style="bottom: -83px;">
                            <div class="filterSearchBox">
                                <div class="row">
                                    <div class="mb-sm-0 col col-lg fcontrol position-relative filter_selectWrap filter_selectWrap2">
                                        <div class="select-floating-admin">
                                            <label>Suburb<span class="m-l-5 text-danger">
                                                *</span></label>
                                            <select class="filter_select form-control" name="suburb">
                                                <option value="" hidden selected>Select Suburb...</option>
                                                @foreach ($suburb as $index => $item)
                                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="category">Category</label>
                            <input class="form-control" name="category" id="category" value="{{ old('category') }}" />
                            @error('category')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label class="control-label" for="description">Collection Description</label>
                            <textarea class="form-control" rows="4" name="description" id="description">{{ old('description') }}</textarea>
                            {{-- <input name="meta_description" type="text" id="upload" onchange="" hidden> --}}
                            @error('description')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="meta_title"> Meta Title <span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control @error('meta_title') is-invalid @enderror" type="text" name="meta_title"
                                id="meta_title" value="{{ old('meta_title') }}" />
                            @error('meta_title')
                                {{ $message ?? '' }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="meta_description"> Meta Description <span class="m-l-5 text-danger">
                                    *</span></label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror" type="text"
                                name="meta_description" id="summernote-meta_description">{{ old('meta_description') }}</textarea>
                            @error('meta_description')
                                {{ $message ?? '' }}
                            @enderror
                        </div>


                        <div class="form-group">
                            <label class="control-label" for="pin_code">Postcode</label>
                            <input class="form-control" rows="4" name="pin_code" id="pin_code"
                                value="{{ old('pin_code') }}" />
                            @error('pin_code')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="paragraph1_heading">Paragraph1 Heading</label>
                            <input class="form-control" name="paragraph1_heading" id="paragraph1_heading"
                                value="{{ old('paragraph1_heading') }}" />
                            @error('paragraph1_heading')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="paragraph1">Paragraph1</label>
                            <textarea class="form-control" rows="4" name="paragraph1" id="paragraph1">{{ old('paragraph1') }}</textarea>
                            @error('paragraph1')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="paragraph2_heading">Paragraph2 Heading</label>
                            <input class="form-control" name="paragraph2_heading" id="paragraph2_heading"
                                value="{{ old('paragraph2_heading') }}">
                            {{-- <input name="paragraph2_heading" type="text" id="upload" onchange="" hidden> --}}
                            @error('paragraph2_heading')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="paragraph2">Paragraph2</label>
                            <textarea class="form-control" rows="4" name="paragraph2" id="paragraph2">{{ old('paragraph2') }}</textarea>
                            @error('paragraph2')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="paragraph3_heading">Paragraph3 Heading</label>
                            <input class="form-control" name="paragraph3_heading" id="paragraph3_heading"
                                value="{{ old('paragraph3_heading') }}">
                            {{-- <input name="paragraph3_heading" type="text" id="upload" onchange="" hidden> --}}
                            @error('paragraph3_heading')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="paragraph3">Paragraph3</label>
                            <textarea class="form-control" rows="4" name="paragraph3" id="paragraph3">{{ old('paragraph3') }}</textarea>
                            {{-- <input name="paragraph3" type="text" id="upload" onchange="" hidden> --}}
                            @error('paragraph3')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="google_doc">Google Doc</label>
                            <input class="form-control" name="google_doc" id="google_doc"
                                value="{{ old('google_doc') }}">
                            {{-- <input name="google_doc" type="text" id="upload" onchange="" hidden> --}}
                            @error('google_doc')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="completion">Completion</label>
                            <input class="form-control" name="completion" id="completion"
                                value="{{ old('completion') }}">
                            {{-- <input name="completion" type="text" id="upload" onchange="" hidden> --}}
                            @error('completion')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label"> Directory <span class="m-l-5 text-danger">
                                    *</span></label>
                            <div id="show_checkboxes" class="row">

                            </div>
                            <input type="search" class="form-control dropdown-toggle" id="searchName" value=""
                                placeholder="Search Directory name" data-toggle="dropdown">
                            <div class="respDrop" style="position: relative;"></div>
                            @error('directory_id')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label"> Image</label>
                            <p class="small text-danger mb-2">Size must be less than 200kb</p>
                            <input class="form-control @error('image') is-invalid @enderror" type="file"
                                id="image" name="image" />
                            @error('image')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save
                            Collection</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.collection.index') }}"><i
                                class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        $(document).on("click", "#btnFilter", function() {
            $('#checkout-form').submit();
        });
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
                                value.name = value.name.split("'").join("");
                                if ($('#directory_' + value.id).length > 0) {
                                    content +=
                                        `<label class="d-flex m-3" style="flex-direction: row-reverse; align-items: center;">${value.name}<input onClick="setDirectory('${value.name}','${value.id}', this)" type="checkbox" checked value="${value.id}"></label>`
                                } else {
                                    content +=
                                        `<label class="d-flex m-3" style="flex-direction: row-reverse; align-items: center;">${value.name}<input onClick="setDirectory('${value.name}','${value.id}', this)" type="checkbox" value="${value.id}"></label>`
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
                if ($('#directory_' + y).length <= 0) {
                    $('#show_checkboxes').append(
                        `<label id="directory_${y}" class="d-flex m-3" style="flex-direction: row-reverse; align-items: center;">${x}<input checked type="checkbox" name="directory_id[]" onClick="removeCheckbox('${y}')" value="${y}"></label>`
                    )
                } else {
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
    </script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script type="text/javascript">
        $('#description').summernote({
            height: 400
        });
        $('#paragraph1').summernote({
            height: 400
        });
        $('#paragraph2').summernote({
            height: 400
        });
        $('#paragraph3').summernote({
            height: 400
        });
        $('#summernote-meta_description').summernote({
            height: 400
        });
    </script>
@endpush
