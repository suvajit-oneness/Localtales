@extends('business.app')
@section('title') Notfications @endsection

@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-dashboard"></i> Notfications</h1>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="notification-content">
            <div class="alert alert-light notification-box" role="alert">
                    <div class="notification-box-inner">
                        <h4>2FA Authentication</h4>
                            <div class="content">
                                <ul class="list-unstyled p-0 m-0">
                                </ul>
                                <div class="toggle-button-cover margin-auto">
                                    <div class="button-cover">
                                        <div class="button-togglr b2" id="button-11">
                                            <input id="toggle-block" type="checkbox" name="is_2fa_enable" class="checkbox" data-event_id="{{ $data['id'] }}" {{ $data['is_2fa_enable'] == 1 ? 'checked' : '' }}>
                                            <div class="knobs"><span>Inactive</span></div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
  
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')


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
            url:"{{route('business.notification.toggle')}}",
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