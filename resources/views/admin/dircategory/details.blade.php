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
                            <p class="text-muted font-weight-bold">Title: <span class="text-dark">{{ $category->parent_category }}</span></p>

                            <p class="text-muted font-weight-bold">Slug: <span class="text-dark">{{ $category->parent_category_slug }}</span></p>

                            <p class="text-muted font-weight-bold">Description:</p>
                            {!! $category->description ? $category->description : '<p class="text-danger">Not added</p>' !!}

                            <p class="text-muted font-weight-bold">Short content:</p>
                            {!! $category->short_content ? $category->short_content : '<p class="text-danger">Not added</p>' !!}

                            <p class="text-muted font-weight-bold">Medium content:</p>
                            {!! $category->medium_content ? $category->medium_content : '<p class="text-danger">Not added</p>' !!}

                            <p class="text-muted font-weight-bold">Long content:</p>
                            {!! $category->long_content ? $category->long_content : '<p class="text-danger">Not added</p>' !!}
                            <p class="text-muted font-weight-bold">Meta Title:</p>
                            {!! $category->meta_title ? $category->meta_title : '<p class="text-danger">Not added</p>' !!}
                            <p class="text-muted font-weight-bold">Meta Description:</p>
                            {!! $category->meta_description ? $category->meta_description : '<p class="text-danger">Not added</p>' !!}

                        </div>

                        {{-- <div class="col-md-10">
                            <div class="tile">
                                <h3 class="my-3 tile-title">Details</h3>
                                <div class="d-flex justify-content-between">
                                    <img src="{{ asset('/admin/uploads/directorycategory/images/' . $category->image) }}" height="200px">
                                    <div class="d-flex align-items-center mx-4">
                                        <div>
                                            <p class="font-weight-bold">Title: <span class="font-weight-bold">{{ $category->parent_category }}</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
