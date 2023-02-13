@extends('admin.app')

@section('page', 'Settings detail')

@section('content')
<section>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="text-muted small mb-1">Page</p>
                            <p class="text-dark small">{{strtoupper($splash->key)}}</p>
                            <p class="text-muted small mb-1">Name</p>
                            <p class="text-dark small">{!! $splash->pretty_name !!}</p>
                            <p class="text-muted small mb-1">Content</p>
                            <p class="text-dark small">{!! $splash->content !!}</p>
                            <p class="text-muted small mb-1">Content1</p>
                            <p class="text-dark small">{!! $splash->content1 !!}</p>
                            <p class="text-muted small mb-1">Content2</p>
                            <p class="text-dark small">{!! $splash->content2 !!}</p>
                            <p class="text-muted small mb-1">Banner Image</p>
                            <p class="text-dark small">@if($splash->banner_image!='')
                                <img style="width: 100px;height: 100px;" src="{{URL::to('/').'/SplashBanner/'}}{{$splash->banner_image}}">
                                @endif</p>
                            <p class="text-muted small mb-1">Image Field</p>
                            <p class="text-dark small">@if($splash->image!='')
                                <img style="width: 70px;height: 70px;" src="{{URL::to('/').'/Extra/'}}{{$splash->image}}">
                                @endif</p>
                                <p class="text-muted small mb-1">Extra Image</p>
                            <p class="text-dark small">@if($splash->image2!='')
                                <img style="width: 100px;height: 100px;" src="{{URL::to('/').'/Splash/'}}{{$splash->image2}}">
                                @endif</p>
                                <p class="text-muted small mb-1">Logo Image</p>
                                <p class="text-dark small">@if($splash->logo!='')
                                    <img style="width: 100px;height: 100px;" src="{{URL::to('/').'/ContactusBanner/'}}{{$splash->logo}}">
                                    @endif</p>
                        </div>
                    </div>

                </div>
            </div>
            <a class="btn btn-secondary" href="{{ route('admin.forntendcollection.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Back</a>
        </div>


    </div>
</section>
@endsection
