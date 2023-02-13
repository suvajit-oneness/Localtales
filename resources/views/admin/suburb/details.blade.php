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


    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="tile">
                                <h3 class="my-3 tile-title">Details</h3>
                                <div class="d-flex justify-content-between">
                                    <img src="{{ asset('/admin/uploads/suburb/' . $suburb->image) }}" height="50%"
                                        width="30%">
                                    <div class="d-flex align-items-center mx-4">
                                        <div>
                                            <p class="font-weight-bold">Name: <span
                                                    class="font-weight-bold">{{ $suburb->name }}</span></p>
                                            <p class="font-weight-bold">State: <span
                                                    class="font-weight-light">{{ $suburb->state }}</span>
                                            </p>
                                            <p class="font-weight-bold">Postcode: <span
                                                    class="font-weight-light">{{ $suburb->pin_code }}</span>
                                            </p>
                                            <p class="font-weight-bold">Region: <span
                                                    class="font-weight-light">{{ $suburb->region_name }}</span>
                                            </p>
                                            <p class="font-weight-bold">House: <span
                                                    class="font-weight-light">{{ $suburb->house }}</span>
                                            </p>
                                            <p class="font-weight-bold">Est. Population: <span
                                                    class="font-weight-light">{{ $suburb->population }}</span>
                                            </p>
                                            <p class="font-weight-bold">Description: <span
                                                    class="font-weight-light">{!! $suburb->description !!}</span>
                                            </p>
                                            <p class="font-weight-bold">Meta Title: <span
                                                    class="font-weight-light">{!! $suburb->meta_title !!}</span>
                                            </p>
                                            <p class="font-weight-bold">Meta Description: <span
                                                    class="font-weight-light">{!! $suburb->meta_description !!}</span>
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
@endsection
