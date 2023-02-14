@extends('site.appprofile')
@section('title') Dashboard @endsection
@section('content')

  <div class="row">
    <div class="col-12">
          <div class="row">
            @foreach($collection as $key => $event)
            <div class="col-12 col-md-4 col-lg-4 col-sm-4 mb-3" style="padding-left:30px">
              <div class="card save-grid">
                <div class="position-relative">

                  <figure>
                    {{-- <div class="category-tag">
                      <img src="{{URL::to('/').'/categories/'}}{{$event->event->category->image}}">
                      <p>{{$event->event->category->title ?? ''}}</p>
                    </div> --}}
                    <img src="{{URL::to('/').'/Collection/'}}{{$event->collection->image ?? ''}}" class="card-img-top" alt="">
                  </figure>

                  <div class="img-retting">
                    <!-- <ul>
                      <li><img src="./images/event-star.png"> <span>4.5</span> (60 reviews)</li>
                      <li>|</li>
                      <li><i class="far fa-comment-dots"></i> 40 Comments</li>
                    </ul> -->
                  </div>
                </div>
                <div class="card-body event-body">
                  <h5 class="card-title">{{$event->collection->title ?? ''}}</h5>
                  <h6><i class="fas fa-map-marker-alt"></i> {{$event->collection->suburb ?? ''}}</h6>
                  <h6><i class="fas fa-tag"></i>{{$event->collection->category ?? ''}}</h6>
                  <a type="button" href='{!! URL::to('collection/'.$event->collection->slug) !!}' target="_blank" class="btn btn-login text-center">View Details</a>
                </div>
              </div>
            </div>
            @endforeach

          </div>
    </div>
  </div>

@endsection
