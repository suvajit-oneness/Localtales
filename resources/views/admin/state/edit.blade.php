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
                <h3 class="tile-title">{{ $subTitle }}</h3>
                <img src="{{ asset('/admin/uploads/state/images/' . $targetstate->image) }}" height="50%" width="35%">
                <form action="{{ route('admin.state.update') }}" method="POST" role="form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Name <span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                                id="name" value="{{ old('name', $targetstate->name) }}" />
                            <input type="hidden" name="id" value="{{ $targetstate->id }}">
                            @error('name')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="short_code">Short Code <span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control @error('short_code') is-invalid @enderror" type="text" name="short_code"
                                id="short_code" value="{{ old('short_code', $targetstate->short_code) }}" />
                            @error('short_code')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="image"> Select Image <span class="m-l-5 text-danger">
                                    *</span></label>
                                    <p class="small text-danger mb-2">Size must be less than 200kb</p>
                            <input class="form-control" type="file" name="image" id="image" />
                        </div>
                    </div>

                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update
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
