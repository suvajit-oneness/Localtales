@extends('admin.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    {{-- CKEDITOR 5 INCLUDE --}}
    <link rel="stylesheet" href="{{ asset('backend/ckeditor5-36.0.1-dundmb20fh0i/sample/styles.css') }}">
    <style>
        .ck.ck-reset_all {
            position: sticky;
            top: 49px;
            z-index: 999;
            border-bottom: 1px solid #d3d3d3;
        }
    </style>

    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
            <span class="top-form-btn">

            <a class="btn btn-secondary" href="{{ route('admin.blog.index') }}"><i
                    class="fa fa-fw fa-lg fa-times-circle"></i>Back</a>
            </span>
                <h3 class="tile-title">{{ $subTitle }}

                </h3>
                <hr>


                <form action="{{ route('admin.blog.store') }}" method="POST" role="form"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Article Title <span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title"
                                id="title" value="{{ old('title') }}" />
                            @error('title')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="pin"> Category <span class="m-l-5 text-danger">
                                    *</span></label>
                            <select class="form-control" name="blog_category_id[]" multiple>
                                <option value="" hidden selected>Select Categoy...</option>
                                @foreach ($blogcat as $index => $item)
                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @endforeach
                            </select>
                            @error('blog_category_id')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="pin"> Sub Category </label>
                            <select class="form-control" name="blog_sub_category_id" disabled>
                                        <option value="" hidden selected>None</option>
                                        <option value="" selected disabled>Select Category first</option>
                            </select>
                            @error('blog_sub_category_id')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="pin"> Tertiary Category </label>
                            <select class="form-control" name="blog_tertiary_category_id" disabled>
                                         <option value="" hidden selected>None</option>
                                        <option value="" selected disabled>Select SubCategory first</option>
                            </select>
                            @error('blog_tertiary_category_id')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="page-search-block filterSearchBoxWraper" style="bottom: -83px;">
                            <div class="filterSearchBox">
                                <div class="row">
                                    <div class="mb-sm-0 col col-lg fcontrol position-relative filter_selectWrap filter_selectWrap2">
                        <div class="select-floating-admin">
                            <label class="control-label" for="pincode"> Select Postcode</label>
                            <select class="filter_select form-control" name="pincode">
                                <option value="" hidden selected>Select Postcode...</option>
                                @foreach ($pin as $index => $item)
                                    <option value="{{ $item->pin }}">{{ $item->pin }}</option>
                                @endforeach
                            </select>
                            @error('pincode')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
                        <div class="form-group">
                            <label class="control-label" for="suburb_id"> Suburb </label>
                            <select class="form-control" name="suburb_id" disabled>
                                        <option value="" selected disabled>Select Postcode first</option>
                            </select>
                            @error('suburb_id')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="content">Content</label>
                            {{-- <textarea type="text" class="form-control" rows="4" name="content" id="summernote_content">{{ old('content') }}</textarea> --}}
                            <textarea type="text" class="form-control ckeditor" rows="4" name="content" id="ckeditor">{{ old('content') }}</textarea>
                            @error('content')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="meta_title">Meta Title</label>
                            <input class="form-control" rows="4" name="meta_title" id="meta_title"
                                value="{{ old('meta_title') }}" />
                            @error('meta_title')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="meta_key">Meta Key</label>
                            <input class="form-control" rows="4" name="meta_key"
                                id="meta_key" value="{{ old('meta_key') }}" />
                            @error('meta_key')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="meta_description">Meta Description</label>
                            <textarea class="form-control" rows="4" name="meta_description" id="summernote_meta_description">{{ old('meta_description') }}</textarea>
                            {{-- <input name="meta_description" type="text" id="upload" onchange="" hidden> --}}
                            @error('meta_description')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- <div class="form-group">
                            <label class="control-label" for="meta_key">Tag</label>
                            <p class="small text-danger mb-2">(comma ,separated)</p>
                            <input class="form-control" rows="4" name="tag"
                                id="tag" value="{{ old('tag') }}" />
                            @error('tag')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div> --}}
                        <!--<div class="form-group">
                            <label class="control-label">Article Banner Image</label>
                            <input class="form-control @error('banner_image') is-invalid @enderror" type="file"
                                id="banner_image" name="banner_image" />
                            @error('banner_image')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>-->
                        <div class="form-group">
                            <label class="control-label">Article Image</label>
                            <p class="small text-danger mb-2">Size must be less than 200kb</p>
                            <input class="form-control @error('image') is-invalid @enderror" type="file"
                                id="image" name="image" />
                            @error('image')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                       <!-- <div class="form-group">
                            <label class="control-label">Article Image2</label>
                            <input class="form-control @error('image2') is-invalid @enderror" type="file"
                                id="image2" name="image2" />
                            @error('image2')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>-->
                    </div><br>

                    <h3 class="tile-title">Create Sticky Content</h3><br><br>
                    <div class="article-radio-option-wrap d-flex align-items-center">
                        <label class="inner-wrapper ml-3" for="articleRadioInput2">
                            <input type="radio" name="type" id="articleRadioInput2" value="1" checked>
                            <span>Half Image</span>
                        </label>
                        <label class="inner-wrapper" for="articleRadioInput1">
                            <input type="radio" name="type" id="articleRadioInput1" value="2">
                            <span>Full Image</span>
                        </label>
                    </div>
                    <br>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="heading">Article Sticky Heading<span class="m-l-5 text-danger"> *</span></label>
                             <input class="form-control @error('heading') is-invalid @enderror" type="text" name="heading" id="heading" value="Let's Become One Of Us"/>
                             @error('heading') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="sticky_content">Article Sticky Content <span class="m-l-5 text-danger"> *</span></label>
                             <textarea class="form-control @error('sticky_content') is-invalid @enderror" type="text" name="sticky_content" id="summernote_sticky_content">Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris.</textarea>
                             @error('sticky_content') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="btn_text">Article Sticky button Text <span class="m-l-5 text-danger"> *</span></label>
                             <input class="form-control @error('btn_text') is-invalid @enderror" type="text" name="btn_text" id="btn_text" value="Sign up"/>
                             @error('btn_text') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="btn_link">Article Sticky button Link <span class="m-l-5 text-danger"> *</span></label>
                             <input class="form-control @error('btn_link') is-invalid @enderror" type="text" name="btn_link" id="btn_link" value="{{ URL::to('/').'/'.'business-signup' }}"/>
                             @error('btn_link') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-2">
                                    <figure class="mt-2" style="width: 80px; height: auto;">
                                        <img src="{{asset('front/img/aside.png')}}" id="blogImage" class="img-fluid" alt="img">
                                    </figure>
                            </div>
                            <div class="col-md-10">
                                <label class="control-label">Article Sticky Image</label>
                                <p class="small text-danger mb-2">Size must be less than 200kb</p>
                                <input class="form-control @error('sticky_image') is-invalid @enderror" type="file" id="sticky_image" name="sticky_image"/>
                                @error('sticky_image') {{ $message }} @enderror
                            </div>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save
                            Article</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.blog.index') }}"><i
                                class="fa fa-fw fa-lg fa-times-circle"></i>Back</a>
                    </div>
                </form>
                {{-- <form action="{{ route('admin.blog.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="title">Blog Title <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title') }}"/>
                            @error('title') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="tile-body">
                            <div class="form-group">
                                <label class="control-label" for="pin"> Category <span class="m-l-5 text-danger"> *</span></label>
                                <select class="form-control" name="blog_category_id">
                                    <option hidden selected>Select Categoy...</option>
                                    @foreach ($blogcat as $index => $item)
                                        <option value="{{$item->id}}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                                @error('blog_category_id') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                        </div>
                        <div class="tile-body">
                            <div class="form-group">
                                <label class="control-label" for="pin"> Sub Category <span class="m-l-5 text-danger"> *</span></label>
                                <select class="form-control" name="blog_sub_category_id">
                                    <option hidden selected>Select Sub Categoy...</option>
                                    @foreach ($blogsubcat as $index => $item)
                                        <option value="{{$item->id}}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                                @error('blog_sub_category_id') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label" for="content">Content</label>
                            <input type="text" class="form-control" rows="4" name="content" id="content"{{ old('content') }}/>@error('content') {{ $message ?? '' }} @enderror

                        </div>
                        <div class="form-group">
                            <label class="control-label" for="meta_title">Meta Title</label>
                            <input class="form-control" rows="4" name="meta_title" id="meta_title"{{ old('meta_title') }}/>@error('meta_title') {{ $message ?? '' }} @enderror

                        </div>
                        <div class="form-group">
                            <label class="control-label" for="meta_key">Meta Key</label>
                            <input class="form-control" rows="4" name="meta_key" id="meta_key"{{ old('meta_key') }}/>@error('meta_key') {{ $message ?? '' }} @enderror

                        </div>
                        <div class="form-group">
                            <label class="control-label" for="meta_description">Description</label>
                            <textarea class="form-control" rows="4" name="meta_description" id="meta_description">{{ old('meta_description') }}</textarea>
                            <input name="meta_description" type="text" id="upload" onchange="" hidden>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Blog Image</label>
                            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                            @error('image') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Blog</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.blog.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Back</a>
                    </div>
                </form> --}}
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
		$('select[name="blog_category_id[]"]').on('change', (event) => {
			var value = $('select[name="blog_category_id[]"]').val();

			$.ajax({
				url: '{{url("/")}}/api/subcategory/'+value,
                method: 'GET',
                success: function(result) {
					var content = '';
					var slectTag = 'select[name="blog_sub_category_id"]';
					var displayCollection = (result.data.cat_name == "all") ? "All Subcategory" : " Select ";

					content += '<option value="" selected>'+displayCollection+'</option>';
					$.each(result.data.subcategory, (key, value) => {
						content += '<option value="'+value.subcategory_id+'">'+value.subcategory_title+'</option>';
					});
					$(slectTag).html(content).attr('disabled', false);
                }
			});
		});

        $('select[name="blog_sub_category_id"]').on('change', (event) => {
			var value = $('select[name="blog_sub_category_id"]').val();

			$.ajax({
				url: '{{url("/")}}/api/tertiarycategory/'+value,
                method: 'GET',
                success: function(result) {
					var content = '';
					var slectTag = 'select[name="blog_tertiary_category_id"]';
					var displayCollection = (result.data.cat_name == "all") ? "All Subcategory" : " Select";

					content += '<option value="" selected>'+displayCollection+'</option>';
					$.each(result.data.tertiarycategory, (key, value) => {
						content += '<option value="'+value.tertiarycategory_id+'">'+value.tertiarycategory_title+'</option>';
					});
					$(slectTag).html(content).attr('disabled', false);
                }
			});
		});

        $('select[name="pincode"]').on('change', (event) => {
			var value = $('select[name="pincode"]').val();

			$.ajax({
				url: '{{url("/")}}/api/postcode-suburb/'+value,
                method: 'GET',
                success: function(result) {
					var content = '';
					var slectTag = 'select[name="suburb_id"]';
					var displayCollection = (result.data.postcode == "all") ? "All postcode" : " Select";

					content += '<option value="" selected>'+displayCollection+'</option>';
					$.each(result.data.suburb, (key, value) => {
						content += '<option value="'+value.suburb_id+'">'+value.suburb_title+'</option>';
					});
					$(slectTag).html(content).attr('disabled', false);
                }
			});
		});
    </script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script type="text/javascript">
    $('#summernote_content').summernote({
        height: 400
    });
    $('#summernote_meta_description').summernote({
        height: 400
    });
    $('#summernote_sticky_content').summernote({
        height: 400
    });
</script>

{{-- CKEDITOR 5 SCRIPT --}}
<script src="{{ asset('backend/ckeditor5-36.0.1-dundmb20fh0i/build/ckeditor.js') }}"></script>
<script>
    const watchdog = new CKSource.EditorWatchdog();
    window.watchdog = watchdog;

    watchdog.setCreator( ( element, config ) => {
        return CKSource.Editor
            .create( element, config )
            .then( editor => {
                return editor;
            } )
    });
    watchdog.setDestructor( editor => {
        return editor.destroy();
    });

    watchdog.on( 'error', handleError );
    watchdog
        .create( document.querySelector( '.ckeditor' ), {
            licenseKey: '',
        } )
        .catch( handleError );

    function handleError( error ) {
        console.error( 'Oops, something went wrong!' );
        console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
        console.warn( 'Build id: dundmb20fh0i-hqryd5mcylgl' );
        console.error( error );
    }
</script>
@endpush
