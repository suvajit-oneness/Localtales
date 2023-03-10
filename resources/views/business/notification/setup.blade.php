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
                                        <input type="checkbox" {{ (Auth::guard('business')->user()->notification_email == 1) ? 'checked' : '' }} onchange="notificationReceiveToggle('notification_email')">
                                        <span class="slider round"></span>
                                        <p>Email</p>
                                    </label>
                                </div>
                            </div>
                            <div class="notification-box-inner notification-box-inner-mod">
                                <div class="content">
                                    <label class="switch">
                                        <input type="checkbox" {{ (Auth::guard('business')->user()->notification_push == 1) ? 'checked' : '' }} onchange="notificationReceiveToggle('notification_push')" name="push-notification">
                                        <span class="slider round"></span>
                                        <p>Push Notification</p>
                                    </label>
                                </div>
                            </div>
                            <div class="notification-box-inner notification-box-inner-mod">
                                <div class="content">
                                    <label class="switch">
                                        <input type="checkbox" {{ (Auth::guard('business')->user()->notification_in_app == 1) ? 'checked' : '' }} onchange="notificationReceiveToggle('notification_in_app')">
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
                                                <input type="checkbox" {{ (count($notification['notification_receive_user']) > 0) ? 'checked' : '' }} onchange="notificationToggle({{$notification['id']}})">
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
        // notification receive toggle
        function notificationReceiveToggle(type) {
            // browser push notification
            if(type == "notification_push") {
                // if toggeled for "YES"
                if ($('input[name=push-notification]').is(':checked')) {
                    try {
                        Notification.requestPermission().then(perm => {
                            // if permission is "DENIED"/ user clicks "DENY"
                            if (perm === "denied") {
                                toastFire('warning', 'Browser Notification permission denied. Please Reset permission');
                            }
                            // if permission is "GRANTED"
                            else {
                                const img = "{{asset('front/img/logo-icon-square.png')}}";
                                const title = 'Local Tales';
                                const text = 'HELLO! this is a Push Notification';

                                const notification = new Notification(title, {
                                    body: text,
                                    icon: img
                                });

                                notification.onclick = function () {
                                    window.open("{{url('/')}}");
                                };

                                receivePreferenceAjaxCall(type);
                            }
                        });
                    } catch (e) {
                        return false;
                    }

                    return true;
                }
                // if toggeled for "NO"
                else {
                    receivePreferenceAjaxCall(type);
                }
            }
            // for email & in app notification
            else {
                receivePreferenceAjaxCall(type);
            }
        }

        function receivePreferenceAjaxCall(type) {
            $.ajax({
                url: "{{ route('business.notification.receive.toggle') }}",
                type: "POST",
                data: {
                    '_token': '{{csrf_token()}}',
                    type: type,
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

        // notification types toggle
        function notificationToggle(notificationId) {
            $.ajax({
                url: "{{ route('business.notification.toggle') }}",
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