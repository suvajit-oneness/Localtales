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
                <form action="{{ route('admin.advocate.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    <input type="hidden" name="email" value="{{ $advocate->email }}">
                    @csrf
                    <h3>Email : {{ $advocate->email }}</h3>
                    <div class="form-group">
                            <label class="control-label" for="subject">Subject</label>
                            <input class="form-control" rows="4" name="subject" id="subject" value="{{ old('subject') }}">
                            <input type="hidden" name="id" value="{{ $advocate->id }}">
                        </div>
                <div class="tile-body">
                <div class="form-group">
                    <label class="control-label" for="body">Body</label>
                    <textarea type="text" class="form-control" rows="4" name="body" id="body">{{ old('body') }}</textarea>
                    @error('body')
                        <p class="small text-danger">{{ $message }}</p>
                    @enderror
                </div>
               </div>
               <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Send Mail</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.advocate.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                </div>
                </form>
            </div>
            <hr>
          </div>
        </div>
      </div>
    </div>
@endsection
@push('scripts')
<script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript">$('#sampleTable').DataTable({"ordering": false});</script>
 {{-- New Add --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>


    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script type="text/javascript">
        $('#body').summernote({
            height: 400
        });

    </script>
@endpush
