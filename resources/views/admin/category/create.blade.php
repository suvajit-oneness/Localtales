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
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Category</button>
                        <a class="btn btn-secondary" href="{{ route('admin.category.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('admin.category.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Category Title <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title') }}"/>
                            @error('title') {{ $message ?? '' }} @enderror
                        </div>

                    </div>
                    <div class="form-group">
                            <label class="control-label" for="description">Description</label>
                            <textarea type="text" class="form-control" rows="4" name="description" id="description">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    <div class="tile-body">
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
                 <p style="font-weight :bold;"><strong>Category Short Content</strong> (include a paragraph of text and faq , approx. 200 characters)</p>
                <div class="tile-body">
                <div class="form-group">
                    <label class="control-label" for="short_content">Content</label>
                    <textarea type="text" class="form-control" rows="4" name="short_content" id="short_content">{{ old('short_content') }}</textarea>
                    @error('short_content')
                        <p class="small text-danger">{{ $message }}</p>
                    @enderror
                </div>
               </div>
               <p style="font-weight :bold;"><strong>Category Medium Content</strong> (include a few paragraphs of text with an image and the faq , approx. 700 characters)</p>
                <div class="tile-body">
                <div class="form-group">
                    <label class="control-label" for="medium_content">Content</label>
                    <textarea type="text" class="form-control" rows="4" name="medium_content" id="medium_content">{{ old('medium_content') }}</textarea>
                    @error('medium_content')
                        <p class="small text-danger">{{ $message }}</p>
                    @enderror
                </div>
               </div>
               <div class="tile-body">
                <div class="form-group">
                    <label class="control-label"> Medium Content Image</label>
                    <p class="small text-danger mb-2">Size must be less than 200kb</p>
                    <input class="form-control @error('medium_content_image') is-invalid @enderror" type="file"
                        id="medium_content_image" name="medium_content_image"/>
                    @error('medium_content_image')
                        <p class="small text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <p style="font-weight :bold;"><strong>Category Long Content</strong> (include a full page write up, including images and the faq , approx. 1000 - 1,200 characters)</p>
                <div class="tile-body">
                <div class="form-group">
                    <label class="control-label" for="long_content">Content</label>
                    <textarea type="text" class="form-control" rows="4" name="long_content" id="long_content">{{ old('long_content') }}</textarea>
                    @error('long_content')
                        <p class="small text-danger">{{ $message }}</p>
                    @enderror
                </div>
               </div>
               <div class="tile-body">
                <div class="form-group">
                    <label class="control-label"> Long Content Image</label>
                    <p class="small text-danger mb-2">Size must be less than 200kb</p>
                    <input class="form-control @error('long_content_image') is-invalid @enderror" type="file"
                        id="long_content_image" name="long_content_image"/>
                    @error('long_content_image')
                        <p class="small text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
              {{--<div class="tile-body" id="container">
                <div class="inner-body">
                <div class="form-group">
                    <label class="control-label" for="question"> Faq Question <span class="m-l-5 text-danger"> *</span></label>
                    <input class="form-control @error('question') is-invalid @enderror" type="text" name="question" id="question" value="{{ old('question') }}"/>
                    @error('question') {{ $message ?? '' }} @enderror
                </div>
                <div class="form-group">
                    <label class="control-label" for="answer">Faq Answer</label>
                    <textarea type="text" class="form-control" rows="4" name="answer" id="answer">{{ old('answer') }}</textarea>
                    @error('answer')
                        <p class="small text-danger">{{ $message }}</p>
                    @enderror
                </div>
               </div>
               </div>--}}
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Category</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.category.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection



@push('scripts')
<script>
    $("#somebutton").on('click',function () {
        console.log('here')
  $("#container").append('<div class="module_holder"><div class="module_item"><img src="images/i-5.png" alt="Sweep Stakes"><br>sendSMS</div></div>');
});
</script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script type="text/javascript">
    $('#description').summernote({
        height: 400
    });
    $('#short_content').summernote({
        height: 400
    });
    $('#medium_content').summernote({
        height: 400
    });
    $('#long_content').summernote({
        height: 400
    });
</script>
@endpush
