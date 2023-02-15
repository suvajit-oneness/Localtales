@extends('site.appprofile')
@section('title') Saved Directories @endsection

@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-dashboard"></i> Saved Directories</h1>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse($businesses as $key => $item)
            <div class="col-12 col-md-4 col-lg-4 col-sm-4 mb-3" style="padding-left:30px">
                <div class="card save-grid">
                    <div class="card-body event-body">
                        <h5 class="card-title">{{$item->directory->name}}</h5>
                        <p>{!! directoryCategory($item->directory->category_id) !!}</p>
                        <h6><i class="fas fa-map-marker-alt"></i> {{$item->directory->address}}</h6>
                        <p class="card-text mb-0">{!!strip_tags(substr($item->directory->description,0,200))!!}</p>
                        <a href='{!! URL::to('directory/'.$item->directory->slug) !!}' target="_blank" class="mt-2 btn btn-danger">View Details</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="small text-muted">No Directory saved yet</p>
                <a href="{{ url('/directory') }}" class="btn btn-danger">Go to Directory</a>
            </div>
        @endforelse
    </div>
@endsection
