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
                <form action="{{ route('admin.category.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Category Title <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title', $targetCategory->title) }}"/>
                            <input type="hidden" name="id" value="{{ $targetCategory->id }}">
                            @error('title') {{ $message }} @enderror
                        </div>


                    </div>
                    <div class="form-group">
                            <label class="control-label" for="description">Description</label>
                            <textarea class="form-control" rows="4" name="description" id="description">{{ old('description', $targetCategory->description) }}</textarea>
                            <input type="hidden" name="id" value="{{ $targetCategory->id }}">
                        </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-2">
                                @if ($targetCategory->image != null)
                                    <figure class="mt-2" style="width: 80px; height: auto;">
                                        <img src="{{ asset('categories/'.$targetCategory->image) }}" id="blogImage" class="img-fluid" alt="img">
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
                    <p style="font-weight :bold;"><strong>Category Short Content</strong> (include a paragraph of text and faq , approx. 200 characters)</p>
                <div class="tile-body">
                <div class="form-group">
                    <label class="control-label" for="short_content">Content</label>
                    <textarea type="text" class="form-control" rows="4" name="short_content" id="short_content">{{ old('short_content', $targetCategory->short_content) }}</textarea>
                    @error('short_content')
                        <p class="small text-danger">{{ $message }}</p>
                    @enderror
                </div>
               </div>
               <p style="font-weight :bold;"><strong>Category Medium Content</strong> (include a few paragraphs of text with an image and the faq , approx. 700 characters)</p>
                <div class="tile-body">
                <div class="form-group">
                    <label class="control-label" for="medium_content">Content</label>
                    <textarea type="text" class="form-control" rows="4" name="medium_content" id="medium_content">{{ old('medium_content' , $targetCategory->medium_content) }}</textarea>
                    @error('medium_content')
                        <p class="small text-danger">{{ $message }}</p>
                    @enderror
                </div>
               </div>
               <div class="form-group">
                <div class="row">
                    <div class="col-md-2">
                        @if ($targetCategory->medium_content_image != null)
                            <figure class="mt-2" style="width: 80px; height: auto;">
                                <img src="{{ asset('categories/'.$targetCategory->medium_content_image) }}" id="blogImage" class="img-fluid" alt="img">
                            </figure>
                        @endif
                    </div>
                    <div class="col-md-10">
                        <label class="control-label"> Image</label>
                        <p class="small text-danger mb-2">Size must be less than 200kb</p>
                        <input class="form-control @error('image') is-invalid @enderror" type="file" id="medium_content_image" name="medium_content_image"/>
                        @error('medium_content_image') {{ $message }} @enderror
                    </div>
                </div>
            </div>
            <p style="font-weight :bold;"><strong>Category Long Content</strong> (include a full page write up, including  images and the faq , approx. 1000 - 1,200 characters)</p>
                <div class="tile-body">
                <div class="form-group">
                    <label class="control-label" for="long_content">Content</label>
                    <textarea type="text" class="form-control" rows="4" name="long_content" id="long_content">{{ old('long_content' , $targetCategory->long_content) }}</textarea>
                    @error('long_content')
                        <p class="small text-danger">{{ $message }}</p>
                    @enderror
                </div>
               </div>
               <div class="form-group">
                <div class="row">
                    <div class="col-md-2">
                        @if ($targetCategory->long_content_image != null)
                            <figure class="mt-2" style="width: 80px; height: auto;">
                                <img src="{{ asset('categories/'.$targetCategory->long_content_image) }}" id="blogImage" class="img-fluid" alt="img">
                            </figure>
                        @endif
                    </div>
                    <div class="col-md-10">
                        <label class="control-label"> Image</label>
                        <p class="small text-danger mb-2">Size must be less than 200kb</p>
                        <input class="form-control @error('long_content_image') is-invalid @enderror" type="file" id="long_content_image" name="long_content_image"/>
                        @error('long_content_image') {{ $message }} @enderror
                    </div>
                </div>
            </div>
               <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Category</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.category.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                </div>
                </form>
            </div>
            <hr>
        <div class="row mt-5">
            <div class="col-md-12 mx-auto">
            <div class="row mx-0 align-items-center justify-content-between">
                <div class="col-6 pl-0">
                    <h2>Category FAQ</h2>
                </div>
                <div class="col-6 pr-0">
                    <div class="col-md-12 pr-0 text-right">
                        <button type="button" class="btn btn-primary text-right" data-toggle="modal" data-target="#featureModal">
                            Add New
                        </button>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-md-12 mx-auto">
                <div class="tile p-0">
                    <div class="tile-body">
                        <table class="table table-hover custom-data-table-style table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th> Question </th>
                                    <th> Answer </th>
                                    <th> Status </th>
                                    <th style="width:100px; min-width:100px;" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($faq as $key => $blog)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{!! $blog->question ?? '' !!}</td>
                                        <td>{!! $blog->answer ?? '' !!}</td>
                                        <td class="text-center">
                                        <div class="toggle-button-cover margin-auto">
                                            <div class="button-cover">
                                                <div class="button-togglr b2" id="button-11">
                                                    <input id="toggle-block" type="checkbox" name="status" class="checkbox" data-blog_id="{{ $blog['id'] }}" {{ $blog['status'] == 1 ? 'checked' : '' }}>
                                                    <div class="knobs"><span>Inactive</span></div>
                                                    <div class="layer"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Second group">
                                            <a href="{{ route('admin.categoryfaq.edit', $blog['id']) }}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('admin.categoryfaq.details', $blog['id']) }}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-eye"></i></a>
                                            <a href="javascript:void(0)" data-id="{{$blog['id']}}" class="sa-remove btn btn-sm btn-danger edit-btn"><i class="fa fa-trash"></i></a>

                                        </div>
                                    </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>
      <div class="modal fade" id="featureModal" tabindex="-1" aria-labelledby="featureModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Faq Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.categoryfaq.store')}}" method="post">@csrf

                     <input type="hidden" name="category_id" value="{{ $targetCategory->id }}">
                    <div class="form-group">
                        <label class="control-label" for="question">Question </label>
                         <textarea class="form-control @error('question') is-invalid @enderror" type="text" name="question" id="question" >{{ old('question') }}</textarea>
                         @error('question') {{ $message }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="answer">Answer </label>
                        <textarea  class="form-control @error('answer') is-invalid @enderror" type="text" name="answer" id="answer" >{{ old('answer') }}</textarea>
                         @error('answer') {{ $message }} @enderror
                    </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
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
            window.location.href = "http://demo91.co.in/localtales-prelaunch/public/admin/categoryfaq/"+id+"/delete";
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
                url:"{{route('admin.categoryfaq.updateStatus')}}",
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
        $('#question').summernote({
        height: 400
       });
       $('#answer').summernote({
        height: 400
       });
    </script>
@endpush
