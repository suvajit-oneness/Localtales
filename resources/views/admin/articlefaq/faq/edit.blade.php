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
                <form action="{{ route('admin.blogfaq.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                        <!--<div class="tile-body">
                            <div class="form-group">
                                <label class="control-label" for="blog_category_id"> Category <span class="m-l-5 text-danger"> *</span></label>
                                <select class="form-control" name="category_id">
                                    <option hidden selected>Select Categoy...</option>
                                    @foreach ($blogcat as $index => $item)
                                    <option value="{{$item->id}}" {{ ($item->id == $targetblog->category_id) ? 'selected' : '' }}>{{ $item->title }}</option>
                                    @endforeach
                                </select>
                                @error('blog_category_id') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                        </div>
                        <div class="tile-body">
                            <div class="form-group">
                                <label class="control-label" for="blog_sub_category_id"> Sub Category <span class="m-l-5 text-danger"> *</span></label>
                                <select class="form-control" name="sub_category_id">
                                    <option hidden selected>Select Sub Categoy...</option>
                                    @foreach ($blogsubcat as $index => $item)
                                    <option value="{{$item->id}}" {{ ($item->id == $targetblog->sub_category_id) ? 'selected' : '' }}>{{ $item->title }}</option>
                                    @endforeach
                                </select>
                                @error('blog_sub_category_id') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                        </div>-->


                        <div class="form-group">
                            <label class="control-label" for="question">Question</label>
                            <textarea class="form-control" rows="4" name="question" id="summernote_question">{{ old('question', $targetblog->question) }}</textarea>
                            <input type="hidden" name="id" value="{{ $targetblog->id }}">
                            <input type="hidden" name="blog_id" value="{{ $request->id }}">
                            @error('question') {{ $message }} @enderror

                        </div>
                        <div class="form-group">
                            <label class="control-label" for="answer">Answer</label>
                            <input class="form-control @error('answer') is-invalid @enderror" type="text" name="answer" id="summernote_answer" value="{{ old('answer', $targetblog->answer) }}"/>
                            <input type="hidden" name="id" value="{{ $targetblog->id }}">
                            @error('answer') {{ $message }} @enderror

                        </div>

                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Article</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.blog.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Back</a>
                    </div>
                </form>
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
    <script type="text/javascript">
    $('.sa-remove').on("click",function(){
        var id = $(this).data('id');
        swal({
          title: "Are you sure?",
          text: "Your will not be able to recover the record!",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes, delete it!",
          closeOnConfirm: false
        },
        function(isConfirm){
          if (isConfirm) {
            window.location.href = "http://demo91.co.in/localtales-prelaunch/public/admin/blogfaq/"+id+"/delete";
            } else {
              swal("Cancelled", "Record is safe", "error");
            }
        });
    });
    </script>
    <script type="text/javascript">
        $('input[id="toggle-block"]').change(function() {
            var blog_id = $(this).data('blog_id');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var check_status = 0;
          if($(this).is(":checked")){
              check_status = 1;
          }else{
            check_status = 0;
          }
          $.ajax({
                type:'POST',
                dataType:'JSON',
                url:"{{route('admin.blogfaq.updateStatus')}}",
                data:{ _token: CSRF_TOKEN, id:blog_id, check_status:check_status},
                success:function(response)
                {
                  swal("Success!", response.message, "success");
                },
                error: function(response)
                {

                  swal("Error!", response.message, "error");
                }
              });
        });
    </script>
    <script type="text/javascript">
    $('.sa-remove').on("click",function(){
        var id = $(this).data('id');
        swal({
          title: "Are you sure?",
          text: "Your will not be able to recover the record!",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes, delete it!",
          closeOnConfirm: false
        },
        function(isConfirm){
          if (isConfirm) {
            window.location.href = "http://demo91.co.in/localtales-prelaunch/public/admin/blogfeature/"+id+"/delete";
            } else {
              swal("Cancelled", "Record is safe", "error");
            }
        });
    });
    </script>
    @if (session('csv'))
        <script>
            swal("Success!", "{{ session('csv') }}", "success");
        </script>
    @endif
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script type="text/javascript">
        $('#summernote_question').summernote({
            height: 400
        });
        $('#summernote_answer').summernote({
            height: 400
        });
    </script>
@endpush
