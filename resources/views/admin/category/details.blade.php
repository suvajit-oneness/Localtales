@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
            <p></p>
        </div>
    </div>
    @include('admin.partials.flash')

    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-10">
                            <p>Category : {{ $category->title ?? ''}}</p>
                            <p>Slug : {{ $category->slug ?? ''}}</p>
                            <p>Description : {!! $category->description !!}</p>
                            <p>Short Content : {!! $category->short_content !!}</p>
                            <p>Medium Content : {!! $category->medium_content !!}</p>
                            <p>Long Content : {!! $category->long_content !!}</p>
                            @if($category->image!='')
                            <p>Category Image : <img src="{{ asset('categories/'.$category->image) }}" id="blogImage" class="img-fluid" alt="img"></p>
                            
                            @endif
                             @if($category->medium_content_image!='')
                            <p>Short Content Image : <img src="{{ asset('categories/'.$category->medium_content_image) }}" id="blogImage" class="img-fluid" alt="img"></p>
                            
                            @endif
                            @if($category->long_content_image!='')
                            <p>Long Content Image: <img src="{{ asset('categories/'.$category->long_content_image) }}" id="blogImage" class="img-fluid" alt="img"></p>
                            
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>




@endsection
