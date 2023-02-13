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
                                    <img src="{{ asset('/admin/uploads/state/images/' . $state->image) }}" height="50%"
                                        width="35%">
                                    <div class="d-flex align-items-center mx-4">
                                        <div>
                                            <p class="font-weight-bold">Name: <span
                                                    class="font-weight-bold">{{ $state->name }}</span></p>
                                            <p class="font-weight-bold">Short Code: <span
                                                    class="font-weight-bold">{{ $state->short_code }}</span></p>
                                            <p class="font-weight-bold">Slug: <span
                                                    class="font-weight-light">{{ $state->slug }}</span>
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
