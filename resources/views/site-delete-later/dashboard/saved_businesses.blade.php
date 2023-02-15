@extends('site.appprofile')
@section('title') Dashboard @endsection
@section('content')

<div class="row">
    <div class="col-12">

          <div class="row">
            @foreach($businesses as $key => $business)
            <div class="col-12 col-md-4 col-lg-4 col-sm-4 mb-3" style="padding-left:30px">
              <div class="card save-grid">
                <div class="position-relative">
                  <div class="img-retting">
                    <!-- <ul>
                      <li><img src="./images/event-star.png"> <span>4.5</span> (60 reviews)</li>
                      <li>|</li>
                      <li><i class="far fa-comment-dots"></i> 40 Comments</li>
                    </ul> -->
                  </div>
                </div>
                <div class="card-body event-body">
                  <h5 class="card-title">{{$business->directory->name}}</h5>
                    <p>{!! directoryCategory($business->directory->category_id) !!}</p>
                  <h6><i class="fas fa-map-marker-alt"></i> {{$business->directory->address}}</h6>
                  <p class="card-text">{!!strip_tags(substr($business->directory->description,0,200))!!}</p>
                  <a href='{!! URL::to('directory/'.$business->directory->slug) !!}' target="_blank" class="text-dark">View Details</a>

                </div>
              </div>
            </div>
            @endforeach

      </div>
    </div>

</div>
@endsection
