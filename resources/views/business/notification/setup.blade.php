@extends('business.app')
@section('title') Notification setup @endsection

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file"></i> Notification</h1>
            <p>Setup Notification Preferences</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="justify-content-end">
                        <p class="text-muted mb-0">Select How you want to receive notifications</p>

                        <div class="d-flex">
                            <div class="notification-box-inner notification-box-inner-mod">
                                <div class="content">
                                    <label class="switch">
                                        <input type="checkbox" checked>
                                        <span class="slider round"></span>
                                        <p>Email</p>
                                    </label>
                                </div>
                            </div>
                            <div class="notification-box-inner notification-box-inner-mod">
                                <div class="content">
                                    <label class="switch">
                                        <input type="checkbox" checked>
                                        <span class="slider round"></span>
                                        <p>Push Notification</p>
                                    </label>
                                </div>
                            </div>
                            <div class="notification-box-inner notification-box-inner-mod">
                                <div class="content">
                                    <label class="switch">
                                        <input type="checkbox" checked>
                                        <span class="slider round"></span>
                                        <p>In-app Notification</p>
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="notification-content">
                        <div class="notification-box">
                            @foreach ($data as $key => $heading)
                                <div class="notification-box-inner">
                                    <h4>{{$heading['title']}}</h4>
        
                                    @foreach ($heading['notification_lists'] as $notification)
                                        <div class="content">
                                            <ul class="list-unstyled p-0 m-0">
                                                <li>{{$notification['heading']}}</li>
                                                <li><p class="small mb-0">{{$notification['description']}}</p></li>
                                            </ul>
                                            <label class="switch">
                                                <input type="checkbox" {{ (count($notification['notification_receive_user']) > 0) ? 'checked' : '' }} onchange="here({{$notification['id']}})">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function here(notificationId) {
            $.ajax({
                url: "{{ route('user.notification.toggle') }}",
                type: "POST",
                data: {
                    '_token': '{{csrf_token()}}',
                    notification_id: notificationId,
                    user_id: '{{auth()->guard("business")->user()->id}}',
                },
                success: function(resp) {
                    if (resp.status == 200) {
                        toastFire('success', resp.message);
                    } else {
                        toastFire('warning', resp.message);
                    }
                }
            });
        }
    </script>
@endpush