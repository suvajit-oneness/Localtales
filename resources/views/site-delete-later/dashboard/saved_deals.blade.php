@extends('site.appprofile')
@section('title') Dashboard @endsection
@section('content')

<div class="row">
    <div class="col-12">
      
          
          <div class="row">
            @foreach($deals as $key => $deal)
            <div class="col-12 col-md-4 col-lg-4 col-sm-4 mb-3">
              <div class="card save-grid">
                <div class="position-relative">
                  @if($deal->deal->image!='')
                  <figure>
                    <div class="category-tag">
                      <img src="{{URL::to('/').'/categories/'}}{{$deal->deal->category->image}}">
                      <p>{{$deal->deal->category->title}}</p>
                    </div>
                    <img src="{{URL::to('/').'/deals/'}}{{$deal->deal->image}}" class="card-img-top" alt="Events">
                  </figure>
                  @endif
                  <div class="img-retting">
                    <!-- <ul>
                      <li><img src="./images/event-star.png"> <span>4.5</span> (60 reviews)</li>
                      <li>|</li>
                      <li><i class="far fa-comment-dots"></i> 40 Comments</li>
                    </ul> -->
                  </div>
                </div>
                <div class="card-body event-body">
                  <h5 class="card-title">{{$deal->deal->title}}</h5>
                  <h6><i class="fas fa-map-marker-alt"></i> {{$deal->deal->address}}</h6>
                  <p class="card-text">{!!strip_tags(substr($deal->deal->short_description,0,200))!!}...</p>
                  <a href='{!! URL::to('deal-details/'.$deal->deal->id.'/'.strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $deal->deal->title))) !!}' target="_blank" class="text-dark"> View Details</a> | <a href="{{ route('site.dashboard.deal.delete', $deal->deal->id) }}"  onclick="return confirm('Are you sure that you want to remove this deal?')" class="text-danger">Delete</a>
                  
                </div>
              </div>
            </div>
            @endforeach
            
      </div>
    </div>
  </div>
@endsection