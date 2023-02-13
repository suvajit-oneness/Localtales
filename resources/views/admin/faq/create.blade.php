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
                <h3 class="tile-title">{{ $subTitle }}
                    <span class="top-form-btn">

                        <a class="btn btn-secondary" href="{{ route('admin.blog.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>


                <form action="{{ route('admin.faq.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="category"> Category <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('category') is-invalid @enderror" type="text" name="category" id="category" value="{{ old('category') }}"/>
                            @error('category') {{ $message ?? '' }} @enderror
                        </div>




                        <div class="form-group">
                            <label class="control-label" for="subcategory">Sub Category</label>
                            <input class="form-control @error('subcategory') is-invalid @enderror" type="text" name="subcategory" id="subcategory" value="{{ old('subcategory') }}"/>
                            @error('subcategory') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="question">Question</label>
                            <textarea name="question" id="question" class="form-control">{{old('question')}}</textarea>
                            @error('question') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="answer">Answer</label>
                            <textarea name="answer" id="answer" class="form-control">{{old('answer')}}</textarea>
                            @error('answer') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>



                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Faq</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.faq.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
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
                        <a class="btn btn-secondary" href="{{ route('admin.blog.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form> --}}
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script type="text/javascript">
    $('#question').summernote({
        height: 400
    });
    $('#answer').summernote({
        height: 400
    });
</script>
@endpush
