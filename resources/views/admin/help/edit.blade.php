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
                <form action="{{ route('admin.userhelp.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="title">Article Title <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title', $targetblog->title) }}"/>
                            <input type="hidden" name="id" value="{{ $targetblog->id }}">
                            @error('title') {{ $message }} @enderror
                        </div>

                        <div class="tile-body">
                            <div class="form-group">
                                <label class="control-label" for="cat_id"> Category <span class="m-l-5 text-danger"> *</span></label>
                                <select class="form-control" name="cat_id">
                                    <option hidden selected>Select Categoy...</option>
                                    @foreach ($blogcat as $index => $item)
                                    <option value="{{$item->id}}" {{ ($item->id == $targetblog->cat_id) ? 'selected' : '' }}>{{ $item->title }}</option>
                                    @endforeach
                                </select>
                                @error('cat_id') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                        </div>
                        <div class="tile-body">
                            <div class="form-group">
                                <label class="control-label" for="sub_cat_id"> Sub Category <span class="m-l-5 text-danger"> *</span></label>
                                <select class="form-control" name="sub_cat_id">
                                    <option hidden selected>Select Sub Categoy...</option>
                                    @foreach ($blogsubcat as $index => $item)
                                    <option value="{{$item->id}}" {{ ($item->id == $targetblog->sub_cat_id) ? 'selected' : '' }}>{{ $item->title }}</option>
                                    @endforeach
                                </select>
                                @error('sub_cat_id') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                        </div>


                        <div class="form-group">
                            <label class="control-label" for="description">Content</label>
                            <textarea class="form-control" rows="4" name="description" id="description">{{ old('description', $targetblog->description) }}</textarea>
                            <input type="hidden" name="id" value="{{ $targetblog->id }}">
                            @error('description') {{ $message }} @enderror

                        </div>


                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Article</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.userhelp.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
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
    $('#description').summernote({
        height: 400
    });
</script>
@endpush
