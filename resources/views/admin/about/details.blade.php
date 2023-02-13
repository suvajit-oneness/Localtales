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
                            <p class="text-dark small">{{strtoupper($about->key)}}</p>
                            <p class="text-muted small mb-1">Name</p>
                            <p class="text-dark small">{{strtoupper($about->pretty_name)}}</p>
                            <p class="text-muted small mb-1">Content</p>
                            <p class="text-dark small">{!! $about->content !!}</p>
                            <p class="text-muted small mb-1">Content1</p>
                            <p class="text-dark small">{!! $about->content1 !!}</p>
                            <p class="text-muted small mb-1">Content2</p>
                            <p class="text-dark small">{!! $about->content2 !!}</p>
                            <p class="text-muted small mb-1">Banner Image</p>
                            <p class="text-dark small">@if($about->banner_image!='')
                                <img style="width: 100px;height: 100px;" src="{{URL::to('/').'/AboutusBanner/'}}{{$about->banner_image}}">
                                @endif</p>
                            <p class="text-muted small mb-1">Image Field</p>
                            <p class="text-dark small">@if($about->image!='')
                                <img style="width: 70px;height: 70px;" src="{{URL::to('/').'/Aboutus/'}}{{$about->image}}">
                                @endif</p>
                        </div>
                    </div>

                </div>

            </div>
            <br>
            <a class="btn btn-secondary" href="{{ route('admin.about-us.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Back</a>
        </div>


    </div>
</section>
@endsection
