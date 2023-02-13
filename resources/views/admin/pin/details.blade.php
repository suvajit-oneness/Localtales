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
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="tile">
                                <h3 class="my-3 tile-title">Details</h3>
                                <div class="d-flex justify-content-between">
                                        @if(!$pin->image)
                                            <img src="{{ asset('/Directory/placeholder-image.png') }}"
                                            height="50%"
                                        width="35%">
                                            @else
                                            <img src="{{ asset('/admin/uploads/pincode/images/' . $pin->image) }}"
                                            height="50%"
                                            width="35%">
                                            @endif
                                    <div class="d-flex align-items-center mx-4">
                                        <div>
                                            <p class="font-weight-bold">Postcode: <span
                                                    class="font-weight-bold">{{ $pin->pin }}</span></p>
                                            <p class="font-weight-bold">State: <span
                                                    class="font-weight-light">{{ $pin->state ? $pin->state->name : '' }}</span>
                                            </p>
                                            <p class="font-weight-bold">Description: <span
                                                    class="font-weight-light">{{ $pin->description }}</span>
                                            </p>
                                            <p class="font-weight-bold">Meta Title: <span
                                                    class="font-weight-light">{{ $pin->meta_title }}</span>
                                            </p>
                                            <p class="font-weight-bold">Meta Description: <span
                                                    class="font-weight-light">{{ $pin->meta_description }}</span>
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
    <a class="btn btn-primary" href="{{ route('admin.pin.index') }}">Back</a>
@endsection
