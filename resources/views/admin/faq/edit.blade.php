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
                <form action="{{ route('admin.faq.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="category"> Category <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('category') is-invalid @enderror" type="text" name="category" id="category" value="{{ old('category', $faq->category) }}"/>
                            <input type="hidden" name="id" value="{{ $faq->id }}">
                            @error('category') {{ $message }} @enderror
                        </div>



                        <div class="form-group">
                            <label class="control-label" for="subcategory">Sub Category</label>
                            <input class="form-control @error('subcategory') is-invalid @enderror" type="text" name="subcategory" id="subcategory" value="{{ old('subcategory', $faq->subcategory) }}"/>
                            <input type="hidden" name="id" value="{{ $faq->id }}">
                            @error('subcategory') {{ $message }} @enderror

                        </div>
                        <div class="form-group">
                            <label class="control-label" for="question">Question</label>
                            <textarea class="form-control" rows="4" name="question" id="question">{{ old('question', $faq->question) }}</textarea>
                            <input type="hidden" name="id" value="{{ $faq->id }}">
                            @error('question') {{ $message }} @enderror

                        </div>
                        <div class="form-group">
                            <label class="control-label" for="answer">Answer</label>
                            <textarea class="form-control" rows="4" name="answer" id="answer">{{ old('answer', $faq->answer) }}</textarea>
                            <input type="hidden" name="id" value="{{ $faq->id }}">
                            @error('meta_key') {{ $message }} @enderror
                        </div>



                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Faq</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.faq.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
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
    $('#question').summernote({
        height: 400
    });
    $('#answer').summernote({
        height: 400
    });
</script>
@endpush
