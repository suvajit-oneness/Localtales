@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
            <p>{{ $subTitle }}</p>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('admin.job.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add New</a>
            {{-- <a href="#csvUploadModal" data-toggle="modal" class="btn btn-primary "><i class="fa fa-cloud-upload"></i> CSV Upload</a> --}}
            <a href="{{ route('admin.job.data.csv.export') }}" class="btn btn-primary "><i class="fa fa-cloud-download"></i> CSV Export</a>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-12">
            <div class="row align-items-center justify-content-between">
                <div class="col">
                    <ul class="text-right mt-3">
                        <p class="font-weight : bold">Total Jobs <span class="count">({{$job->total()}})</span></p>
                    </ul>
                </div>
                   <div class="col-auto">
                    <form action="{{ route('admin.job.index') }}">
                    <div class="row g-3 align-items-center">
                        <div class="col-auto">
                        <input type="search" name="term" id="term" class="form-control" placeholder="Search here.." value="{{app('request')->input('term')}}" autocomplete="off">
                        </div>
                        <div class="col-auto">
                        <button type="submit" class="btn btn-danger btn-sm">Search</button>
                        <a type="button" href="{{ url()->current() }}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Remove filter"><i class="fa fa-times"></i>
                        </a>
                        </div>
                    </div>
                    </form>
                </div>
                </div>
            <div class="row">
                <div class="col-md-12">
                <div class="title">
                <div class="tile-body">
                    <div class="" id="op_list_view">
                        <table class="table table-hover custom-data-table-style table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th> Category </th>
                                    <th> Title </th>
                                    <th> Company Name </th>
                                    <th> Employment Type </th>
                                    <th> Applicant </th>
                                    <th> Status </th>
                                    <th style="width:100px; min-width:100px;" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($job as $key => $data)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $data->category }}</td>
                                        <td>{{ $data->title }}</td>
                                        <td>{{ $data->company_name }}</td>
                                        <td>{{ $data->employment_type }}</td>
                                        @php
                                            $application = \App\Models\ApplyJob::where('job_id',$data->id)->with('job')->get();
                                            $item = $application->count();
                                        @endphp
                                        <td><a href="{{ route('admin.job.application',$data->id) }}">{{ $item }}</a></td>
                                        <td class="text-center">
                                            <div class="toggle-button-cover margin-auto">
                                                <div class="button-cover">
                                                    <div class="button-togglr b2" id="button-11">
                                                        <input id="toggle-block" type="checkbox" name="status" class="checkbox" data-job_id="{{ $data['id'] }}" {{ $data['status'] == 1 ? 'checked' : '' }}>
                                                        <div class="knobs"><span>Inactive</span></div>
                                                        <div class="layer"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Second group">
                                                <a href="{{ route('admin.job.edit', $data['id']) }}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-edit"></i></a>
                                                <a href="{{ route('admin.job.details', $data['id']) }}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-eye"></i></a>
                                                <a href="#" data-id="{{$data['id']}}" class="sa-remove btn btn-sm btn-danger edit-btn"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $job->appends($_GET)->links() }}
                    </div>
                </div>
            </div>
        </div>
      </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable({"ordering": false});</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>

    <script type="text/javascript">
        $('.sa-remove').on("click",function(){
            var dataid = $(this).data('id');
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
                window.location.href = "job/"+dataid+"/delete";
                } else {
                swal("Cancelled", "Record is safe", "error");
                }
            });
        });
    </script>
    <script type="text/javascript">
        $('input[name="status"]').change(function() {
            var job_id = $(this).data('job_id');
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
                url:"{{route('admin.job.updateStatus')}}",
                data:{ _token: CSRF_TOKEN, id:job_id, check_status:check_status},
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
@endpush
