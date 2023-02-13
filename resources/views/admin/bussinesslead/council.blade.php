@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection

@section('content')
    <div class="app-title">
        <div class="row w-100">
            <div class="col-md-6">
                <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
                <p></p>
            </div>
           {{-- <div class="col-md-6 text-right">
                <a href="{{ route('admin.bussinesslead.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add New</a>
                <a href="#csvUploadModal" data-toggle="modal" class="btn btn-primary "><i class="fa fa-cloud-upload"></i> CSV Import</a>
            </div> --}}
        </div>
    </div>

    @include('admin.partials.flash')

    <div class="row">
        <div class="col-md-12">
            <div class="row align-items-center justify-content-between">
                <div class="col">
                    <ul>
                        <li class="active">Total Number of Council <span class="count">({{$businesses->total()}})</span></a></li>
                        {{-- @php
                            $activeCount = $inactiveCount = 0;
                            foreach ($data as $catKey => $catVal) {
                                if ($catVal->status == 1) $activeCount++;
                                else $inactiveCount++;
                            }
                        @endphp
                        <li><a href="{{ route('admin.directory.index', ['status' => 'active'])}}">Active <span class="count">({{$activeCount}})</span></a></li>
                        <li><a href="{{ route('admin.directory.index', ['status' => 'inactive'])}}">Inactive <span class="count">({{$inactiveCount}})</span></a></li> --}}
                    </ul>
                </div>
                <div class="col-auto">
                    <form action="{{ route('admin.council.index') }}">
                    <div class="row g-3 align-items-center">
                        <div class="col-auto">
                        <input type="search" name="term" id="term" class="form-control" placeholder="Search here.." value="{{app('request')->input('term')}}" autocomplete="off">
                        </div>
                        <div class="col-auto">
                        <button type="submit" class="btn btn-outline-danger btn-sm">Search Council</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped" >
                        <thead>
                            <tr>
                                <th> SR No </th>
                                <th> Council Name </th>
                                <th> Primary Contact </th>
                                <th> Email Address </th>
                                <th> Contact Number </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($businesses as $key => $category)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $category->council_name }}</td>
                                    <td>{{ $category->primary_contact }}</td>

                                    <td>{{ $category->email }}</td>

                                    <td>{{ $category->contact_no }}</td>
                                    {{-- <td class="text-center">
                                    {{-- <div class="toggle-button-cover margin-auto">
                                        <div class="button-cover">
                                            <div class="button-togglr b2" id="button-11">
                                                <input id="toggle-block" type="checkbox" name="status" class="checkbox" data-id="{{ $category->id }}" {{ $category['status'] == 1 ? 'checked' : '' }}>
                                                <div class="knobs"><span>Inactive</span></div>
                                                <div class="layer"></div>
                                            </div> --}}
                                            {{-- <div class="button-togglr b2" id="button-11">
                                                <input id="toggle-block" type="checkbox" name="status" class="checkbox" data-state_id="{{ $category['id'] }}" {{ $category['status'] == 1 ? 'checked' : '' }}>
                                                <div class="knobs"><span>Inactive</span></div>
                                                <div class="layer"></div>
                                            </div>
                                        </div>
                                    </div>
                                </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $businesses->links() !!}
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="csvUploadModal" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    Import CSV data
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('admin.bussinesslead.data.csv.store')}}" enctype="multipart/form-data" id="fileCsvUploadForm">
                        @csrf
                        <input type="file" name="file" class="form-control" accept=".csv">
                        <br>
                        <p class="small">Please select csv file</p>
                        <button type="submit" class="btn btn-sm btn-primary" id="csvImportBtn">Import <i class="fas fa-upload"></i></button>
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
            window.location.href = "bussinesslead/"+id+"/delete";
            } else {
              swal("Cancelled", "Record is safe", "error");
            }
        });
    });
    </script>
     <script type="text/javascript">
        $('input[id="toggle-block"]').change(function() {
            var id = $(this).data('id');
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
                url:"{{route('admin.bussinesslead.updateStatus')}}",
                data:{ _token: CSRF_TOKEN, id:id, check_status:check_status},
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

