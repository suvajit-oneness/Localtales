@extends('admin.app')
@section('title')
    {{ $pageTitle }}
@endsection

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
            <p></p>
        </div>
    </div>

    @include('admin.partials.flash')

    <div class="row justify-content-center">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header text-right">
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark">< Back</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        
                        <div class="col-12">
                            <p class="text-muted font-weight-bold">Module: <span class="text-dark">{{ ucwords($email->type) }}</span></p>

                            <p class="text-muted font-weight-bold">Subject: <span class="text-dark">{{ $email->subject }}</span></p>
                            <p class="text-muted font-weight-bold">Body:</p>
                            @if($email->is_image==1)
                            <img style="width: 150px;height: 100px;" src="{{URL::to('/').'/email/'}}{{$email->body}}">
                            @else
                            {!! $email->body ? $email->body : '<p class="text-danger">Not added</p>' !!}
                            @endif

                        </div>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
