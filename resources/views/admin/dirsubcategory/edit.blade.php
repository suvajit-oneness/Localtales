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
                <form action="{{ route('admin.dirsubcategory.update') }}" method="POST" role="form" enctype="multipart/form-data">@csrf
                    <h3 class="tile-title">Edit sub category

                    </h3>
                    <hr>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="child_category">Title <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('child_category') is-invalid @enderror" type="text" name="child_category" id="child_category" value="{{ old('child_category') ? old('child_category') : $targetCategory->child_category }}" />
                            @error('child_category') <p class="text-danger">{{ $message ?? '' }}</p> @enderror
                        </div>
                    </div>
                    {{--   <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="pin"> Category <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="parent_category">
                                <option hidden selected>Select Category...</option>
                                @foreach ($categories as $index => $item)
                                <option value="{{$item->parent_category}}" {{ ($item->parent_category == $targetCategory->parent_category) ? 'selected' : '' }}>{{ $item->parent_category }}</option>
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
                                                <option value="{{$item->parent_category}}" {{ ($item->parent_category == $targetCategory->parent_category) ? 'selected' : '' }}>{{ $item->parent_category }}</option>
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
                            <textarea class="form-control" id="summernote" name="child_description" cols="30" rows="10">{{ old('child_description',$targetCategory->child_description) }}</textarea>
                            <input type="hidden" name="id" value="{{ $targetCategory->id }}">
                            @error('child_description') <p class="text-danger">{{ $message ?? '' }}</p> @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="child_short_content">Short content</label>
                            <p class="small text-danger mb-2">Approx. 200 words</p>
                            <textarea class="form-control" id="summernote-short" name="child_short_content" cols="30" rows="10">{{ old('child_short_content', $targetCategory->child_short_content) }}</textarea>
                            <input type="hidden" name="id" value="{{ $targetCategory->id }}">
                            @error('child_short_content') <p class="text-danger">{{ $message ?? '' }}</p> @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="child_medium_content">Medium content</label>
                            <p class="small text-danger mb-2">Approx. 700 words</p>
                            <textarea class="form-control" id="summernote-medium" name="child_medium_content" cols="30" rows="10">{{ old('child_medium_content',$targetCategory->child_medium_content) }}</textarea>
                            <input type="hidden" name="id" value="{{ $targetCategory->id }}">
                            @error('child_medium_content') <p class="text-danger">{{ $message ?? '' }}</p> @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="child_long_content">Long content</label>
                            <p class="small text-danger mb-2">Approx. 1000-1200 words</p>
                            <textarea class="form-control" id="summernote-long" name="child_long_content" cols="30" rows="10">{{ old('child_long_content',$targetCategory->child_long_content) }}</textarea>
                            <input type="hidden" name="id" value="{{ $targetCategory->id }}">
                            @error('child_long_content') <p class="text-danger">{{ $message ?? '' }}</p> @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3">
                                    <img src="{{URL::to('/').'/admin/uploads/directorysubcategory/images/'}}{{$targetCategory->child_category_image}}"  height="100px" class="img-thumbnail">
                                </div>
                                <div class="col-sm-9">
                                    <label class="control-label" for="child_category_image">Image <span class="m-l-5 text-danger">*</span></label>
                                    <p class="small text-danger mb-2">Size must be less than 200kb</p>
                                    <input class="form-control @error('child_category_image') is-invalid @enderror" type="file" name="child_category_image" id="child_category_image" />
                                    @error('child_category_image') <p class="text-danger">{{ $message ?? '' }}</p> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tile-footer">
                        <input type="hidden" name="id" value="{{$targetCategory->id}}">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update SubCategory</button>
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


