@extends('site.appprofile')
@section('title') Notfications @endsection

@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-dashboard"></i> Notfications</h1>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse($notifications as $key => $item)
            <div class="col-12 mb-3">
                <div class="card save-grid">
                    <div class="card-body event-body">
                        <h5 class="card-title">{{$item->title}}</h5>
                        <p class="card-text">{!! $item->description !!}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="small text-muted">No Notifications yet</p>
                <a href="{{ url('/dashboard') }}" class="btn btn-danger">Go to Dashboard</a>
            </div>
        @endforelse
    </div>
@endsection
