@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
            <p>{{ $subTitle }}</p>
        </div>
    </div>
    @include('admin.partials.flash')

    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-10">
                            <p> Primary Category : {{ $subcategory->blogcategory ? $subcategory->blogcategory->title : '' }}</p>
                            <p>Secondary Category : {{ $subcategory->title }}</p>
                            <p> Description : {!! $subcategory->description  !!}</p>
                            @if($subcategory->image!='')
                            <p>Image : <img src="{{ asset('subcategories/'.$subcategory->image) }}" id="blogImage" class="img-fluid" alt=""></p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>




@endsection
