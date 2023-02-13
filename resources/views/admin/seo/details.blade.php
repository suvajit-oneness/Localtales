@extends('admin.app')
@section('title','SEO')
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file"></i> SEO</h1>
            <p></p>
        </div>
    </div>
    @include('admin.partials.flash')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="tile">
                                <h3 class="my-3 tile-title">Details</h3>
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex align-items-center mx-4">
                                        <div>
                                            <p class="font-weight-bold">Page: <span
                                                    class="font-weight-bold">{{ $data->page }}</span></p>
                                            <p class="font-weight-bold">Title: <span
                                                    class="font-weight-light">{{ $data->title ??'' }}</span>
                                            </p>
                                            <p class="font-weight-bold">Description: <span
                                                    class="font-weight-light">{!! $data->meta_desc !!}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <a class="btn btn-primary" href="{{ route('admin.seo.index') }}">Back</a>
@endsection
