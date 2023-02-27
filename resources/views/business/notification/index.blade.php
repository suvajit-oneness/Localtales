@extends('business.app')
@section('title') Notification @endsection

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file"></i> Notification</h1>
            <p>List of all Notifications</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body all-notifications">
                    <div class="preference text-right mb-3">
                        @if($totalUnreadNotifications > 0)
                            <a href="{{ route('business.notification.mark-all-read') }}" class="btn btn-secondary" onclick="return confirm('Are you sure ?')">
                                <i class="fa fa-check"></i>
                                Mark all As Read
                            </a>
                        @endif

                        <a href="{{ route('business.notification.setup') }}" class="btn btn-secondary">
                            <i class="fa fa-cogs"></i>
                            Setup Notification Preference
                        </a>
                    </div>

                    @forelse ($data as $index => $noti)
                        <a href="javascript:void(0)" class="dropdown-item my-2 {{ $noti->read_flag == 0 ? 'unread' : 'read' }}" onclick="readNotification({{ $noti->id }}, '{{ $noti->route }}')">
                            <div class="d-flex">
                                <p class="mb-0 mr-3"><strong class="text-dark">{{ $index + $data->firstItem() }}</strong></p>
                                <div class="noti">
                                    <p class="mb-0">{!! $noti->title !!}</p>
                                    <p class="small mb-0">{!! $noti->description !!}</p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <p class="small text-muted text-center my-5">No notifications yet</p>
                    @endforelse

                    <div class="d-flex justify-content-end">
                        {{$data->appends($_GET)->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function notificationReceiveToggle(type) {
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