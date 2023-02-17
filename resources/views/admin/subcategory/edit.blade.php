@extends('admin.app')
@section('title'){{ $pageTitle }}@endsection

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
                <form action="{{ route('admin.subcategory.update') }}" method="POST" role="form" enctype="multipart/form-data">@csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="title">Name <span class="m-l-5 text-danger">*</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title', $targetsubCategory->title) }}" />
                            <input type="hidden" name="id" value="{{ $targetsubCategory->id }}">
                            @error('title') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="pin"> Category <span class="m-l-5 text-danger">*</span></label>
                            <select class="form-control @error('category_id') is-invalid @enderror" name="category_id">
                                <option value="" hidden selected>Select Category...</option>
                                @foreach ($categories as $index => $item)
                                    <option value="{{ $item->id }}"
                                        {{ $item->id == $targetsubCategory->category_id ? 'selected' : '' }}>
                                        {{ $item->title }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="description">Description</label>
                            <textarea type="text" class="form-control" rows="4" name="description" id="summernote_content">{{ old('content', $targetsubCategory->description) }}</textarea>
                            @error('description')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-2">
                                @if ($targetsubCategory->image != null)
                                    <figure class="mt-2" style="width: 80px; height: auto;">
                                        <img src="{{ asset('subcategories/' . $targetsubCategory->image) }}" id="blogImage"
                                            class="img-fluid" alt="img">
                                    </figure>
                                @endif
                            </div>
                            <div class="col-md-10">
                                <label class="control-label"> Image</label>
                                <p class="small text-danger mb-2">Size must be less than 200kb</p>
                                <input class="form-control @error('image') is-invalid @enderror" type="file"
                                    id="image" name="image" />
                                @error('image')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update
                            Sub category</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.subcategory.index') }}"><i
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
        $('#summernote_content').summernote({
            height: 400
        });
        $('#description').summernote({
            height: 400
        });
        $('#summernote_sticky_content').summernote({
            height: 400
        });
    </script>
@endpush
