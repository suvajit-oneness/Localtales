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
                            <p>Primary Category  : {{ $subcat->subcategory->blogcategory->title }}</p>
                            <p>Secondary Category  : {{ $subcat->subcategory->title }}</p>
                            <p>Tertiary Category  : {{ $subcat->title }}</p>
                            <p> Description : {!! $subcat->description  !!}</p>
                            @if($subcat->image!='')
                            <p>Image : <img src="{{ asset('tertiarycategories/'.$subcat->image) }}" id="blogImage" class="img-fluid" alt=""></p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
