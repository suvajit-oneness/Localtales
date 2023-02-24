@extends('business.app')
@section('title') {{ $pageTitle }} @endsection

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
            <p>{{ $subTitle }}</p>
        </div>
        <a href="{{ route('business.event.create') }}" class="btn btn-primary pull-right">Add New</a>
    </div>

    @include('business.partials.flash')

    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover custom-data-table-style table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th> Title </th>
                        <th> Image </th>
                        <th> Category </th>
                        <th> Start Date </th>
                        <th> Expiry Date </th>
                        <th> Status </th>
                        <th style="width:100px; min-width:100px;" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $key => $event)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $event->title }}</td>
                            <td>
                                @if($event->image!='')
                                <img style="width: 150px;height: 100px;" src="{{URL::to('/').'/uploads/events/'}}{{$event->image}}">
                                @endif
                            </td>
                            <td>
                                {!! eventCategory($event->category_id) !!}
                            </td>
                            <td>{{ date('j M, Y', strtotime($event->start_date)) }}</td>
                            <td>{{ date('j M, Y', strtotime($event->end_date)) }}</td>
                            <td class="text-center">
                                <div class="toggle-button-cover margin-auto">
                                    <div class="button-cover">
                                        <div class="button-togglr b2" id="button-11">
                                            <input id="toggle-block" type="checkbox" name="status" class="checkbox" data-event_id="{{ $event['id'] }}" {{ $event['status'] == 1 ? 'checked' : '' }}>
                                            <div class="knobs"><span>Inactive</span></div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="Second group">
                                    <a href="{{ route('business.event.details', $event['id']) }}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-eye"></i></a>
                                    <a href="{{ route('business.event.edit', $event['id']) }}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-edit"></i></a>
                                    <a href="javascript::void()" data-id="{{$event['id']}}" class="sa-remove btn btn-sm btn-danger edit-btn"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="100%">No records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {!! $events->appends($_GET)->links() !!}
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
        var eventid = $(this).data('id');
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
            window.location.href += "/"+eventid+"/delete";
            } else {
              swal("Cancelled", "Record is safe", "error");
            }
        });
    });
    </script>
    <script type="text/javascript">
        $('input[id="toggle-block"]').change(function() {
            var event_id = $(this).data('event_id');
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
                url:"{{route('business.event.updateStatus')}}",
                data:{ _token: CSRF_TOKEN, id:event_id, check_status:check_status},
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