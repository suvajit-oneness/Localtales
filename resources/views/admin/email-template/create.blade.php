@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection

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
                <form action="{{ route('admin.dirsubcategory.store') }}" method="POST" role="form" enctype="multipart/form-data">@csrf
                    <h3 class="tile-title">Create Sub category
                        <span class="top-form-btn">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Category</button>

                            <a class="btn btn-secondary" href="{{ route('admin.dirsubcategory.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                        </span>
                    </h3>
                    <hr>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="child_category">Title <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('child_category') is-invalid @enderror" type="text" name="child_category" id="child_category" value="{{ old('child_category') }}" />
                            @error('child_category') <p class="text-danger">{{ $message ?? '' }}</p> @enderror
                        </div>
                    </div>
                    {{--  <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="parent_category"> Category <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="parent_category">
                                <option hidden selected>Select Category...</option>
                                @foreach ($categories as $index => $item)
                                <option value="{{$item->parent_category}}">{{ $item->parent_category }}</option>
                            @endforeach
                            </select>
                            @error('parent_category') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>--}}
                    <div class="page-search-block filterSearchBoxWraper" style="bottom: -83px;">
                        <div class="filterSearchBox">
                            <div class="row">
                                <div class="mb-sm-0 col col-lg fcontrol position-relative filter_selectWrap filter_selectWrap2">
                                    <div class="select-floating-admin">
                                        <label>Category<span class="m-l-5 text-danger">
                                            *</span></label>
                                        <select class="filter_select form-control" name="parent_category">
                                            <option hidden selected>Select Category...</option>
                                            @foreach ($categories as $index => $item)
                                            <option value="{{$item->parent_category}}">{{ $item->parent_category }}</option>
                                        @endforeach
                                        </select>
                                        @error('parent_category') <p class="small text-danger">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="child_description">Description</label>
                            <p class="small text-danger mb-2">Approx. 200 words</p>
                            <textarea class="form-control @error('child_description') is-invalid @enderror" name="child_description"  rows="4" id="summernote">{{ old('child_description') }}</textarea>
                            @error('child_description') <p class="text-danger">{{ $message ?? '' }}</p> @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="child_short_content">Short content</label>
                            <p class="small text-danger mb-2">Approx. 200 words</p>
                            <textarea class="form-control @error('child_short_content') is-invalid @enderror" name="child_short_content"  rows="4" id="summernote-short">{{ old('child_short_content') }}</textarea>
                            @error('child_short_content') <p class="text-danger">{{ $message ?? '' }}</p> @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="child_medium_content">Medium content</label>
                            <p class="small text-danger mb-2">Approx. 700 words</p>
                            <textarea class="form-control @error('child_medium_content') is-invalid @enderror" name="child_medium_content"  rows="4" id="summernote-medium">{{ old('child_medium_content') }}</textarea>
                            @error('child_medium_content') <p class="text-danger">{{ $message ?? '' }}</p> @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="child_long_content">Long content</label>
                            <p class="small text-danger mb-2">Approx. 1000-1200 words</p>
                            <textarea class="form-control @error('child_long_content') is-invalid @enderror" name="child_long_content"  rows="4" id="summernote-long">{{ old('child_long_content') }}</textarea>
                            @error('child_long_content') <p class="text-danger">{{ $message ?? '' }}</p> @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="child_category_image">Image <span class="m-l-5 text-danger">*</span></label>
                            <p class="small text-danger mb-2">Size must be less than 200kb</p>
                            <input class="form-control @error('child_category_image') is-invalid @enderror" type="file" name="child_category_image" id="child_category_image" />
                            @error('child_category_image') <p class="text-danger">{{ $message ?? '' }}</p> @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save SubCategory</button>
                        <a class="btn btn-secondary" href="{{ route('admin.dirsubcategory.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script type="text/javascript">
$('#summernote').summernote({
    height: 400
});
$('#summernote-short').summernote({
    height: 400
});
$('#summernote-medium').summernote({
    height: 400
});
$('#summernote-long').summernote({
    height: 400
});
</script>
@endpush

