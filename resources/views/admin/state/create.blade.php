@extends('admin.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}
                    <span class="top-form-btn">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save
                            State</button>
                        <a class="btn btn-secondary" href="{{ route('admin.state.index') }}"><i
                                class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('admin.state.store') }}" method="post" role="form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name"> Name <span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                                id="name" value="{{ old('name') }}" />
                            @error('name')
                                {{ $message ?? '' }}
                            @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="short_code"> Short Code <span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control @error('short_code') is-invalid @enderror" type="text" name="short_code"
                                id="short_code" value="{{ old('short_code') }}" />
                            @error('short_code')
                                {{ $message ?? '' }}
                            @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="image"> Select Image <span class="m-l-5 text-danger">
                                    *</span></label>
                                    <p class="small text-danger mb-2">Size must be less than 200kb</p>
                            <input class="form-control @error('image') is-invalid @enderror" type="file" name="image"
                                id="image" value="{{ old('image') }}" />
                            @error('image')
                                {{ $message ?? '' }}
                            @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save
                            State</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.state.index') }}"><i
                                class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
