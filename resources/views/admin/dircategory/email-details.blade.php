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
                        <div class="col-12 mb-3">
                            <img src="{{URL::to('/').'/categories/'}}{{$category->parent_category_image}}"  height="100px">
                        </div>
                        <div class="col-12">
                            <p class="text-muted font-weight-bold">Category: <span class="text-dark">{{ $category->parent_category }}</span></p>
                            <p class="text-muted font-weight-bold">Email Template:</p>
                            {!! $category->parent_category_email_template ? $category->parent_category_email_template : '<p class="text-danger">Not added</p>' !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
