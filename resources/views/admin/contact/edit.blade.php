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
                <form action="{{ route('admin.contact-us.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="pretty_name"> Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('pretty_name') is-invalid @enderror" type="text" name="pretty_name" id="pretty_name" value="{{ old('pretty_name', $contact->pretty_name) }}"/>
                            <input type="hidden" name="id" value="{{ $contact->id }}">
                            @error('pretty_name') {{ $message }} @enderror
                        </div>


                        <div class="form-group">
                            <label class="control-label" for="content">Contact No</label>
                            <textarea class="form-control" rows="4" name="content" id="content">{{ old('content', $contact->content) }}</textarea>
                            <input type="hidden" name="id" value="{{ $contact->id }}">
                            @error('content') {{ $message }} @enderror

                        </div>
                        <div class="form-group">
                            <label class="control-label" for="content1">Address</label>
                            <textarea class="form-control" rows="4" name="content1" id="content1">{{ old('content1', $contact->content1) }}</textarea>
                            <input type="hidden" name="id" value="{{ $contact->id }}">
                            @error('content1') {{ $message }} @enderror

                        </div>
                        <div class="form-group">
                            <label class="control-label" for="content2">Url</label>
                            <textarea class="form-control" rows="4" name="content2" id="content2">{{ old('content2', $contact->content2) }}</textarea>
                            <input type="hidden" name="id" value="{{ $contact->id }}">
                            @error('content2') {{ $message }} @enderror

                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    @if ($contact->banner_image != null)
                                        <figure class="mt-2" style="width: 80px; height: auto;">
                                            <img src="{{ asset('ContactusBanner/'.$contact->banner_image) }}" id="blogImage" class="img-fluid" alt="img">
                                        </figure>
                                    @endif
                                </div>
                                <div class="col-md-10">
                                    <label class="control-label">Banner Image</label>
                                    <p class="small text-danger mb-2">Size must be less than 200kb</p>
                                    <input class="form-control @error('banner_image') is-invalid @enderror" type="file" id="banner_image" name="banner_image"/>
                                    @error('banner_image') {{ $message }} @enderror
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    @if ($contact->image != null)
                                        <figure class="mt-2" style="width: 80px; height: auto;">
                                            <img src="{{ asset('Contactus/'.$contact->image) }}" id="blogImage" class="img-fluid" alt="img">
                                        </figure>
                                    @endif
                                </div>
                                <div class="col-md-10">
                                    <label class="control-label"> Image</label>
                                    <p class="small text-danger mb-2">Size must be less than 200kb</p>
                                    <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                                    @error('image') {{ $message }} @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Settings</button>
                        &nbsp;&nbsp;&nbsp;

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
    $('#content').summernote({
        height: 400
    });
       $('#content1').summernote({
        height: 400
    });
       $('#content2').summernote({
        height: 400
    });
</script>
@endpush
