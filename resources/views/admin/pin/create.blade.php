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
                        <a class="btn btn-secondary" href="{{ route('admin.pin.index') }}"><i
                                class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('admin.pin.store') }}" method="post" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="pin"> Postcode <span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control @error('pin') is-invalid @enderror" type="text" name="pin"
                                id="pin" value="{{ old('pin') }}" />
                            @error('pin')
                                {{ $message ?? '' }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="description"> Description <span class="m-l-5 text-danger">
                                    *</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" type="text"
                                name="description" id="summernote-description" value="{{ old('description') }}" /></textarea>
                            @error('description')
                                {{ $message ?? '' }}
                            @enderror
                        </div>
                    <div class="page-search-block filterSearchBoxWraper" style="bottom: -83px;">
                        <div class="filterSearchBox">
                            <div class="row">
                                <div class="mb-sm-0 col col-lg fcontrol position-relative filter_selectWrap filter_selectWrap2">
                    <div class="select-floating-admin">
                        <label class="control-label" for="pincode"> State</label>
                        <select class="filter_select form-control" name="state_id">
                            <option hidden selected>Select State...</option>
                            @foreach ($states as $index => $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('state_id')
                            <p class="small text-danger">{{ $message }}</p>
                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    <div class="title-body">
                        <div class="form-group">
                            <label for="image" class="form-label">Select image<span class="m-l-5 text-danger">
                                    *</span></label>
                                    <p class="small text-danger mb-2">Size must be less than 200kb</p>
                            <input type="file" name="image" class="form-control" accept="image/jpeg,image/png">
                        </div>
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
                        </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save
                            Postcode</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.pin.index') }}"><i
                                class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
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
    $('#summernote-description').summernote({
        height: 400
    });
    $('#summernote-meta_description').summernote({
        height: 400
    });
</script>
@endpush
