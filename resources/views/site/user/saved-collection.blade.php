@extends('site.appprofile')
@section('title') Saved Collection @endsection

@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-dashboard"></i> Saved Collection</h1>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse($collection as $key => $item)
            <div class="col-12 col-md-4 col-lg-4 col-sm-4 mb-3">
                <div class="card save-grid">
                    <div class="position-relative">
                        <figure>
                            <img src="{{URL::to('/').'/Collection/'}}{{$item->collection->image ?? ''}}" class="card-img-top" alt="">
                        </figure>
                    </div>
                    <div class="card-body event-body">
                        <h5 class="card-title">{{$item->collection->title ?? ''}}</h5>
                        <h6><i class="fas fa-map-marker-alt"></i> {{$item->collection->suburb ?? ''}}</h6>
                        <h6><i class="fas fa-tag"></i>{{$item->collection->category ?? ''}}</h6>
                        <a type="button" href='{!! URL::to('collection/'.$item->collection->slug) !!}' target="_blank" class="mt-2 btn btn-danger">View Details</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="small text-muted">No Collection saved yet</p>
                <a href="{{ url('/collection') }}" class="btn btn-danger">Go to Collection</a>
            </div>
        @endforelse
    </div>
@endsection
