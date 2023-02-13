@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection

@section('content')
<style>
   
    #yes {
        display: none;
    }

    #no {
        display: none;
    }
    
</style>
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
        </div>
    </div>

    @include('admin.partials.flash')

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <form action="{{ route('admin.email.master.update') }}" method="POST" role="form" enctype="multipart/form-data">@csrf
                    <h3 class="tile-title">Edit template

                    </h3>
                    <hr>
                    <h3 class="tile-title">{{ucwords($email->type)}}</h3>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="subject">Subject <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('subject') is-invalid @enderror" type="text" name="subject" id="subject" value="{{ old('subject') ? old('subject') : $email->subject }}" />
                            @error('subject') <p class="text-danger">{{ $message ?? '' }}</p> @enderror
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label" for="recurring">Body</label>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" onClick="bodyCheck();"
                                    id="image" name="is_image" value="1" {{ $email->is_image == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="recurring">
                                        Image
                                    </label>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" onClick="bodyCheck();"
                                    id="noimage" name="is_image" value="0" {{ $email->is_image != 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="norecurr">
                                        Text
                                    </label>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div id="yes">
                            <div class="tile-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            @if($email->is_image ==1)
                                            <img src="{{URL::to('/').'/email/'}}{{$email->body}}"  height="100px" class="img-thumbnail">
                                            @endif
                                        </div>
                                        <div class="col-sm-9">
                                            <label class="control-label" for="body">Image</label>
                                            <p class="small text-danger mb-2">Size must be less than 1MB</p>
                                            <input class="form-control @error('body') is-invalid @enderror" type="file" name="body" id="body" />
                                            @error('body') <p class="text-danger">{{ $message ?? '' }}</p> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="no">
                            <div class="tile-body">
                                <div class="form-group">
                                    <label class="control-label" for="body">Body</label>
                                    {{-- <p class="small text-danger mb-2">Approx. 200 words</p> --}}
                                    <textarea class="form-control" id="summernote" name="body" cols="30" rows="10">{{ $email->is_image != 1 ? $email->body : ''  }}</textarea>
                                    <input type="hidden" name="id" value="{{ $email->id }}">
                                    <input type="hidden" name="type" value="{{ $email->type }}">
                                    @error('body') <p class="text-danger">{{ $message ?? '' }}</p> @enderror
                                </div>
                                
                            </div>
                        </div>    
                    </div>
                    

                    <div class="tile-footer">
                       
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update </button>
                        <a class="btn btn-secondary" href="{{ route('admin.email.master.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
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
    bodyCheck();
        function bodyCheck() {
            if (document.getElementById('image').checked) {
                document.getElementById('yes').style.display = 'block';
                document.getElementById('no').style.display = 'none';
            } else {
                document.getElementById('yes').style.display = 'none';
                document.getElementById('no').style.display = 'block';
            }
        }
</script>
@endpush


