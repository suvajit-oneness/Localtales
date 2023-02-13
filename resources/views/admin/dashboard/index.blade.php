@extends('admin.app')
@section('title') Dashboard @endsection
@section('content')

<style type="text/css">
    .row-md-body.no-nav {
    margin-top: 70px;
}
</style>

<div class="fixed-row">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
        </div>
    </div>
</div>

{{-- state, suburb, postcode, directory, 
collection, category, sub-category, articles --}}

<div class="row section-mg row-md-body no-nav mt-5">
    <a href="{{route('admin.users.index')}}" class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon">
            <i class="icon fa fa-users fa-3x"></i>
            <div class="info">
                <h4>Active Users</h4>
                <p><b> {{CountUsers()}} </b></p>
            </div>
        </div>
    </a>


    <a href="{{route('admin.state.index')}}" class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon">
            <i class="icon fa fa-star fa-3x"></i>
            <div class="info">
                <h4>State</h4>
                <p><b> {{CountState()}} </b></p>
            </div>
        </div>
    </a>


    <a href="{{route('admin.suburb.index')}}" class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon">
            <i class="icon fa fa-files-o fa-3x"></i>
            <div class="info">
                <h4>Suburb</h4>
                <p><b> {{CountSuburb()}} </b></p>
            </div>
        </div>
    </a>

    <a href="{{route('admin.pin.index')}}" class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon">
            <i class="icon fa fa-files-o fa-3x"></i>
            <div class="info">
                <h4>Post Codes</h4>
                <p><b> {{CountPostcode()}} </b></p>
            </div>
        </div>
    </a>
    <a href="{{route('admin.directory.index')}}" class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon">
            <i class="icon fa fa-files-o fa-3x"></i>
            <div class="info">
                <h4>Directory</h4>
                <p><b> {{CountDirectory()}} </b></p>
            </div>
        </div>
    </a>
    <a href="{{route('admin.collection.index')}}" class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon">
            <i class="icon fa fa-files-o fa-3x"></i>
            <div class="info">
                <h4>Collection</h4>
                <p><b> {{CountCollection()}} </b></p>
            </div>
        </div>
    </a>
    <a href="{{route('admin.category.index')}}" class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon">
            <i class="icon fa fa-files-o fa-3x"></i>
            <div class="info">
                <h4>Category</h4>
                <p><b> {{CountCategory()}} </b></p>
            </div>
        </div>
    </a>
    <a href="{{route('admin.subcategory.index')}}" class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon">
            <i class="icon fa fa-files-o fa-3x"></i>
            <div class="info">
                <h4>Sub Category</h4>
                <p><b> {{CountSubCategory()}} </b></p>
            </div>
        </div>
    </a>
    <a href="{{route('admin.blog.index')}}" class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon">
            <i class="icon fa fa-files-o fa-3x"></i>
            <div class="info">
                <h4>Articles</h4>
                <p><b> {{CountArticles()}} </b></p>
            </div>
        </div>
    </a>

</div>
@endsection
