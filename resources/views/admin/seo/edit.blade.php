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
                <h3 class="tile-title">{{ $subTitle }}</h3>
                <form action="{{ route('admin.seo.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Page <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('page') is-invalid @enderror" type="text" name="page" id="page" value="{{ old('page', $seo->page) }}" disabled/>
                            <input type="hidden" name="id" value="{{ $seo->id }}">
                            @error('page') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Title <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title', $seo->title) }}"/>
                            <input type="hidden" name="id" value="{{ $seo->id }}">
                            @error('title') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="meta_desc">Meta Description <span class="m-l-5 text-danger"> *</span></label>
                            <textarea class="form-control @error('meta_desc') is-invalid @enderror" type="text" name="meta_desc" id="meta_desc" value="{{ old('title', $seo->meta_desc) }}"></textarea>
                            <input type="hidden" name="id" value="{{ $seo->id }}">
                            @error('meta_desc') {{ $message }} @enderror
                        </div>

                    </div>

                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.seo.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
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
    $('#meta_desc').summernote({
        height: 400
    });
</script>
@endpush