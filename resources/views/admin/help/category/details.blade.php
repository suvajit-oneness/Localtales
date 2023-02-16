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

    <div class="row justify-content-center">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <a href="{{ url('admin/helpcategory') }}" class="btn btn-dark">Back</a>
                        </div>
                        <div class="col-md-12">
                            <h3>Category : </h3>
                            <p>{{ $category->title }}</p>
                            <h3>Slug : </h3>
                            <p>{{ $category->slug }}</p>
                            <h3>Description : </h3>
                            <p>{{ $category->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
