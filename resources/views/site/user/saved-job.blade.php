@extends('site.appprofile')
@section('title') Saved Job @endsection

@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-dashboard"></i> Saved Job</h1>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse($jobs as $key => $item)
            <div class="col-12 col-md-4 col-lg-4 col-sm-4 mb-3" style="padding-left:30px">
                <div class="card save-grid">
                    <div class="card-body event-body">
                        <h5 class="card-title">{{ $item->job->title ?? ''}}</h5>

                        <h6>
                            <i class="fas fa-map-marker-alt"></i>
                            {{$item->job->postcode ? $item->job->postcode : ''}}{{$item->job->suburb ? ', '.$item->job->suburb : ''}}{{$item->job->state ? ', '.$item->job->state : ''}}
                        </h6>

                        <p class="card-text">{!! strip_tags(substr($item->job->description, 0, 200)) !!}</p>

                        <a href='{!! URL::to('jobs/'.$item->job->slug) !!}' target="_blank" class="mt-2 btn btn-danger">View Details</a>
                        {{-- <a href='{{route('site.dashboard.job.delete',$item->job->slug) }}' target="_blank" class="mt-2 btn btn-danger">Delete</a> --}}
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="small text-muted">No Jobs saved yet</p>
                <a href="{{ url('/jobs') }}" class="btn btn-danger">Go to Jobs</a>
            </div>
        @endforelse
    </div>
@endsection
