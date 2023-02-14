@extends('site.appprofile')
@section('title') Notification setup @endsection

@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-dashboard"></i> Notification setup</h1>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="notification-content">
                <div class="alert alert-light notification-box" role="alert">

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
                                        <input type="checkbox" {{ (count($notification['notification_receive_user']) > 0) ? 'checked' : '' }} onchange="here()">
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
@endsection

@push('scripts')
    <script>
        function here() {
            alert()
        }
    </script>
@endpush