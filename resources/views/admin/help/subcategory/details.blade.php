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
                            <h3>Sub Category : {{ $subcategory->title }}</h3>
                            <h3> Category : {{ $subcategory->helpcategory ? $subcategory->helpcategory->title : '' }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>




@endsection
